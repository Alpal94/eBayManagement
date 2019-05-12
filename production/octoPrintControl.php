<?php

class OctoPrint {
	private $db;
	private $octoPiAPIKey;
	private $telegramAPIKey;
	private $telegramChannelID;
	private $piIPAddress;

	public function __construct() {
		include 'config.php';
		$this->db = $db;
		$this->octoPiAPIKey = $octoPiAPIKey;
		$this->telegramAPIKey = $telegramAPIKey;
		$this->telegramChannelID = $telegramChannelID;
		$this->piIPAddress = $piIPAddress;
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

				if ($this->activateConveyorBelt()) {
					$result = $this->db->query("UPDATE ActiveOrders SET StartTime=$timestamp, Active=true WHERE ProductID='$productID'");
					$this->db->error;
					if($result) {
						$printer_result = $this->sendTo3DPrinter($folder);
						$this->telegramMessage("Activated new print job: $printer_result");
					} else {
						$error = $this->db->error;
						$this->telegramMessage("Database insertion error for $productID while activating print job: $error");
					}
				} else {
					$this->telegramMessage("Error activating conveyor belt for $productID");
				}
			} else {
				echo "Nothing to do ... \n";
			}
		} else {
			$timeleft = $activeJobs["PrintDuration"] - (strtotime('now') - $activeJobs["StartTime"]) / 60;
			$productID = $activeJobs["ProductID"];
			if ($timeleft < 0) {
				$status = $this->db->query("DELETE FROM ActiveOrders WHERE ProductID='$productID'");
				if($status) {
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

		return $this->curl($get, $post);
	}

	function getFiles() {
		$get = '/files';
		return $this->curl($get, false);
	}

	function activateConveyorBelt() {
		$crl = curl_init();
		
		curl_setopt($crl, CURLOPT_URL, "http://$this->piIPAddress:8001");
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

$OctoPrint = new OctoPrint();
$OctoPrint->processJobQueue();

?>
