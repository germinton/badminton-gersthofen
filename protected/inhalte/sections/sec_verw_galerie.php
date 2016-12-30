<?php /*===========================================================================================================*/ ?>
<?php if (VIEW_LIST == $data['view']) {
    ?>
<?php /*===========================================================================================================*/ ?>

<?php /*
<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control hidden"><input type="hidden" name="section" value="verw_galerie" /></div>


<div class="control line"><label for="sort" class="left">Sortierung</label> <select name="sort" id="sort">
<?php
echo '<option value="0"'.((0 == $data['sort'])?(' selected="selected"'):('')).'>Datum</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>
*/ ?>


<h1>Galerieeinträge</h1>

<form action="index.php?section=verw_galerie" method="post" id="form_overview">

<div class="control">
<button type="submit" name="new" value="new">Neuen Galerieeintrag erstellen</button>
</div>

<?php
$GalerieArray = $data['galerie_array'];
    include('protected/inhalte/schnipsel/tabellen/sni_tabelle_verw_galerie.php')
?></form>


<?php /*===========================================================================================================*/ ?>
<?php

} elseif (VIEW_DETAIL == $data['view']) {
    ?>
<?php /*===========================================================================================================*/ ?>
<?php $Galerieeintrag = $data['galerieeintrag'] ?>

<form action="index.php?section=verw_galerie" method="post"
	enctype="multipart/form-data" id="form_detail" class="dokument">

<h1>Galerieeintrag <?php echo (MODE_NEW == $data['modus']) ? ('erstellen') : ('bearbeiten') ?></h1>

<fieldset>

<div class="control hidden"><input type="hidden" name="galerieeintrag_id" value="<?php echo $Galerieeintrag->getGalerieeintragID() ?>" /></div>

<div class="control"><label for="titel">Titel</label> <input type="text" name="titel" id="titel"
	value="<?php echo $Galerieeintrag->getTitel() ?>" maxlength="100" size="100" /></div>

<br />

<div class="control"><label for="datum">Datum des Ereignisses</label> <input type="text" id="datum"
	class="w8em format-d-m-y divider-dot range-high-<?php echo $data['heute'] ?> highlight-days-67 no-transparency"
	name="datum" value="<?php echo $Galerieeintrag->getDatum(GET_DTDE) ?>" size="8" maxlength="10" /></div>

<br />
<br />
<br />

<img src="bilder/rsslinkfoto.png" alt="" height="32" style="border-style: none" />

<br />

<div class="control"><label for="picasa_authkey">Picasa Album ID (im RSS-Link auszulesen)</label> <input type="text" name="picasa_albumid" id="picasa_albumid"
	value="<?php echo $Galerieeintrag->getPicasaAlbumID() ?>" maxlength="50" size="30" /></div>

<div class="control"><label for="picasa_authkey">Picasa Authkey</label> <input type="text" name="picasa_authkey" id="picasa_authkey"
	value="<?php echo $Galerieeintrag->getPicasaAuthkey() ?>" maxlength="50" size="30" /></div>

<br />

<div class="control"><label for="google_photos_link">Google Photos Link</label><input type="text" name="google_photos_link" id="google_photos_link" value="<?php echo $Galerieeintrag->getGooglePhotosLink() ?>" size="60"/></div>

<div class="control"><label for="freitext">Freitext <span class="hint">(<a href="#hinweis_textfelder_spe">XHTML erlaubt</a>)</span></label>
<textarea name="freitext" id="freitext" cols="75" rows="12"><?php echo $Galerieeintrag->getFreitext(GET_HSPC) ?></textarea>
</div>

<br />

</fieldset>

<fieldset><?php
$Obj = $Galerieeintrag;
    $AttachType = ATTACH_FILE1;
    include 'protected/inhalte/schnipsel/allgemein/sni_control_dateien-upload.php';
    $AttachType = ATTACH_FILE2;
    include 'protected/inhalte/schnipsel/allgemein/sni_control_dateien-upload.php';
    $AttachType = ATTACH_FILE3;
    include 'protected/inhalte/schnipsel/allgemein/sni_control_dateien-upload.php'; ?></fieldset>

<fieldset>

<p class="formularbuttons">
<button type="submit" name="save" value="save">Speichern</button>
<button type="submit" name="cancel" value="cancel">Abbrechen</button>
</p>

</fieldset>

</form>

<h2>Hinweise zum Ausfüllen</h2>
<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_textfelder_gew.php') ?>
<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_textfelder_spe.php') ?>
<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_dateien-upload.php') ?>

<?php /*===========================================================================================================*/ ?>
<?php

} ?>
<?php /*===========================================================================================================*/ ?>
