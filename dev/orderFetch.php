<?php

include 'ausPost.php';

class Management {
	private $useSample;
	private $sampleResult;
	private $accessToken;
	private $db;
	private $octoPiAPIKey;
	private $ausPost;

	public function __construct() {
		include 'config.php';
		$this->db = $db;
		$this->useSample = $useSample;
		$this->accessToken = $accessToken;
		$this->octoPiAPIKey = $octoPiAPIKey;
		$this->telegramAPIKey = $telegramAPIKey;
		$this->telegramChannelID = $telegramChannelID;
		$this->eBayAPIUrl = $eBayAPIUrl;
		$this->production = $production;

		if($this->useSample) {
			include 'sampleXML.php';
			$this->sampleResult = $sampleResult;
		}
	}

	function processOrders() {
		$xmlOrders = $this->useSample && !$this->production ? $this->sampleResult : $this->getOrder(3);
		$xmlOrders=simplexml_load_string($xmlOrders) or die("Error: Cannot create object");
		
		if(isset($xmlOrders->TransactionArray->Transaction)) {
			foreach($xmlOrders->TransactionArray->Transaction as $orders) {
				$transactionID = $orders->Item->ItemID.$orders->TransactionID;
				$sql = "SELECT TransactionID FROM Orders WHERE TransactionID='$transactionID'";
				$order = $this->db->query($sql);
				if($order->num_rows == 0) {
					$this->telegramMessage("New order received: " . $transactionID . " Quantity: $orders->QuantityPurchased");
					$this->insertRecord($orders);
					$this->pushPrintJobToQueue($orders);

					$this->printShippingLabel($orders, $transactionID);
				} else {
				}
			}	
		} else {
		}
	}

	function reprintLabelsDaysAgo($command) {
		echo $command;
		$xmlOrders = $this->useSample && !$this->production ? $this->sampleResult : $this->getOrder(3);
		$xmlOrders=simplexml_load_string($xmlOrders) or die("Error: Cannot create object");
		
		if(isset($xmlOrders->TransactionArray->Transaction)) {
			foreach($xmlOrders->TransactionArray->Transaction as $orders) {
				$transactionID = $orders->Item->ItemID.$orders->TransactionID;
				if(isset($command) && $command == 'echo') {
					$this->echoPrintShippingLabelMetadata($orders, $transactionID);
				}
				if(isset($command) && $command == 'print') {
					$this->printShippingLabel($orders, $transactionID);
				}
			}	
		} else {
		}
	}

	function devProcessOrders() {
		$xmlOrders = $this->useSample ? $this->sampleResult : $this->getOrder(3);
		$xmlOrders=simplexml_load_string($xmlOrders) or die("Error: Cannot create object");

		if(isset($xmlOrders->TransactionArray->Transaction)) {
			foreach($xmlOrders->TransactionArray->Transaction as $orders) {
				$transactionID = $orders->Item->ItemID.$orders->TransactionID;
				$this->printShippingLabel($orders, $transactionID);
			}	
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
		$buyerName = strval($orders->Buyer->BuyerInfo->ShippingAddress->Name);
		$buyerID = strval($orders->Buyer->UserID);
		var_dump($buyerName);
		var_dump($buyerID);
		$sql = "INSERT INTO `Orders` (`ItemID`, `CreatedAt`, `TransactionID`, `QuantityPurchased`, `BuyerID`, `BuyerName`) VALUES (".$orders->Item->ItemID.", '$orders->CreatedDate', '".$orders->Item->ItemID."$orders->TransactionID', $orders->QuantityPurchased, '$buyerID',  '$buyerName')\n";
		echo $sql;
		$insert = $this->db->query($sql);
		if($insert) {
			echo "INSERT RECORD: SUCCESS\n";
		} else {
			$error = $this->db->error;
			$transactionID = $orders->Item->ItemID.$orders->TransactionID;
			$this->telegramMessage("Orders: Error inserting $transactionID record into database: $error");
		}

	}

	function getOrder($daysAgo) {
		$crl = curl_init();

		$request = "GetSellerTransactionsRequest"; 

		date_default_timezone_set("UTC");
		$date = new DateTime();
		$dateFrom = str_replace("_", "T", date("Y-m-d_H:i:s", $date->getTimestamp() - $daysAgo*60*60*24))."Z";
		$dateTo = str_replace("_", "T", date("Y-m-d_H:i:s"))."Z";
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?><$request xmlns=\"urn:ebay:apis:eBLBaseComponents\"><DetailLevel>ReturnAll</DetailLevel><ModTimeFrom>$dateFrom</ModTimeFrom><ModTimeTo>$dateTo</ModTimeTo><RequesterCredentials><eBayAuthToken>$this->accessToken</eBayAuthToken></RequesterCredentials><RequesterCredentials><eBayAuthToken>$this->accessToken</eBayAuthToken></RequesterCredentials></$request>";
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?><$request xmlns=\"urn:ebay:apis:eBLBaseComponents\"><DetailLevel>ReturnAll</DetailLevel><ModTimeFrom>$dateFrom</ModTimeFrom><ModTimeTo>$dateTo</ModTimeTo><RequesterCredentials><eBayAuthToken>$this->accessToken</eBayAuthToken></RequesterCredentials><RequesterCredentials><eBayAuthToken>$this->accessToken</eBayAuthToken></RequesterCredentials></$request>";
			
			
		

		$headers = Array(
			"Content-Type: text/xml",
			"X-EBAY-API-COMPATIBILITY-LEVEL: 1081",
			"X-EBAY-API-CALL-NAME: GetSellerTransactions",
			"X-EBAY-API-SITEID: 0"
		);

		curl_setopt($crl, CURLOPT_URL, $this->eBayAPIUrl);
		curl_setopt($crl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($crl, CURLOPT_POST, 1);
		curl_setopt($crl, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);

		$rest = curl_exec($crl);

		curl_close($crl);

		return $rest;
	}

	function sendMessageToBuyer($transactionID) {
		$crl = curl_init();

		$requestHeader = "AddMemberMessageAAQToPartner"; 
		$request = "AddMemberMessageAAQToPartnerRequest"; 

		$transactionInformation = mysqli_fetch_assoc($this->db->query("SELECT `ItemID`, `BuyerID`, `BuyerName` FROM Orders WHERE TransactionID=".$transactionID));

		$itemID = $transactionInformation['ItemID'];
		$name = $transactionInformation['BuyerName'];
		$recipientID = $transactionInformation['BuyerID'];

		$product = $this->db->query("SELECT `Description` FROM Products WHERE ItemID=". $itemID);
		$data = mysqli_fetch_assoc($product);
		$productDescription = $data["Description"];
		echo $recipientID;
		echo $itemID;
		echo $name;
		var_dump($productDescription);

		$xml = '<?xml version="1.0" encoding="utf-8"?>
				<'.$request.' xmlns="urn:ebay:apis:eBLBaseComponents">
				  <RequesterCredentials>
				    <eBayAuthToken>'.$this->accessToken.'</eBayAuthToken>
				  </RequesterCredentials>
				  <ItemID>'.$itemID.'</ItemID>
				  <MemberMessage>
				    <Subject>Thank you '. $name . ' for your purchase</Subject>
				    <Body>We have processed your order and your product is ready to be shipped.  We appreciate your business and hope you enjoy your '. $productDescription .'.</Body>
				    <QuestionType>General</QuestionType>
				    <RecipientID>'.$recipientID.'</RecipientID>
				  </MemberMessage>
				</'.$request.'>';
		$headers = Array(
			"Content-Type: text/xml",
			"X-EBAY-API-COMPATIBILITY-LEVEL: 1081",
			"X-EBAY-API-CALL-NAME: $requestHeader",
			"X-EBAY-API-SITEID: 0"
		);

		curl_setopt($crl, CURLOPT_URL, $this->eBayAPIUrl);
		curl_setopt($crl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($crl, CURLOPT_POST, 1);
		curl_setopt($crl, CURLOPT_POSTFIELDS, $xml);
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);

		$rest = curl_exec($crl);

		curl_close($crl);

		return $rest;
	}

	function echoPrintShippingLabelMetadata($orders, $orderID) {
		$buyer = $orders->Buyer->BuyerInfo->ShippingAddress;

		$name = strval($buyer->Name);
		$email = strval($orders->Buyer->Email);
		$phone = strval($buyer->Phone);
		$street = strval($buyer->Street1);
		$suburb = strval($buyer->CityName);
		$postcode = strval($buyer->PostalCode);
		$state = strval($buyer->StateOrProvince);
		$delivery_instructions = "";

		echo "Results: $name $email $phone $street $suburb $postcode $state\n";
	}

	function printShippingLabel($orders, $orderID) {
		$buyer = $orders->Buyer->BuyerInfo->ShippingAddress;

		$name = strval($buyer->Name);
		$email = strval($orders->Buyer->Email);
		$phone = strval($buyer->Phone);
		$street = strval($buyer->Street1);
		$suburb = strval($buyer->CityName);
		$postcode = strval($buyer->PostalCode);
		$state = strval($buyer->StateOrProvince);
		$delivery_instructions = "";

		$email = strpos($email, 'Invalid Request') !== false ? '' : $email;

		$sendAusPost = new AusPost();
		$shipment = $sendAusPost->createShipment(
			$orderID,
			$name,
			$street,
			$suburb,
			$state,
			$postcode,
			$phone,
			$email,
			$delivery_instructions
		);
		$labelInfo = $sendAusPost->createLabel($shipment->shipmentID, $shipment->itemID);
		$labelURL = $labelInfo->labelUrl;
		$labelRequestID = $labelInfo->labelRequestID;
		$result = $sendAusPost->printShippingLabelCUPS($labelURL, $labelRequestID);
		var_dump($result);
		if(!$result) echo "Label printed successfully\n";
		else echo "Label printing failed\n";
	}

	function telegramMessage($message) {
		echo "$message\n";
		file_get_contents("https://api.telegram.org/bot$this->telegramAPIKey/sendMessage?chat_id=$this->telegramChannelID&text=$message");
	}
}

if(isset($argv[1]) && $argv[1] == 'processOrders') {
	$management = new Management();
	$management->processOrders();
}

?>
