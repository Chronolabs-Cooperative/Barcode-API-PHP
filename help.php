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

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

	<?php 	$servicename = "Barcoding Generation Services"; 
		$servicecode = "BGS"; ?>
	<meta property="og:url" content="<?php echo (isset($_SERVER["HTTPS"])?"https://":"http://").$_SERVER["HTTP_HOST"]; ?>" />
	<meta property="og:site_name" content="<?php echo $servicename; ?> Open Services API's (With Source-code)"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="rating" content="general" />
	<meta http-equiv="author" content="wishcraft@users.sourceforge.net" />
	<meta http-equiv="copyright" content="Chronolabs Cooperative &copy; <?php echo date("Y")-1; ?>-<?php echo date("Y")+1; ?>" />
	<meta http-equiv="generator" content="wishcraft@users.sourceforge.net" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="//labs.partnerconsole.net/execute2/external/reseller-logo">
	<link rel="icon" href="//labs.partnerconsole.net/execute2/external/reseller-logo">
	<link rel="apple-touch-icon" href="//labs.partnerconsole.net/execute2/external/reseller-logo">
	<meta property="og:image" content="//labs.partnerconsole.net/execute2/external/reseller-logo"/>
	<link rel="stylesheet" href="/style.css" type="text/css" />
	<link rel="stylesheet" href="//css.ringwould.com.au/3/gradientee/stylesheet.css" type="text/css" />
	<link rel="stylesheet" href="//css.ringwould.com.au/3/shadowing/styleheet.css" type="text/css" />
	<title><?php echo $servicename; ?> (<?php echo $servicecode; ?>) Open API || Chronolabs Cooperative</title>
	<meta property="og:title" content="<?php echo $servicecode; ?> API"/>
	<meta property="og:type" content="<?php echo strtolower($servicecode); ?>-api"/>
	<!-- AddThis Smart Layers BEGIN -->
	<!-- Go to http://www.addthis.com/get/smart-layers to customize -->
	<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-50f9a1c208996c1d"></script>
	<script type="text/javascript">
	  addthis.layers({
		'theme' : 'transparent',
		'share' : {
		  'position' : 'right',
		  'numPreferredServices' : 6
		}, 
		'follow' : {
		  'services' : [
			{'service': 'twitter', 'id': 'ChronolabsCoop'},
			{'service': 'twitter', 'id': 'Cipherhouse'},
			{'service': 'twitter', 'id': 'OpenRend'},
			{'service': 'facebook', 'id': 'Chronolabs'},
			{'service': 'linkedin', 'id': 'founderandprinciple'},
			{'service': 'google_follow', 'id': '105256588269767640343'},
			{'service': 'google_follow', 'id': '116789643858806436996'}
		  ]
		},  
		'whatsnext' : {},  
		'recommended' : {
		  'title': 'Recommended for you:'
		} 
	  });
	</script>
	<!-- AddThis Smart Layers END -->
</head>
<body>
<div class="main">
    <h1><?php echo $servicename; ?> (<?php echo $servicecode; ?>) Open API || Chronolabs Cooperative</h1>
    <p style="text-align: justify; font-size: 169.2356897%; font-weight: 400">This is an API Service for generating barcodes, of all types commonality, with the option to force them to download or embedment in a PDF or HTML Page just follow the guide below on how to do this!</p>
    <h2>Code API Documentation</h2>
    <p>You can find the phpDocumentor code API documentation at the following path :: <a href="<?php echo API_URL; ?>/docs/" target="_blank"><?php echo API_URL; ?>/docs/</a>. These should outline the source code core functions and classes for the API to function!</p>   
	<?php foreach(array('jpg', 'png', 'svg', 'html') as $format) { 
		$string = getRandomArrayString(getIPIdentity('', true));
	?>
    <h2><?php echo strtoupper($format); ?> Document Output</h2>
    <p>This is done with the <em>.<?php echo $format; ?></em> extension at the end of the url, this is for the functions for barcodes to be generated in a mimetype of <strong><?php echo getMimetype($format); ?>!</strong></p>
    <blockquote>
    	<?php foreach(array('code-39', 'code-39-checksum', 'code-39e', 'code-39e-checksum', 'code-93', 'standard-2-5', 'standard-2-5-checksum', 'interleaved-2-5', 'interleaved-2-5-checksum', 'code-128', 'code-128-a', 'code-128-b', 'code-128-c', 'ean-2', 'ean-5', 'ean-8', 'ean-13', 'upc-a', 'upc-e', 'msi', 'msi-checksum', 'postnet', 'planet', 'rms4cc', 'kix', 'imb', 'codabar', 'code-11', 'pharma-code', 'pharma-code-two-track') as $mode) { ?>
        <font color="#001201">Barcode format is "<?php echo ucwords(str_replace("-", " ", $mode)); ?>" which will generate the text: '<em><?php echo $string; ?></em>' in the format of <strong><?php echo getMimetype($format); ?></strong>!</font><br/>
        <em><strong><a href="<?php echo API_URL; ?>/v2/<?php echo urlencode($string); ?>/<?php echo $mode; ?>.<?php echo $format; ?>" target="_blank"><?php echo API_URL; ?>/v2/<?php echo urlencode($string); ?>/<?php echo $mode; ?>.<?php echo $format; ?></a></strong></em><br /><br />
        <font color="#001201">Barcode download is forced in format "<?php echo ucwords(str_replace("-", " ", $mode)); ?>" of the text: '<em><?php echo $string; ?></em>' in the format of <strong><?php echo getMimetype($format); ?></strong>!</font><br/>
        <em><strong><a href="<?php echo API_URL; ?>/v2/<?php echo urlencode($string); ?>/<?php echo $mode; ?>.<?php echo $format; ?>?download" target="_blank"><?php echo API_URL; ?>/v2/<?php echo urlencode($string); ?>/<?php echo $mode; ?>.<?php echo $format; ?>?download</a></strong></em><br /><br />
		<?php } ?>
	</blockquote>
    <?php } ?>
  	<?php if (file_exists($fionf = __DIR__ .  DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'apis-localhost.html')) {
    	readfile($fionf);
    }?>	
    <?php if (!in_array(whitelistGetIP(true), whitelistGetIPAddy())) { ?>
    <h2>Limits</h2>
    <p>There is a limit of <?php echo MAXIMUM_QUERIES; ?> queries per hour. You can add yourself to the whitelist by using the following form API <a href="http://whitelist.<?php echo domain; ?>/">Whitelisting form (whitelist.<?php echo domain; ?>)</a>. This is only so this service isn't abused!!</p>
    <?php } ?>
    <h2>The Author</h2>
    <p>This was developed by Simon Roberts in 2013 and is part of the Chronolabs System and api's.<br/><br/>This is open source which you can download from <a href="https://sourceforge.net/projects/chronolabsapis/">https://sourceforge.net/projects/chronolabsapis/</a> contact the scribe  <a href="mailto:wishcraft@users.sourceforge.net">wishcraft@users.sourceforge.net</a></p></body>
</div>
</html>
<?php 
