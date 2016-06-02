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


if (!function_exists("getIPIdentity")) {
	/**
	 *
	 * @param string $ip
	 * @return string
	 */
	function getIPIdentity($ip = '', $sarray = false)
	{

		if (empty($ip))
			$ip = whitelistGetIP(true);
		
		if (!isset($_SESSION['ip-identity']))
		{
			$uris = cleanWhitespaces(file($file = __DIR__ . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "lookups.diz"));
			shuffle($uris); shuffle($uris); shuffle($uris); shuffle($uris);
			if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE || FILTER_FLAG_NO_RES_RANGE) === false)
			{
				$data = array();
				foreach($uris as $uri)
				{
					if ($data['ip']==$ip || $data['country']['iso'] == "-" || empty($data))
						$data = json_decode(getURIData(sprintf($uri, 'myself', 'json'), 120, 120), true);
						if (count($data) > 0 &&  $data['country']['iso'] != "-")
							continue;
				}
			} else{
				foreach($uris as $uri)
				{
					if ($data['ip']!=$ip || $data['country']['iso'] == "-" || empty($data))
						$data = json_decode(getURIData(sprintf($uri, $ip, 'json'), 120, 120), true);
						if (count($data) > 0 &&  $data['country']['iso'] != "-")
							continue;
				}
			}
	
			if (!isset($data['ip']) && empty($data['ip']))
				$data['ip'] = $ip;
				
			$_SESSION['ip-identity'] = array();
			$_SESSION['ip-identity']['ipaddy'] = $data['ip'];
			if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === false)
				$_SESSION['ip-identity']['type'] = 'ipv6';
			else
				$_SESSION['ip-identity']['type'] = 'ipv4';
			$_SESSION['ip-identity']['netbios'] = gethostbyaddr($_SESSION['ip-identity']['ipaddy']);
			$_SESSION['ip-identity']['data'] = array('ipstack' => gethostbynamel($_SESSION['ip-identity']['netbios']));
			$_SESSION['ip-identity']['domain'] = getBaseDomain("http://".$_SESSION['ip-identity']['netbios']);
			$_SESSION['ip-identity']['country'] = $data['country']['iso'];
			$_SESSION['ip-identity']['region'] = $data['location']['region'];
			$_SESSION['ip-identity']['city'] = $data['location']['city'];
			$_SESSION['ip-identity']['postcode'] = $data['location']['postcode'];
			$_SESSION['ip-identity']['timezone'] = "GMT " . $data['location']['gmt'];
			$_SESSION['ip-identity']['longitude'] = $data['location']['coordinates']['longitude'];
			$_SESSION['ip-identity']['latitude'] = $data['location']['coordinates']['latitude'];
			$_SESSION['ip-identity']['last'] = $_SESSION['ip-identity']['created'] = time();
			$whois = array();
			$whoisuris = cleanWhitespaces(file(__DIR__  . DIRECTORY_SEPARATOR .  "data" . DIRECTORY_SEPARATOR . "whois.diz"));
			shuffle($whoisuris); shuffle($whoisuris); shuffle($whoisuris); shuffle($whoisuris);
			foreach($whoisuris as $uri)
			{
				if (empty($whois[$_SESSION['ip-identity']['type']]) || !isset($whois[$_SESSION['ip-identity']['type']]))
				{
					$whois[$_SESSION['ip-identity']['type']] = json_decode(getURIData(sprintf($uri, $_SESSION['ip-identity']['ipaddy'], 'json'), 120, 120), true);
				} elseif (empty($whois['domain']) || !isset($whois['domain']))
				{
					$whois['domain'] = json_decode(getURIData(sprintf($uri, $_SESSION['ip-identity']['domain'], 'json'), 120, 120), true);
				} else
					continue;
			}
			$wsid = md5(json_encode($whois));
			$_SESSION['ip-identity']['whois'] = $wsid;
			$_SESSION['ip-identity']['ip-id'] = md5(json_encode($_SESSION['ip-identity']));
			$_SESSION['ip-identity']['whois'] = array($wsid=>$whois);
		}
		if ($sarray == false)
			return $_SESSION['ip-identity']['ip-id'];
		else
			return $_SESSION['ip-identity'];
	}
}


if (!function_exists("getBaseDomain")) {
	/**
	 * getBaseDomain
	 *
	 * @param string $url
	 * @return string|unknown
	 */
	function getBaseDomain($url)
	{

		static $fallout, $stratauris, $classes;

		if (empty($classes))
		{
			if (empty($stratauris)) {
				$stratauris = cleanWhitespaces(file(__DIR__  . DIRECTORY_SEPARATOR .  "data" . DIRECTORY_SEPARATOR . "stratas.diz"));
				shuffle($stratauris); shuffle($stratauris); shuffle($stratauris); shuffle($stratauris);
			}
			shuffle($stratauris);
			$attempts = 0;
			while(empty($classes) || $attempts <= (count($stratauris) * 1.65))
			{
				$attempts++;
				$classes = array_keys(unserialize(getURIData($stratauris[mt_rand(0, count($stratauris)-1)] ."/v1/strata/serial.api", 120, 120)));
			}
		}
		if (empty($fallout))
		{
			if (empty($stratauris)) {
				$stratauris = cleanWhitespaces(file(__DIR__  . DIRECTORY_SEPARATOR .  "data" . DIRECTORY_SEPARATOR . "stratas.diz"));
				shuffle($stratauris); shuffle($stratauris); shuffle($stratauris); shuffle($stratauris);
			}
			shuffle($stratauris);
			$attempts = 0;
			while(empty($fallout) || $attempts <= (count($stratauris) * 1.65))
			{
				$attempts++;
				$fallout = array_keys(unserialize(getURIData($stratauris[mt_rand(0, count($stratauris)-1)] ."/v1/fallout/serial.api", 120, 120)));
			}
		}

		// Get Full Hostname
		$url = strtolower($url);
		$hostname = parse_url($url, PHP_URL_HOST);
		if (!filter_var($hostname, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6 || FILTER_FLAG_IPV4) === false)
			return $hostname;

			// break up domain, reverse
			$elements = explode('.', $hostname);
			$elements = array_reverse($elements);

			// Returns Base Domain
			if (in_array($elements[0], $classes))
				return $elements[1] . '.' . $elements[0];
				elseif (in_array($elements[0], $fallout) && in_array($elements[1], $classes))
				return $elements[2] . '.' . $elements[1] . '.' . $elements[0];
				elseif (in_array($elements[0], $fallout))
				return  $elements[1] . '.' . $elements[0];
				else
					return  $elements[1] . '.' . $elements[0];
	}
}


if (!function_exists("getMimetype")) {
	/**
	 *
	 * @param unknown_type $path
	 * @param unknown_type $perm
	 * @param unknown_type $secure
	 */
	function getMimetype($extension = '-=-')
	{
		$mimetypes = cleanWhitespaces(file(__DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'mimetypes.diz'));
		foreach($mimetypes as $mimetype)
		{
			$parts = explode("||", $mimetype);
			if (strtolower($extension) == strtolower($parts[0]))
				return $parts[1];
				if (strtolower("-=-") == strtolower($parts[0]))
					$final = $parts[1];
		}
		return $final;
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


?>
