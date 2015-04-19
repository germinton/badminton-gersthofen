<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control"><input type="hidden" name="section" value="verw_aufgaben" /></div>

<div class="control line"><label for="fltr1" class="left">Aufgabentyp</label> <select name="fltr1" id="fltr1">
<?php
echo '<option value="0"'.((0 == $data['fltr1'])?' selected="selected"':'').'></option>'."\n";
foreach($GLOBALS['Enum']['Aufgabentyp'] as $Aufgabentyp)
{
	echo '<option value="'.$Aufgabentyp.'"';
	echo (($Aufgabentyp == $data['fltr1'])?' selected="selected"':'').'>'.C2S_Aufgabentyp($Aufgabentyp).'</option>'."\n";
}
?>
</select></div>


<div class="control line"><label for="sort" class="left">Sortierung</label> <select name="sort" id="sort">
<?php
echo '<option value="0"';
echo ((0 == $data['sort'])?(' selected="selected"'):('')).'>Aufgabentyp</option>'."\n";
echo '<option value="1"';
echo ((1 == $data['sort'])?(' selected="selected"'):('')).'>Wichtigkeit</option>'."\n";
echo '<option value="2"';
echo ((2 == $data['sort'])?(' selected="selected"'):('')).'>Bezeichnung Männlich</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>

<h1>Aufgaben</h1>

<form action="index.php?section=verw_aufgaben<?php echo (($s = $data['fs_string'])?($s):('')) ?>" method="post"
	id="form_overview">

<div class="control">
<button type="submit" name="new" value="new">Neue Aufgabe erstellen</button>
</div>

<?php
$AufgabenArray = $data['aufgaben_array'];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_verw_aufgaben.php')
?></form>

<h2>Nicht löschbare Einträge</h2>
<p>Datensätze, bei denen das 'Löschen-Symbol' nicht angezeigt wird, sind nicht löschbar. Würde dieser Datensatz gelöscht
werden, so muss der Quellcode aktualisiert werden. Dies hängt mit dem Berechtigungskonzept (u. A. navigation.php)
zusammen.</p>


<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>
<?php $Aufgabe = $data['aufgabe'] ?>

<form action="index.php?section=verw_aufgaben<?php echo (($s = $data['fs_string'])?($s):('')) ?>" method="post"
	id="form_detail" class="dokument">

<h1>Aufgabe <?php echo ((MODE_NEW == $data['modus'])?('erstellen'):('bearbeiten')) ?></h1>

<fieldset>

<div class="control hidden"><input type="hidden" name="aufgabe_id" value="<?php echo $Aufgabe->getAufgabeID() ?>" /></div>


<div class="control"><label for="bez_maennlich">Bezeichnung männlich</label> <input type="text" name="bez_maennlich"
	id="bez_maennlich" value="<?php echo $Aufgabe->getBezMaennlich() ?>" maxlength="30" size="30" /></div>

<div class="control"><label for="bez_weiblich">Bezeichnung weiblich</label> <input type="text" name="bez_weiblich"
	id="bez_weiblich" value="<?php echo $Aufgabe->getBezWeiblich() ?>" maxlength="30" size="30" /></div>

<br />

<div class="control"><label for="aufgabentyp">Aufgabentyp</label> <select name="aufgabentyp" id="aufgabentyp">
<?php
foreach($GLOBALS['Enum']['Aufgabentyp'] as $Aufgabentyp)
{
	echo '<option value="'.$Aufgabentyp.'"';
	echo (($Aufgabentyp == $Aufgabe->getAufgabentyp())?(' selected="selected"'):('')).'>'.C2S_Aufgabentyp($Aufgabentyp).'</option>'."\n";
}
?>
</select></div>

<div class="control"><label for="sortierung">Sortierung</label> <input type="text" name="sortierung" id="sortierung"
	value="<?php echo $Aufgabe->getSortierung() ?>" maxlength="3" size="3" /></div>

<br />

<div class="control"><label for="freitext">Freitext <span class="hint">(<a href="#hinweis_textfelder_spe">XHTML erlaubt</a>)</span></label>
<textarea name="freitext" id="freitext" cols="75" rows="12"><?php echo $Aufgabe->getFreitext(GET_HSPC) ?></textarea></div>

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

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>