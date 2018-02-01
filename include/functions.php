<?php
/**
 * Chronolabs Barcode Generation REST API
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright       	Chronolabs Cooperative http://labs.coop
 * @license         	General Public License version 3 (http://labs.coop/briefs/legal/general-public-licence/13,3.html)
 * @package         	barcode-apis
 * @since           	2.0.1
 * @author          	Simon Roberts <wishcraft@users.sourceforge.net>
 * @subpackage			api
 * @description			Barcode Generation REST API
 * @see					http://sourceforge.net/projects/chronolabsapis
 * @see					http://barcode.labs.coop
 * @see					http://cipher.labs.coop
 */


require_once __DIR__ . '/constants.php';

if (!function_exists("whitelistGetIP")) {

	/* function whitelistGetIPAddy()
	 *
	* 	provides an associative array of whitelisted IP Addresses
	* @author 		Simon Roberts (Chronolabs) simon@labs.coop
	*
	* @return 		array
	*/
	function whitelistGetIPAddy() {
		return array_merge(whitelistGetNetBIOSIP(), file(dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'whitelist.txt'));
	}
}

if (!function_exists("whitelistGetNetBIOSIP")) {

	/* function whitelistGetNetBIOSIP()
	 *
	* 	provides an associative array of whitelisted IP Addresses base on TLD and NetBIOS Addresses
	* @author 		Simon Roberts (Chronolabs) simon@labs.coop
	*
	* @return 		array
	*/
	function whitelistGetNetBIOSIP() {
		$ret = array();
		foreach(file(dirname(dirname(dirname(dirname(__FILE__)))) . DIRECTORY_SEPARATOR . 'whitelist-domains.txt') as $domain) {
			$ip = gethostbyname($domain);
			$ret[$ip] = $ip;
		}
		return $ret;
	}
}

if (!function_exists("whitelistGetIP")) {

	/* function whitelistGetIP()
	 *
	* 	get the True IPv4/IPv6 address of the client using the API
	* @author 		Simon Roberts (Chronolabs) simon@labs.coop
	*
	* @param		$asString	boolean		Whether to return an address or network long integer
	*
	* @return 		mixed
	*/
	function whitelistGetIP($asString = true){
		// Gets the proxy ip sent by the user
		$proxy_ip = '';
		if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$proxy_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else
		if (!empty($_SERVER['HTTP_X_FORWARDED'])) {
			$proxy_ip = $_SERVER['HTTP_X_FORWARDED'];
		} else
		if (! empty($_SERVER['HTTP_FORWARDED_FOR'])) {
			$proxy_ip = $_SERVER['HTTP_FORWARDED_FOR'];
		} else
		if (!empty($_SERVER['HTTP_FORWARDED'])) {
			$proxy_ip = $_SERVER['HTTP_FORWARDED'];
		} else
		if (!empty($_SERVER['HTTP_VIA'])) {
			$proxy_ip = $_SERVER['HTTP_VIA'];
		} else
		if (!empty($_SERVER['HTTP_X_COMING_FROM'])) {
			$proxy_ip = $_SERVER['HTTP_X_COMING_FROM'];
		} else
		if (!empty($_SERVER['HTTP_COMING_FROM'])) {
			$proxy_ip = $_SERVER['HTTP_COMING_FROM'];
		}
		if (!empty($proxy_ip) && $is_ip = preg_match('/^([0-9]{1,3}.){3,3}[0-9]{1,3}/', $proxy_ip, $regs) && count($regs) > 0)  {
			$the_IP = $regs[0];
		} else {
			$the_IP = $_SERVER['REMOTE_ADDR'];
		}
			
		$the_IP = ($asString) ? $the_IP : ip2long($the_IP);
		return $the_IP;
	}
}


if (!function_exists("cleanWhitespaces")) {
	/**
	 *
	 * @param array $array
	 */
	function cleanWhitespaces($array = array())
	{
		foreach($array as $key => $value)
		{
			if (is_array($value))
				$array[$key] = cleanWhitespaces($value);
				else {
					$array[$key] = trim(str_replace(array("\n", "\r", "\t"), "", $value));
				}
		}
		return $array;
	}
}


if (!function_exists("getURIData")) {

	/* function getURIData()
	 *
	 * 	cURL Routine
	 * @author 		Simon Roberts (Chronolabs) simon@labs.coop
	 *
	 * @return 		float()
	 */
	function getURIData($uri = '', $timeout = 65, $connectout = 65, $post_data = array())
	{
		if (!function_exists("curl_init"))
		{
			return file_get_contents($uri);
		}
		if (!$btt = curl_init($uri)) {
			return false;
		}
		curl_setopt($btt, CURLOPT_HEADER, 0);
		curl_setopt($btt, CURLOPT_POST, (count($posts)==0?false:true));
		if (count($posts)!=0)
			curl_setopt($btt, CURLOPT_POSTFIELDS, http_build_query($post_data));
			curl_setopt($btt, CURLOPT_CONNECTTIMEOUT, $connectout);
			curl_setopt($btt, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($btt, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($btt, CURLOPT_VERBOSE, false);
			curl_setopt($btt, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($btt, CURLOPT_SSL_VERIFYPEER, false);
			$data = curl_exec($btt);
			curl_close($btt);
			return $data;
	}
}


if (!function_exists('sef'))
{

	/**
	 * Safe encoded paths elements
	 *
	 * @param unknown $datab
	 * @param string $char
	 * @return string
	 */
	function sef($value = '', $stripe ='-')
	{
		$value = str_replace('&', 'and', $value);
		$value = str_replace(array("'", '"', "`"), 'tick', $value);
		$replacement_chars = array();
		$accepted = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","m","o","p","q",
				"r","s","t","u","v","w","x","y","z","0","9","8","7","6","5","4","3","2","1");
		for($i=0;$i<256;$i++){
			if (!in_array(strtolower(chr($i)),$accepted))
				$replacement_chars[] = chr($i);
		}
		$result = (str_replace($replacement_chars, $stripe, ($value)));
		while(substr($result, 0, strlen($stripe)) == $stripe)
			$result = substr($result, strlen($stripe), strlen($result) - strlen($stripe));
			while(substr($result, strlen($result) - strlen($stripe), strlen($stripe)) == $stripe)
				$result = substr($result, 0, strlen($result) - strlen($stripe));
				while(strpos($result, $stripe . $stripe))
					$result = str_replace($stripe . $stripe, $stripe, $result);
					return(strtolower($result));
	}
}


if (!function_exists('getRandomArrayString'))
{

	/**
	 * Get a random string from an array at last depth
	 *
	 * @param array $array
	 * @param string $ret
	 * @return string
	 */
	function getRandomArrayString($array = array())
	{
		while (count($array)>0)
		{
			$keys = array_keys($array);
			shuffle($keys); shuffle($keys); shuffle($keys); shuffle($keys);
			if (is_array($array[$key = $keys[mt_rand(0, count($keys)-1)]]))
			{
				return getRandomArrayString($array[$key]);
			} elseif (is_string($array[$key = $keys[mt_rand(0, count($keys)-1)]]) && strlen($array[$key])>=7)
			{
				return $array[$key];
			}
			if (isset($array[$key]))
				unset($array[$key]);
		}
	}
}

if (!function_exists('getBarcodes'))
{
    
    /**
     * Get a barcode code and name from data file
     *
     * @param array $array
     * @param string $ret
     * @return string
     */
    function getBarcodes()
    {
        $result = array();
        foreach(cleanWhitespaces(file(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'barcodes.diz')) as $barcodedata)
        {
            $parts = explode("||", $barcodedata);
            $result[$parts[0]] = $parts[1];
        }
        return $result;
    }
}


?>
