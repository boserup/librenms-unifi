<?php
	
namespace LibreNMS\Plugins;

class UniFiConfig {

	/**
	 * UniFi Controller username
	 * @var string
	 */
	public static $username = "";

	/**
	 * UniFi Controller password
	 * @var string
	 */
	public static $password = "";

	/**
	 * UniFi Controller url
	 * https://ip:8443
	 * @var string
	 */
	public static $controller = "https://unifi:8443";

	/**
	 * UniFi Controller Site ID
	 * 'default' if you only have one site
	 * @var string
	 */
	public static $site = "default";

	/**
	 * UniFi Controller version string
	 * Can be found in the top left corner of the controller UI
	 * @var string
	 */
	public static $version = "5.5.20";

}

?>