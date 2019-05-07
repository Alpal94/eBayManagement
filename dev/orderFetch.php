<?php

class Management {
	private $useSample;
	private $sampleResult;
	private $accessToken;
	private $db;
	private $octoPiAPIKey;

	public function __construct() {
		include 'sampleXML.php';
		include 'config.php';
		$this->db = $db;
		$this->accessToken = $accessToken;
		$this->useSample = $useSample;
		$this->sampleResult = $sampleResult;
		$this->octoPiAPIKey = $octoPiAPIKey;
		$this->telegramAPIKey = $telegramAPIKey;
		$this->telegramChannelID = $telegramChannelID;
	}

	function processOrders() {
		$xmlOrders = $this->useSample ? $this->sampleResult : getOrder($this->accessToken);
		$xmlOrders=simplexml_load_string($xmlOrders) or die("Error: Cannot create object");

		if(isset($xmlOrders->TransactionArray->Transaction)) {
			foreach($xmlOrders->TransactionArray->Transaction as $orders) {
				$sql = "SELECT TransactionID FROM Orders WHERE TransactionID='".$orders->Item->ItemID."$orders->TransactionID'";
				$order = $this->db->query($sql);
				$this->printShippingLabel($orders);
				if($order->num_rows == 0) {
					$this->telegramMessage("New order received: " . $orders->Item->ItemID.$orders->TransactionID . " Quantity: $orders->QuantityPurchased");
					$this->insertRecord($orders);
					$this->pushPrintJobToQueue($orders);
				} else {
					echo "Item exists in database and is in line for processing\n";
				}
			}	
		} else {
			echo "ERROR: No orders available";
		}
	}

	function pushPrintJobToQueue($orders) {
		$product = $this->db->query("SELECT `Folder`, `PrintDuration` FROM Products WHERE ItemID=".$orders->Item->ItemID);
		$data = mysqli_fetch_assoc($product);
		$folder = $data["Folder"];
		$printDuration = $data["PrintDuration"];
		$transactionID =  $orders->Item->ItemID."$orders->TransactionID";
		$quantity = $orders->QuantityPurchased;
		$time = strtotime('now');

		for($i = 0; $i < $quantity; $i++) {
			$productID = "$i$transactionID";
			$sql = "INSERT INTO `ActiveOrders` (`ItemID`, `Folder`, `PrintDuration`, `StartTime`, `TransactionID`, `ProductID`, `CreatedAt`, `Active`) VALUES (".$orders->Item->ItemID.", '$folder', $printDuration, 0, '$transactionID', '$productID', $time, false)\n";
			echo $sql;

			$insert = $this->db->query($sql);
			if($insert) {
				echo "INSERT JOB QUEUE: SUCCESS\n";
			} else {
				$orderNumber = $i + 1;
				$error = $this->db->error;
				$this->telegramMessage("ActivateOrders: Error activating $productID order number #$orderNumber into database: $error");
			}
		}

	}

	function insertRecord($orders) {
		$sql = "INSERT INTO `Orders` (`ItemID`, `CreatedAt`, `TransactionID`, `QuantityPurchased`) VALUES (".$orders->Item->ItemID.", '$orders->CreatedDate', '".$orders->Item->ItemID."$orders->TransactionID', $orders->QuantityPurchased)\n";
		$insert = $this->db->query($sql);
		if($insert) {
			echo "INSERT RECORD: SUCCESS\n";
		} else {
			$error = $this->db->error;
			$transactionID = $orders->Item->ItemID.$orders->TransactionID;
			$this->telegramMessage("Orders: Error inserting $transactionID record into database: $error");
		}

	}

	function getOrder() {
		$crl = curl_init();

		$request = "GetSellerTransactionsRequest"; 

		date_default_timezone_set("UTC");
		$date = new DateTime();
		$dateFrom = str_replace("_", "T", date("Y-m-d_H:i:s", $date->getTimestamp() - 60*60*24))."Z";
		$dateTo = str_replace("_", "T", date("Y-m-d_H:i:s"))."Z";
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?><$request xmlns=\"urn:ebay:apis:eBLBaseComponents\"><DetailLevel>ReturnAll</DetailLevel><ModTimeFrom>$dateFrom</ModTimeFrom><ModTimeTo>$dateTo</ModTimeTo><RequesterCredentials><eBayAuthToken>$this->accessToken</eBayAuthToken></RequesterCredentials></$request>";

		$headers = Array(
			"Content-Type: text/xml",
			"X-EBAY-API-COMPATIBILITY-LEVEL: 1081",
			"X-EBAY-API-CALL-NAME: GetSellerTransactions",
			"X-EBAY-API-SITEID: 0"
		);

		curl_setopt($crl, CURLOPT_URL, "https://api.sandbox.ebay.com/ws/api.dll");
		curl_setopt($crl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($crl, CURLOPT_POST, 1);
		curl_setopt($crl, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);

		$rest = curl_exec($crl);

		curl_close($crl);

		return $rest;
	}

	function sendTo3DPrinter($file) {
		$crl = curl_init();

		$headers = Array(
			"Content-Type: application/json",
			"X-Api-Key: $this->octoPiAPIKey"
		);
		
		$command = "";

		curl_setopt($crl, CURLOPT_URL, "https://api.sandbox.ebay.com/ws/api.dll");
		curl_setopt($crl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($crl, CURLOPT_POST, 1);
		curl_setopt($crl, CURLOPT_POSTFIELDS, $command);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);

		$rest = curl_exec($crl);

		curl_close($crl);

		return $rest;

	}

	function printShippingLabel($orders) {
		$buyer = $orders->Buyer->BuyerInfo->ShippingAddress;
		echo "$buyer->Name\n";
		echo "$buyer->Street1\n";
		echo "$buyer->StateOrProvince\n";
		echo "$buyer->CityName\n";
		echo "$buyer->CountryName\n";
		echo "$buyer->PostalCode\n";
		$details = "
			<Buyer>
				<BuyerInfo>
				  <ShippingAddress>
				    <Name>Bountiful Buyer</Name>
				    <Street1>123 Gharky Lane</Street1>
				    <CityName>Walla Walla</CityName>
				    <StateOrProvince>WA</StateOrProvince>
				    <Country>US</Country>
				    <CountryName>United States</CountryName>
				    <Phone>(408) 123-2344</Phone>
				    <PostalCode>99362</PostalCode>
				    <AddressID>5244731</AddressID>
				    <AddressOwner>eBay</AddressOwner>
				  </ShippingAddress>
				</BuyerInfo>
			</Buyer>";
	}

	function telegramMessage($message) {
		file_get_contents("https://api.telegram.org/bot$this->telegramAPIKey/sendMessage?chat_id=$this->telegramChannelID&text=$message");
	}
}

$management = new Management();
$management->processOrders();

?>
