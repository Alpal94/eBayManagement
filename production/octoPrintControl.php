<?php
include 'orderFetch.php';

class OctoPrint {
	private $db;
	private $octoPiAPIKey;
	private $telegramAPIKey;
	private $telegramChannelID;
	private $piIPAddress;
	private $production;

	public function __construct() {
		include 'config.php';
		$this->db = $db;
		$this->octoPiAPIKey = $octoPiAPIKey;
		$this->telegramAPIKey = $telegramAPIKey;
		$this->telegramChannelID = $telegramChannelID;
		$this->piIPAddress = $piIPAddress;
		$this->production = $production;
		$this->conveyorBeltPassword = $conveyorBeltPassword;
	}

	function processJobQueue() {
		$activeJobs = mysqli_fetch_assoc($this->db->query("SELECT * FROM ActiveOrders WHERE Active=true"));
		if($activeJobs === null) { 
			$nextJob = mysqli_fetch_assoc($this->db->query("SELECT * FROM ActiveOrders ORDER BY CreatedAt ASC"));
			/*
			 * Error handling priorities: 
			 * - Must clear print bed first by activateConveyorBelt
			 * - If successful enter into database
			 * - On success send print command to printer
			 */
			if($nextJob !== null) {
				$folder = $nextJob["Folder"];
				$productID = $nextJob["ProductID"];
				$timestamp = strtotime('now');

				if ($this->isPrinterAvailable() && $this->activateConveyorBelt()) {
					$result = $this->db->query("UPDATE ActiveOrders SET StartTime=$timestamp, Active=true WHERE ProductID='$productID'");
					$this->db->error;
					if($result) {
						$printer_result = $this->sendTo3DPrinter("$folder.gcode");
						$this->telegramMessage("Activated new print job: $printer_result");
					} else {
						$error = $this->db->error;
						$this->telegramMessage("Database insertion error for $productID while activating print job: $error");
					}
				} else {
					$this->telegramMessage("Error activating conveyor belt for $productID");
				}
			} else {
			}
		} else {
			$timeleft = $activeJobs["PrintDuration"] - (strtotime('now') - $activeJobs["StartTime"]) / 60;
			$productID = $activeJobs["ProductID"];
			$transactionID = $activeJobs["TransactionID"];
			if ($timeleft < 0 && $this->isPrinterAvailable()) {
				$status = $this->db->query("DELETE FROM ActiveOrders WHERE ProductID='$productID'");
				if($status) {
					$devManagement = new Management();
					$sendEbayMessageResult = $devManagement->sendMessageToBuyer($transactionID);
					$this->telegramMessage("Sent message to buyer: $sendEbayMessageResult");
					$this->telegramMessage("Completed $productID print job");
				} else {
					$error = $this->db->error;
					$this->telegramMessage("Failed to clear print job on completion: $error");
				}
			} else {
				echo "ACTIVE JOBS: $timeleft\n";
			}
		}
	}

	function sendTo3DPrinter($file) {
		$get = "/files/local/$file";
		$post = '{"command": "select", "print": true}';
		if($this->production) return $this->curl($get, $post);
		else return "TESTING COMPLETE";
	}

	function preparePrinterYAxis() {
		$get = "/printer/printhead";
		$post = '{"command": "home", ["y", "x"]}';
		return $this->curl($get, $post);
	}

	function listFiles() {
		$get = "/files";
		$post = '';
		return $this->curl($get, $post);
	}

	function isPrinterAvailable() {
		$printer_status = $this->getPrinterStatus();
		$printer_stats = $this->getPrinterStats();
		$printer_temperature = json_decode($printer_stats, true)["temperature"]["bed"]["actual"];
		$isPrinting = json_decode($printer_status, true)["state"] == "Printing";

		if($printer_temperature < 30 && !$isPrinting) {
			//Printer is not printing and bed has cooled down --> Return true, printer is available
			return true;
		}
		//Printer is printing or bed temperature is still too hot for removal
		return false;
	}

	function getPrinterStatus() {
		$get = "/job";
		$post = '';
		return $this->curl($get, $post);
	}

	function getPrinterStats() {
		$get = "/printer?history=true&limit=2";
		$post = '';
		return $this->curl($get, $post);
	}

	function getFiles() {
		$get = '/files';
		return $this->curl($get, false);
	}

	function activateConveyorBelt() {
		$this->preparePrinterYAxis();
		sleep(2);
		$crl = curl_init();
		
		curl_setopt($crl, CURLOPT_URL, "http://$this->piIPAddress:8001?pass=$this->conveyorBeltPassword");
		curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, false); 

		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($crl);
		if(!$result) $result = curl_error($crl);
		curl_close($crl);

		return $result == "Activated belt" ? true : false;
	}

	function curl($get, $post) {
		$crl = curl_init();

		$headers = Array(
			"Content-Type: application/json",
			"X-Api-Key: $this->octoPiAPIKey",
			"Host: octopi.local"
		);
		
		curl_setopt($crl, CURLOPT_URL, "https://$this->piIPAddress/api$get");
		curl_setopt($crl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, false); 
		if($post) {
			curl_setopt($crl, CURLOPT_POST, 1);
			curl_setopt($crl, CURLOPT_POSTFIELDS, $post);
		}
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($crl);
		if(!$result) $result = curl_error($crl);
		curl_close($crl);
		return $result;

	}

	function telegramMessage($message) {
		echo "$message\n";
		file_get_contents("https://api.telegram.org/bot$this->telegramAPIKey/sendMessage?chat_id=$this->telegramChannelID&text=$message");
	}
}

if(isset($argv[1]) && $argv[1] == 'production') {
	$OctoPrint = new OctoPrint();
	$OctoPrint->processJobQueue();
}

?>
