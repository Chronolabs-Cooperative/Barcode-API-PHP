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
<meta property="og:title" content="<?php echo API_VERSION; ?>"/>
<meta property="og:type" content="api<?php echo API_TYPE; ?>"/>
<meta property="og:image" content="<?php echo API_URL; ?>/assets/images/logo_500x500.png"/>
<meta property="og:url" content="<?php echo (isset($_SERVER["HTTPS"])?"https://":"http://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]; ?>" />
<meta property="og:site_name" content="<?php echo API_VERSION; ?> - <?php echo API_LICENSE_COMPANY; ?>"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="rating" content="general" />
<meta http-equiv="<?php echo $place['iso2']; ?>thor" content="wishcraft@users.sourceforge.net" />
<meta http-equiv="copyright" content="<?php echo API_LICENSE_COMPANY; ?> &copy; <?php echo date("Y"); ?>" />
<meta http-equiv="generator" content="Chronolabs Cooperative (<?php echo $place['iso3']; ?>)" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo API_VERSION; ?> || <?php echo API_LICENSE_COMPANY; ?></title>
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
		{'service': 'facebook', 'id': 'ChronolabsCoop'},
		{'service': 'twitter', 'id': 'AntonyXaies'},
		{'service': 'twitter', 'id': 'ChronolabsCoop'},
		{'service': 'twitter', 'id': 'OpenRend'},
	  ]
	},  
	'whatsnext' : {},  
	'recommended' : {
	  'title': 'Recommended for you:'
	} 
  });
</script>
<!-- AddThis Smart Layers END -->
<link rel="stylesheet" href="<?php echo API_URL; ?>/assets/css/style.css" type="text/css" />
<!-- Custom Fonts -->
<link href="<?php echo API_URL; ?>/assets/media/Labtop/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Labtop Bold/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Labtop Bold Italic/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Labtop Italic/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Labtop Superwide Boldish/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Labtop Thin/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Labtop Unicase/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/LHF Matthews Thin/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Life BT Bold/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Life BT Bold Italic/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Prestige Elite/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Prestige Elite Bold/style.css" rel="stylesheet" type="text/css">
<link href="<?php echo API_URL; ?>/assets/media/Prestige Elite Normal/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="<?php echo API_URL; ?>/assets/css/gradients.php" type="text/css" />
<link rel="stylesheet" href="<?php echo API_URL; ?>/assets/css/shadowing.php" type="text/css" />

</head>

<body>
<div class="main">
	<img style="float: right; margin: 11px; width: auto; height: auto; clear: none;" src="<?php echo API_URL; ?>/assets/images/logo_350x350.png" />
    <h1><?php echo API_VERSION; ?> -- <?php echo API_LICENSE_COMPANY; ?></h1>
    <p style="text-align: justify; font-size: 169.2356897%; font-weight: 400">This is an API Service for generating barcodes, of all types commonality, with the option to force them to download or embedment in a PDF or HTML Page just follow the guide below on how to do this!</p>
    <?php foreach(array('gif', 'jpg', 'png', 'svg', 'html', 'unicode', 'binary') as $format) { ?>
    <h2><?php echo strtoupper($format); ?> Document Output</h2>
    <p>This is done with the <em>.<?php echo $format; ?></em> extension at the end of the url, this is for the functions for barcodes to be generated as an image or data outputs!</strong></p>
    <blockquote>
    	<?php foreach(getBarcodes() as $code => $title) { ?>
    	<?php $string = chr(mt_rand(ord('a'), ord('z'))) . chr(mt_rand(ord('A'), ord('Z'))) . chr(mt_rand(ord('A'), ord('Z'))) . chr(mt_rand(ord('1'), ord('9'))) . chr(mt_rand(ord('0'), ord('9'))) . chr(mt_rand(ord('1'), ord('9'))) . chr(mt_rand(ord('a'), ord('z'))) . chr(mt_rand(ord('1'), ord('9'))) . chr(mt_rand(ord('a'), ord('z'))) . chr(mt_rand(ord('1'), ord('9'))); ?>
        <font class="help-title-text">Outputs Barcode format is "<?php echo ucwords($title); ?>" will generate text: '<em><?php echo $string; ?></em>' which is 000000 with a background of FFFFFF; with the width of :: <?php echo $width = mt_rand(-20,20); ?> as well as the height :: <?php echo $height = mt_rand(-20,20); ?> and with the padding of  :: <?php echo $padding = mt_rand(-8,8); ?></em>!</font><br/>
        <font class="help-url-example"><a href="<?php echo API_URL; ?>/v3/<?php echo $string; ?>/<?php echo $width; ?>/<?php echo $height; ?>/<?php echo $padding; ?>/FFFFFF/000000/<?php echo $code; ?>,H.<?php echo $format; ?>" target="_blank"><?php echo API_URL; ?>/v3/<?php echo $string; ?>/<?php echo $width; ?>/<?php echo $height; ?>/<?php echo $padding; ?>/FFFFFF/000000/<?php echo $code; ?>.<?php echo $format; ?></a></font><br />
        <?php $string = chr(mt_rand(ord('A'), ord('Z'))) . chr(mt_rand(ord('a'), ord('z'))) . chr(mt_rand(ord('a'), ord('z'))) . chr(mt_rand(ord('1'), ord('9'))) . chr(mt_rand(ord('A'), ord('Z'))) . chr(mt_rand(ord('1'), ord('9'))) . chr(mt_rand(ord('a'), ord('z'))) . chr(mt_rand(ord('1'), ord('9'))) . chr(mt_rand(ord('a'), ord('z'))) . chr(mt_rand(ord('1'), ord('9'))); ?>
        <font class="help-title-text">Outputs Barcode format is "<?php echo ucwords($title); ?>" will generate text: '<em><?php echo $string; ?></em>' which is 000000 with a background of FFFFFF; with the width of :: <?php echo $width = mt_rand(-20,20); ?> as well as the height :: <?php echo $height = mt_rand(-20,20); ?> and with the padding of  :: <?php echo $padding = mt_rand(-8,8); ?>; this is with the extended parameter of H as: <em><?php echo $code; ?>,H</em>!</font><br/>
        <font class="help-url-example"><a href="<?php echo API_URL; ?>/v3/<?php echo $string; ?>/<?php echo $width; ?>/<?php echo $height; ?>/<?php echo $padding; ?>/FFFFFF/000000/<?php echo $code; ?>,H.<?php echo $format; ?>" target="_blank"><?php echo API_URL; ?>/v3/<?php echo $string; ?>/<?php echo $width; ?>/<?php echo $height; ?>/<?php echo $padding; ?>/FFFFFF/000000/<?php echo $code; ?>,H.<?php echo $format; ?></a></font><br />
        <?php $string = chr(mt_rand(ord('a'), ord('z'))) . chr(mt_rand(ord('A'), ord('Z'))) . chr(mt_rand(ord('0'), ord('9'))) . chr(mt_rand(ord('a'), ord('z'))) . chr(mt_rand(ord('a'), ord('z'))) . chr(mt_rand(ord('1'), ord('9'))) . chr(mt_rand(ord('a'), ord('z'))) . chr(mt_rand(ord('1'), ord('9'))) . chr(mt_rand(ord('a'), ord('z'))) . chr(mt_rand(ord('1'), ord('9'))); ?>
        <font class="help-title-text">Forces Download of Barcode format is "<?php echo ucwords($title); ?>" will generate text: '<em><?php echo $string; ?></em>' which is 000000 with a background of FFFFFF; with the width of :: <?php echo $width = mt_rand(-20,20); ?> as well as the height :: <?php echo $height = mt_rand(-20,20); ?> and with the padding of  :: <?php echo $padding = mt_rand(-8,8); ?></em>!</font><br/>
        <font class="help-url-example"><a href="<?php echo API_URL; ?>/v3/<?php echo $string; ?>/<?php echo $width; ?>/<?php echo $height; ?>/<?php echo $padding; ?>/FFFFFF/000000/<?php echo $code; ?>,H.<?php echo $format; ?>?download" target="_blank"><?php echo API_URL; ?>/v3/<?php echo $string; ?>/<?php echo $width; ?>/<?php echo $height; ?>/<?php echo $padding; ?>/FFFFFF/000000/<?php echo $code; ?>.<?php echo $format; ?>?download</a></font><br /><br />
        <?php } ?>
	</blockquote>
    <?php } ?>
    <h2>The Author</h2>
    <p>This was developed by Simon Roberts in 2018 and is part of the Chronolabs System and api's.<br/><br/>This is open source which you can download from <a href="https://sourceforge.net/projects/chronolabsapis/">https://sourceforge.net/projects/chronolabsapis/</a> contact the scribe  <a href="mailto:chronolabscoop@users.sourceforge.net">chronolabscoop@users.sourceforge.net</a><br/><br/>You can get this source code from the following repository: <a href="https://github.com/Chronolabs-Cooperative/Barcode-API-PHP" target="_blank">https://github.com/Chronolabs-Cooperative/Barcode-API-PHP</a></p></body>
</div>
</html>
<?php 
