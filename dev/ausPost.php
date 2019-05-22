<?php

class Shipment {
	public $shipmentID = "";
	public $itemID = "";
	public $trackingArticleID = "";
	public $trackingConsignmentID = "";
	public function __construct($shipmentID, $itemID, $trackingArticleID, $trackingConsignmentID) {
		$this->shipmentID = $shipmentID;
		$this->itemID = $itemID;
		$this->trackingArticleID = $trackingArticleID;
		$this->trackingConsignmentID = $trackingConsignmentID;
	}
}

class LabelURL {
	public $labelUrl;
	public $labelRequestID;
	public function __construct($labelUrl, $labelRequestID) {
		$this->labelUrl = $labelUrl;
		$this->labelRequestID = $labelRequestID;
	}
}

class AusPost {
	private $db;
	private $ausPostAPIKey;
	private $ausPostPassword;
	private $ausPostAccount;
	private $telegramAPIKey;
	private $telegramChannelID;
	private $ausPostAPIUrl;
	private $piIPAddress;

	public function __construct() {
		include 'config.php';
		$this->db = $db;
		$this->ausPostAPIKey = $ausPostAPIKey;
		$this->ausPostPassword = $ausPostPassword;
		$this->ausPostAccount = $ausPostAccount;
		$this->telegramAPIKey = $telegramAPIKey;
		$this->telegramChannelID = $telegramChannelID;
		$this->ausPostAPIUrl = $ausPostAPIUrl;
		$this->piIPAddress = $piIPAddress;
	}

	function createShipment($orderID, $name, $street, $suburb, $state, $postcode, $phone, $email, $delivery_instructions) {
		$length = "5";
		$height = "5";
		$width = "5";
		$weight = "0.1";

		$coName = "Alasdair Penman";
		$coStreet = "22 Winifred Street";
		$coSuburb = "Mosman Park";
		$coPostcode = "6012";
		$coState = "WA";
		$coAPCN = "1016711300";
		$product = "7E55";
		$body = '{
		   "shipments":[
		      {
			 "shipment_reference":"'.$orderID.'",  
			 "customer_reference_1":"'.$orderID.'",
			 "customer_reference_2":"'.$orderID.'",
			 "from":{
			    "name":"'.$coName.'",
			    "lines":[
			       "'.$coStreet.'"
			    ],
			    "suburb": "'.$coSuburb.'",
			    "postcode": "'.$coPostcode.'",
			    "state": "'.$coState.'",
			    "apcn": "'.$coAPCN.'"
			 },
			 "to":{
			    "name":"'.$name.'",
			    "lines":[
				"'.$street.'"
			    ],
			    "suburb":"'.$suburb.'",
			    "state":"'.$state.'",
			    "postcode":"'.$postcode.'",
			    "phone":"'.$phone.'",
			    "email":"'.$email.'",
			    "delivery_instructions":"'.$delivery_instructions.'"
			 },
			 "items":[
			    {
			       "length":'.$length.',
			       "height":"'.$height.'",
			       "width":"'.$width.'",
			       "weight":'.$weight.',
			       "item_reference":"blocked",
			       "product_id":"'.$product.'",
			       "authority_to_leave":true,
			       "allow_partial_delivery": false
			    }
			 ]
		      }
		    ]
		}';

		$result = $this->curl("/shipping/v1/shipments", $body);
		$this->telegramMessage($result);
		$result = json_decode($result, true);
		return new Shipment(
			$result["shipments"][0]["shipment_id"],
			$result["shipments"][0]["items"][0]["item_id"],
			$result["shipments"][0]["items"][0]["tracking_details"]["article_id"],
			$result["shipments"][0]["items"][0]["tracking_details"]["consignment_id"]
		);
	}

	function createLabel($shipmentID, $itemID) {
		$body = '
			{
			    "preferences": [
				{
				    "type": "PRINT",
				    "groups": [
					{
					    "group": "Parcel Post",
					    "layout": "A4-1pp",
					    "branded": true,
					    "left_offset": 0,
					    "top_offset": 0
					}
				    ]
				}
			    ],
			    "shipments": [
				{
				    "shipment_id":"'.$shipmentID.'",
				    "items": [
					{
					    "item_id": "'.$itemID.'"
					}
				    ]
				}
			    ]
			}';
		$result = json_decode($this->curl("/shipping/v1/labels", $body), true);
		$labelRequestID = $result["labels"][0]["request_id"];
		$labelGenerated = json_decode($this->curl("/shipping/v1/labels/$labelRequestID", false), true);
		while($labelGenerated["labels"][0]["status"] == "PENDING") {
			$labelGenerated = json_decode($this->curl("/shipping/v1/labels/$labelRequestID", false), true);
			sleep(1);
		}
		return new LabelURL($labelGenerated["labels"][0]["url"], $labelRequestID);
	}

	function printShippingLabelCUPS($shippingLabelURL, $labelRequestID) {
		$crl = curl_init();

		curl_setopt($crl, CURLOPT_URL, "http://$this->piIPAddress:800/printer_commands/printer_control.php");
		curl_setopt($crl, CURLOPT_POST, 1);
		curl_setopt($crl, CURLOPT_POSTFIELDS, array("labelUrl" => $shippingLabelURL, "labelRequestID" => $labelRequestID));
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($crl);
		if(!$result) $result = curl_error($crl);
		curl_close($crl);
		var_dump($result);

		return false;

	}

	function curl($get, $post) {
		$crl = curl_init();

		$headers = Array(
			"Content-Type: application/json",
			"account-number: $this->ausPostAccount"
		);

		curl_setopt($crl, CURLOPT_URL, "$this->ausPostAPIUrl$get");
		curl_setopt($crl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($crl, CURLOPT_USERPWD, "$this->ausPostAPIKey:$this->ausPostPassword");
		if($post) {
			curl_setopt($crl, CURLOPT_POST, 1);
			curl_setopt($crl, CURLOPT_POSTFIELDS, $post);
		}
		curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
		$result = curl_exec($crl);
		if(!$result) {
			$result = curl_error($crl);
			$this->telegramMessage($result);
		}
		curl_close($crl);
		return $result;

	}

	function telegramMessage($message) {
		file_get_contents("https://api.telegram.org/bot$this->telegramAPIKey/sendMessage?chat_id=$this->telegramChannelID&text=$message");
	}
}

?>
