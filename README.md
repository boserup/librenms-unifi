# UniFi Plugin for LibreNMS
![Screenshot](https://github.com/boserup/librenms-unifi/raw/master/screenshot.png)

Fetches device information from the UniFi Controller and displays it in LibreNMS. 

## Prerequisites
1. SNMP devices must be added by their IP address instead of a hostname
2. The UniFi controller must be running the latest stable version

## Installation
1. Clone the repository locally
2. Locate your LibreNMS installation
3. Place the UniFi folder in the html/plugins directory of the LibreNMS installation
4. Activate the plugin. Select Overview > Plugins > Plugin Admin in the top menu

## Supported devices

#### UniFi Security Gateway
SysName: usg

Stats: uplink, uplink uptime, adopted

####  UniFi Switch, 8-Port
SysName: us-8

Stats: uplink (without latency), adopted

## Adding new devices
Edit UniFi/devices.php and add a new array key with the device system name as it appears in LibreNMS. Define the keys you wish to extract as they appear in the UniFI API response. When submitting a pull request, please remember to update the readme file as well. 