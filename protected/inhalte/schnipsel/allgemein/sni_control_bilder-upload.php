<?php
if(!isset($Height)) {$Height = 100;}

echo '<input type="hidden" name="MAX_FILE_SIZE" value="'.MAX_FILE_SIZE_ATTACH_PIC.'" />'.PHP_EOL;
?>
<div class="control"><span class="input_heading">Bild</span><?php echo $Obj->getXHTMLforIMG(true, $Height) ?>

<ul class="onebelowtheother" <?php if($Height > 100) {echo 'style="margin-top: '.($Height+15).'px"';} ?>>
<?php
$src = $Obj->getAttachmentPath(ATTACH_PIC);
echo '<li><input type="radio" name="pic" id="pic_nil" value="'.PROC_NIL.'" checked="checked" /> '.
'<label for="pic_nil">'.((file_exists($src))?('behalten'):('ist nicht vorhanden')).'</label></li>'."\n";
echo '<li><input type="radio" name="pic" id="pic_upl" value="'.PROC_UPL.'" /> '.
'<label for="pic_upl">'.((file_exists($src))?('ersetzen durch'):('hochladen von')).
' (<a href="#hinweis_bilder-upload">Hinweise für den Upload von Bildern beachten!</a>)'.
'<input type="file" name="userfile['.ATTACH_PIC.']" /></label></li>'."\n";
if(file_exists($src)) {
	echo '<li><input type="radio" name="pic" id="pic_del" value="'.PROC_DEL.'" /> ';
	echo '<label for="pic_del">löschen</label></li>'."\n";
}
?>
</ul>
</div>
