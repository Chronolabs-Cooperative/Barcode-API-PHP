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

	require_once __DIR__ . DIRECTORY_SEPARATOR . 'header.php';

	/**
	 * URI Path Finding of API URL Source Locality
	 * @var unknown_type
	 */
	$odds = $inner = array();
	foreach($_GET as $key => $values) {
	    if (!isset($inner[$key])) {
	        $inner[$key] = $values;
	    } elseif (!in_array(!is_array($values) ? $values : md5(json_encode($values, true)), array_keys($odds[$key]))) {
	        if (is_array($values)) {
	            $odds[$key][md5(json_encode($inner[$key] = $values, true))] = $values;
	        } else {
	            $odds[$key][$inner[$key] = $values] = "$values--$key";
	        }
	    }
	}
	
	foreach($_POST as $key => $values) {
	    if (!isset($inner[$key])) {
	        $inner[$key] = $values;
	    } elseif (!in_array(!is_array($values) ? $values : md5(json_encode($values, true)), array_keys($odds[$key]))) {
	        if (is_array($values)) {
	            $odds[$key][md5(json_encode($inner[$key] = $values, true))] = $values;
	        } else {
	            $odds[$key][$inner[$key] = $values] = "$values--$key";
	        }
	    }
	}
	
	foreach(parse_url('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'], '?')?'&':'?').$_SERVER['QUERY_STRING'], PHP_URL_QUERY) as $key => $values) {
	    if (!isset($inner[$key])) {
	        $inner[$key] = $values;
	    } elseif (!in_array(!is_array($values) ? $values : md5(json_encode($values, true)), array_keys($odds[$key]))) {
	        if (is_array($values)) {
	            $odds[$key][md5(json_encode($inner[$key] = $values, true))] = $values;
	        } else {
	            $odds[$key][$inner[$key] = $values] = "$values--$key";
	        }
	    }
	}
	
	//die(print_r($inner, true));
	// Check Variables being passed for help or not!
	$help=true;
	if (isset($inner['output']) || !empty($inner['output'])) {
		$version = isset($inner['version'])?(string)$inner['version']:'v3';
		$output = isset($inner['output'])?(string)$inner['output']:'png';
		$code = isset($inner['code'])?(string)$inner['code']:'QRCODE';
		$data = isset($inner['data'])?(string)$inner['data']:time();
		$height = isset($inner['height'])?(string)$inner['height']:'-4';
		$width = isset($inner['width'])?(string)$inner['width']:'-4';
		$padding = isset($inner['padding'])?(string)$inner['padding']:'-2';
		$forecolour = isset($inner['forecolour'])?"#".(string)$inner['forecolour']:'#000000';
		$backcolour = isset($inner['backcolour'])?"#".(string)$inner['backcolour']:'#FFFFFF';
		$help=false;
	} else {
		$help=true;
	}
	
	// Displays Help if any variables are wrong or missing
	if ($help==true) {
		if (function_exists('http_response_code'))
			http_response_code(400);
		include dirname(__FILE__).'/help.php';
		exit;
	}
	
	require_once __DIR__.'/class/barcodes/autoload.php';
	$barcode = new \Com\Tecnick\Barcode\Barcode();
	switch($backcolour)
	{
	    case 'transparent':
	        $bobj = $barcode->getBarcodeObj(
	                   $code,          // barcode type and additional comma-separated parameters
	                   $data,          // data string to encode
	                   $height,        // bar height (use absolute or negative value as multiplication factor)
	                   $width,         // bar width (use absolute or negative value as multiplication factor)
	                   $forecolour,    // foreground color
	                   array($padding, $padding, $padding, $padding) // padding (use absolute or negative values as multiplication factors)
	        );
	        break;
	    default:
	        $bobj = $barcode->getBarcodeObj(
            	        $code,          // barcode type and additional comma-separated parameters
            	        $data,          // data string to encode
            	        $height,        // bar height (use absolute or negative value as multiplication factor)
            	        $width,         // bar width (use absolute or negative value as multiplication factor)
            	        $forecolour,    // foreground color
            	        array($padding, $padding, $padding, $padding) // padding (use absolute or negative values as multiplication factors)
	        )->setBackgroundColor($backcolour); // background color
	        break;
	}
	// Generates Barcode
	switch ($output) {
		case 'html':
		    header('Content-Type: text/html');
		    die($bobj->getHtmlDiv());
			break;
		case 'jpg':
		    die($bobj->getJpg());
			break;
		case 'gif':
		    die($bobj->getGif());
		    break;
		case 'png':
		    die($bobj->getPng());
			break;
		case 'svg':
		    die($bobj->getSvg());
			break;
		case 'unicode':
		    header('Content-Type: text/text');
		    die($bobj->getGrid(json_decode('"\u00A0"'), json_decode('"\u2584"')));
		    break;
		case 'binary':
		    header('Content-Type: text/text');
		    die($bobj->getGrid());
		    break;
	}
?>		
