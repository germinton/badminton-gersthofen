<?php
if(!isset($Height)) {$Height = 100;}
if(!isset($AttachType)) {throw new Exception('$AttachType benötigt!');}
if(ATTACH_PIC == $AttachType) {throw new Exception('ATTACH_PIC als $AttachType nicht erlaubt!');}
$i = 0;
switch($AttachType)
{
	case ATTACH_FILE1: $i = 1; break;
	case ATTACH_FILE2: $i = 2; break;
	case ATTACH_FILE3: $i = 3; break;
	default: break;
}
$Heading = 'Anhang '.(($Obj->hasAttachment($AttachType))?('"'.$Obj->getAttachmentShortFilename($AttachType).'"'):($i));

echo '<input type="hidden" name="MAX_FILE_SIZE" value="'.MAX_FILE_SIZE_ATTACH_FILE.'" />'.PHP_EOL;
?>
<div class="control"><span class="input_heading"><?php echo $Heading ?></span><?php echo $Obj->getXHTMLforFILE($AttachType, true, $Height) ?>

<ul class="onebelowtheother">
<?php
$src = $Obj->getAttachmentPath($AttachType);
echo '<li><input type="radio" name="file'.$i.'" id="file'.$i.'_nil" value="'.PROC_NIL.'" checked="checked" /> '.
'<label for="file'.$i.'_nil">'.((file_exists($src))?('behalten'):('ist nicht vorhanden')).'</label></li>'."\n";
echo '<li><input type="radio" name="file'.$i.'" id="file'.$i.'_upl" value="'.PROC_UPL.'" /> '.
'<label for="file'.$i.'_upl">'.((file_exists($src))?('ersetzen durch'):('hochladen von')).
' (<a href="#hinweis_dateien-upload">Hinweise für den Upload von Anhängen beachten!</a>)'.
'<input type="file" name="userfile['.$AttachType.']" /></label></li>'."\n";
if(file_exists($src)) {
	echo '<li><input type="radio" name="file'.$i.'" id="file'.$i.'_del" value="'.PROC_DEL.'" /> ';
	echo '<label for="file'.$i.'_del">löschen</label></li>'."\n";
}
?>
</ul>
</div>
