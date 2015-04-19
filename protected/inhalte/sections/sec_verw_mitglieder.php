<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control"><input type="hidden" name="section" value="verw_mitglieder" /></div>

<div class="control line"><input type="checkbox" name="fltr1" id="fltr1" value="1"
<?php echo (($data['fltr1'])?(' checked="checked"'):('')) ?> class="right" /> <label for="fltr1">Alle einblenden</label></div>

<div class="control line"><label for="fltr2" class="left">Altersklasse</label> <select name="fltr2" id="fltr2">
<?php
echo '<option value="0"'.((0 == $data['fltr2'])?' selected="selected"':'').'></option>'."\n";
foreach($GLOBALS['Enum']['AKlaGruppe'] as $AKlaGruppe)
{
	echo '<option value="'.$AKlaGruppe.'"';
	echo (($AKlaGruppe == $data['fltr2'])?' selected="selected"':'').'>'.C2S_AKlaGruppe($AKlaGruppe).'</option>'."\n";
}
echo '<option value="4"'.((4 == $data['fltr2'])?' selected="selected"':'').'>Unbekannt</option>'."\n";
?>
</select></div>

<div class="control line"><label for="sort" class="left">Sortierung</label> <select name="sort" id="sort">
<?php
echo '<option value="0"';
echo ((0 == $data['sort'])?(' selected="selected"'):('')).'>Name</option>'."\n";
echo '<option value="1"';
echo ((1 == $data['sort'])?(' selected="selected"'):('')).'>Alter</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>

<h1>Mitglieder</h1>

<form action="index.php?section=verw_mitglieder<?php echo (($s = $data['fs_string'])?($s):('')) ?>" method="post"
	id="form_overview">

<div class="control">
<button type="submit" name="new" value="new">Neues Mitglied erstellen</button>
</div>

<div class="divided_tabs"><?php
$Anrede = S_HERR;
$MitgliedArray = $data['mitglied_array_'.$Anrede];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_verw_mitglieder.php');
$Anrede = S_DAME;
$MitgliedArray = $data['mitglied_array_'.$Anrede];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_verw_mitglieder.php');
?></div>

<div class="foot"><sup>1</sup> zum <?php echo $data['stichtag'] ?></div>

</form>

<h2>Nicht löschbare Einträge</h2>
<p>Datensätze, bei denen das 'Löschen-Symbol' nicht angezeigt wird, sind nicht löschbar. Würde dieser Datensatz gelöscht
werden, so würden abhängige Datensätze in anderen Tabellen automatisch mit gelöscht. Beispelsweise würden alle Spiele,
in denen dieser Athlet mitgespielt hat, gelöscht werden. Spielergebnismeldungen würden dadurch ungültig.</p>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>
<?php $Mitglied = $data['mitglied'] ?>

<form action="index.php?section=verw_mitglieder<?php echo (($s = $data['fs_string'])?($s):('')) ?>" method="post"
	enctype="multipart/form-data" id="form_detail" class="dokument">

<h1>Mitglied <?php echo ((MODE_NEW == $data['modus'])?('erstellen'):('bearbeiten')) ?></h1>

<?php include('protected/inhalte/schnipsel/speziell/sni_verw_mitglieder_formularteil.php') ?>

<fieldset><legend>Login-Daten</legend>

<div class="control"><label for="benutzername"><span class="mandatory">* </span>Benutzername</label> <input type="text"
	name="benutzername" id="benutzername" value="<?php echo $Mitglied->getBenutzername() ?>" maxlength="20" size="20" /></div>

<div class="control"><label for="passwort"><?php if(MODE_NEW == $data['modus']) {echo '<span class="mandatory">* </span>';} ?>Passwort
<?php if(MODE_EDIT == $data['modus']) {echo ' <span class="hint">(Muss nur angegeben werden, wenn es neu vergeben werden soll)</span>';} ?>
</label> <input type="text" name="passwort" id="passwort" maxlength="20" size="20" /></div>


</fieldset>

<fieldset><legend>Sonstiges</legend>

<div class="control"><span class="input_heading">Medien Freigabe</span>
<ul class="sidebyside">
	<li><input type="checkbox" name="freigabe_wsite" id="freigabe_wsite" value="0"
	<?php if($Mitglied->getFreigabeWSite()) {echo ' checked="checked"';} ?> /> <label for="freigabe_wsite">www.badminton-gersthofen.de</label></li>
</ul>
<ul class="sidebyside">
	<li><input type="checkbox" name="freigabe_fbook" id="freigabe_fbook" value="0"
	<?php if($Mitglied->getFreigabeFBook()) {echo ' checked="checked"';} ?> /> <label for="freigabe_fbook">Facebook</label></li>
</ul>
</div>

<br />

<div class="control"><span class="input_heading">Anzeigestatus</span>
<ul class="sidebyside">
	<li><input type="checkbox" name="ausblenden" id="ausblenden" value="1"
	<?php if($Mitglied->getAusblenden()) {echo ' checked="checked"';} ?> /> <label for="ausblenden">ausgeblendet</label></li>
</ul>
</div>

</fieldset>


<fieldset>

<p>Mit <span class="mandatory">* </span>markierte Eingabefelder müssen ausgefüllt werden.</p>

<p class="formularbuttons">
<button type="submit" name="save" value="save">Speichern</button>
<button type="submit" name="cancel" value="cancel">Abbrechen</button>
</p>

</fieldset>

</form>

<h2>Hinweise zum Ausfüllen</h2>
	<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_textfelder_gew.php') ?>
	<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_textfelder_spe.php') ?>
	<?php include('protected/inhalte/schnipsel/allgemein/sni_hinweis_bilder-upload.php') ?>

	<?php /*===========================================================================================================*/ ?>
	<?php } ?>
	<?php /*===========================================================================================================*/ ?>