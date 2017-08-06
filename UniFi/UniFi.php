<?php

namespace LibreNMS\Plugins;

require_once('UniFiHelper.php');

class UniFi {

	function __construct() {

	}

	/**
	 * System hook menu call
	 * @return void
	 */
	public function menu() {
		//echo '<li><a href="plugin/p=UniFi">UniFi</a></li>';
	}

	/**
	 * System hook device call
	 * @param array $device LibreNMS Device
	 * @return void
	 */
	public function device_overview_container($device) {
		if(UniFiHelper::sharedInstance()->isUniFiDevice($device)) {
			// Current UniFi device object
			$currentUDevice = null;

			// Iterate controller devices and find one matching the current SNMP device
			foreach (UniFiHelper::sharedInstance()->getDevices() as $uDevice) {
				if($uDevice->connect_request_ip == $device['hostname']) {
					$currentUDevice = $uDevice;
					continue;
				}
			}

			// Panel heading
			echo('<div class="container-fluid"><div class="row"><div class="col-md-12"><div class="panel panel-default panel-condensed"> <div class="panel-heading"><i class="fa fa-bullseye fa-lg icon-theme" aria-hidden="true"></i> <strong>UniFi Plugin</strong> </div>');

			// Generate device table
        			$tableData = UniFiHelper::sharedInstance()->getDataTable($device, $currentUDevice);
        			echo '<table class="table table-hover table-condensed table-striped">';
        			echo $tableData;
        			echo '</table>';


        			//echo "<!--";
        			//print_r($currentUDevice);
        			//echo "-------";
        			//print_r($device);
        			//echo "-->";
        			echo('</div></div></div></div>');
		}
	}


}

?>