<?php
use Picqer\Barcode\BarcodeGenerator;
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
    const TYPE_CODE_39 = 'C39';
    const TYPE_CODE_39_CHECKSUM = 'C39+';
    const TYPE_CODE_39E = 'C39E';
    const TYPE_CODE_39E_CHECKSUM = 'C39E+';
    const TYPE_CODE_93 = 'C39';
    const TYPE_STANDARD_2_5 = 'S25';
    const TYPE_STANDARD_2_5_CHECKSUM = 'S25+';
    const TYPE_INTERLEAVED_2_5 = 'I25';
    const TYPE_INTERLEAVED_2_5_CHECKSUM = 'I25+';
    const TYPE_CODE_128 = 'C128';
    const TYPE_CODE_128_A = 'C128A';
    const TYPE_CODE_128_B = 'C128B';
    const TYPE_CODE_128_C = 'C128C';
    const TYPE_EAN_2 = 'EAN2';
    const TYPE_EAN_5 = 'EAN5';
    const TYPE_EAN_8 = 'EAN8';
    const TYPE_EAN_13 = 'EAN13';
    const TYPE_UPC_A = 'UPCA';
    const TYPE_UPC_E = 'UPCA';
    const TYPE_MSI = 'MSI';
    const TYPE_MSI_CHECKSUM = 'MSI+';
    const TYPE_POSTNET = 'POSTNET';
    const TYPE_PLANET = 'PLANET';
    const TYPE_RMS4CC = 'RMS4CC';
    const TYPE_KIX = 'KIX';
    const TYPE_IMB = 'IMB';
    const TYPE_CODABAR = 'CODABAR';
    const TYPE_CODE_11 = 'CODE11';
    const TYPE_PHARMA_CODE = 'PHARMA';
    const TYPE_PHARMA_CODE_TWO_TRACKS = 'PHARMA2T';

	global $source, $ipid;
	require_once __DIR__ . DIRECTORY_SEPARATOR . 'header.php';
	
	// Check Variables being passed for help or not!
	$help=true;
	if (isset($_GET['output']) || !empty($_GET['output'])) {
		$version = isset($_GET['version'])?(string)$_GET['version']:'v2';
		$output = isset($_GET['output'])?(string)$_GET['output']:'';
		$mode = isset($_GET['mode'])?(string)$_GET['mode']:'';
		$state = isset($_GET['state'])?(string)$_GET['state']:'';
		switch($output)
		{
			case "svg":
			case "html":
			case "jpg":
			case "png":
				if (!empty($state) && in_array($mode, array('code-39', 'code-39-checksum', 'code-39e', 'code-39e-checksum', 'code-93', 'standard-2-5', 'standard-2-5-checksum', 'interleaved-2-5', 'interleaved-2-5-checksum', 'code-128', 'code-128-a', 'code-128-b', 'code-128-c', 'ean-2', 'ean-5', 'ean-8', 'ean-13', 'upc-a', 'upc-e', 'msi', 'msi-checksum', 'postnet', 'planet', 'rms4cc', 'kix', 'imb', 'codabar', 'code-11', 'pharma-code', 'pharma-code-two-track')))
				{
					$help=false;
					$type = constant("TYPE_" . str_replace("-", "_", strtoupper($mode)));
					switch($output)
					{
						case "svg":
							$generator = new Picqer\Barcode\BarcodeGeneratorSVG();
							break;	
						case "html":
							$generator = new Picqer\Barcode\BarcodeGeneratorHTML();
							break;
						case "jpg":
							$generator = new Picqer\Barcode\BarcodeGeneratorJPG();
							break;
						default:
						case "png":
							$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
							break;
					}
				}
				break;		
		}
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
	
	// Defines whether barcode is forced to be downloaded
	if (strpos($_SERVER["REQUEST_URI"], "?download"))
	{
		header('Content-type: ' . getMimetype($output));
		header('Content-Disposition: attachment; filename="' . sef("barcode-$mode--$state") . ".$output\"");
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');
		header('Cache-Control: private');
		header('Pragma: private');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	} else 
		header('Content-type: ' . getMimetype($output));
	
	// Generates Barcode
	$data = '';
	$constant = new Picqer\Barcode\BarcodeGeneratorPNG();
	switch ($output) {
		case 'html':
			if ( $_SERVER['HTTP_ACCEPT_ENCODING'] == 'gzip' )
			{
				header( "Content-Encoding: gzip" );
				die(gzencode($generator->getBarcode($state, $generator::$type), 9, FORCE_GZIP ));
			}
			else
				die($generator->getBarcode($state, $generator::$type)) ;
			break;
		case 'jpg':
			if ( $_SERVER['HTTP_ACCEPT_ENCODING'] == 'gzip' )
			{
				header( "Content-Encoding: gzip" );
				die(gzencode($generator->getBarcode($state, $type), 9, FORCE_GZIP ));
			}
			else
				die($generator->getBarcode($state, $type)) ;
			break;
		default:
		case 'png':
			if ( $_SERVER['HTTP_ACCEPT_ENCODING'] == 'gzip' )
			{
				header( "Content-Encoding: gzip" );
				die(gzencode($generator->getBarcode($state, $generator::$type), 9, FORCE_GZIP ));
			}
			else
				die($generator->getBarcode($state, $generator::$type)) ;
			break;
		case 'svg':
			if ( $_SERVER['HTTP_ACCEPT_ENCODING'] == 'gzip' )
			{
				header( "Content-Encoding: gzip" );
				die(gzencode($generator->getBarcode($state, $generator::$type), 9, FORCE_GZIP ));
			}
			else
				die($generator->getBarcode($state, $generator::$type)) ;
			break;
	}
?>		
