<?php

namespace LibreNMS\Plugins;

require_once("UniFiAPI/class.unifi.php");
require_once("devices.php");
require_once("config.php");

class UniFiHelper {

	private static $_instance = null;
	private static $_uniFiAPI;

	/**
	 * Initialize helper and perform login on controller
	 */
	function __construct() {
		$this->_uniFiAPI = new UnifiApi(UniFiConfig::$username, UniFiConfig::$password, UniFiConfig::$controller, UniFiConfig::$site, UniFiConfig::$version);
		$this->_uniFiAPI ->login();
	}

	/**
	 * Gets the current shared instance of the class
	 * @return mixed Instance
	 */
	public static function sharedInstance() {
		if(!isset(self::$_instance)) {
			self::$_instance = new UniFiHelper();
		}
		return self::$_instance;
	}

	/**
	 * Check if a SNMP device sysName matches one of a known UniFi product
	 * @param  array $device LibreNMS Device
	 * @return boolean Is UniFi device
	 */
	public function isUniFiDevice($device) {
		return in_array($device['sysName'], array_keys(UniFiDevices::$devices));	
	}

	/**
	 * Gets a list of devices associated with the controller
	 * @return array Array of device objects
	 */
	public function getDevices() {
		return $this->_uniFiAPI->list_devices();
	}

	/**
	 * Generate HTML for table cells 
	 * @param  array $device  LibreNMS Device
	 * @param  object $uDevice UniFI Device
	 * @return string HTML
	 */
	public function getDataTable($device, $uDevice) {
		$fields = UniFiDevices::$devices[$device['sysName']];
		$html = "";

		// Iterate fields to extract value
		foreach ($fields as $field => $fieldOptions) {
			$html .= $this->generateTableData($uDevice, $field, $fieldOptions);
		}

		return $html;
	}

	/**
	 * Generate table cells from data
	 * @param  object $uDevice UniFI Device
	 * @param  string $field Field key path
	 * @param  array $fieldOptions Field options
	 */
	private function generateTableData($uDevice, $field, $fieldOptions) {
		$value = $this->getFieldValue($field, $uDevice);

		switch ($fieldOptions['type']) {
			case 'bool':
				if($value) {
					return $this->generateTableRow([$fieldOptions['title'], "Yes"]);
				}
				return $this->generateTableRow([$fieldOptions['title'], "No"]);
				break;

			case 'uplink':
				return $this->generateTableRow([
					$fieldOptions['title'],
					$value->latency . " ms <br />" .
					'<i class="fa fa-long-arrow-left fa-lg" style="color:green" aria-hidden="true"></i>' . number_format($value->{"rx_bytes-r"} / 8 / 1024 / 8, 2). " Mbps <br />".
					'<i class="fa fa-long-arrow-right fa-lg" style="color:blue" aria-hidden="true"></i>' . number_format($value->{"tx_bytes-r"} / 8 / 1024 / 8, 2). " Mbps"
				]);
				break;

			case 'uplink_no_latency':
				return $this->generateTableRow([
					$fieldOptions['title'],
					'<i class="fa fa-long-arrow-left fa-lg" style="color:green" aria-hidden="true"></i>' . number_format($value->{"rx_bytes-r"} / 8 / 1024 / 8, 2). " Mbps <br />".
					'<i class="fa fa-long-arrow-right fa-lg" style="color:blue" aria-hidden="true"></i>' . number_format($value->{"tx_bytes-r"} / 8 / 1024 / 8, 2). " Mbps"
				]);
				break;

			case 'time':
				return $this->generateTableRow([$fieldOptions['title'], formatUptime($value)]);
				break;
			
			default:
				return $this->generateTableRow([$fieldOptions['title'], $value]);
		}
	}

	/**
	 * Generate HTML table structure
	 * @param  array $entries Table cell values
	 * @return string HTML
	 */
	private function generateTableRow($entries = array()) {
		$html = "<tr>";

		foreach ($entries as $entry) {
			$html .= "<td>{$entry}</td>";
		}

		$html .= "</tr>";

		return $html;
	}

	/**
	 * Fetch field value from data object
	 * @param  string $key Key path
	 * @param  object $data Data object
	 * @return mixed Value
	 */
	private function getFieldValue($key, $data) {
		$key = explode(".", $key);

		foreach ($key as $seg) {
			if(isset($data->{$seg})) {
				$data = $data->{$seg};
			}
		}

		return $data;

	}

}

?>