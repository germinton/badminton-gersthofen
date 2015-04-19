<?php
$xhtml = '<h1>QuickScript</h1>'.PHP_EOL;
/*
 $dateien = scandir(DIR_ATTACHMENTS.'/austragungsorte');

 foreach($dateien as $datei)
 {
 if(!($datei == '.' or $datei == '..'))
 {
 $xhtml .= $datei.'<br />'.PHP_EOL;
 list($width, $height, $type) = getimagesize(DIR_ATTACHMENTS.'/austragungsorte/'.$datei);
 if(($width > MAX_IMG_DIM) or ($height > MAX_IMG_DIM)) {
 $xhtml .= 'SHRUNK!<br />'.PHP_EOL;
 ShrinkJpegImage(DIR_ATTACHMENTS.'/austragungsorte/'.$datei);
 }
 }
 }
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// RETURN
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$data['xhtml'] = $xhtml;
return new CTemplateData($data, true);
?>