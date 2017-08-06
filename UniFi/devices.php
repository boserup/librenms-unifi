<?php
	
namespace LibreNMS\Plugins;

class UniFiDevices {

	/**
	 * List of known devices and fields to extract
	 * @var array
	 */
	public static $devices = [
		"usg" => [
			"uplink" => [
				"title"	=> "Uplink",
				"type"	=> "uplink"
			],
			"uplink.uptime" => [
				"title"	=> "Uplink uptime",
				"type"	=> "time"
			],
			"adopted" => [
				"title"	=> "Adopted",
				"type"	=> "bool"
			]
		],
		"us-8" => [
			"uplink" => [
				"title"	=> "Uplink",
				"type"	=> "uplink_no_latency"
			],
			"adopted" => [
				"title"	=> "Adopted",
				"type"	=> "bool"
			]
		]
	];

}

?>