<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control"><input type="hidden" name="section" value="sperml_freund" /></div>

<div class="control line"><label for="fltr1" class="left">Saison</label> <select name="fltr1" id="fltr1">
<?php
echo '<option value="0"'.((!$data['fltr1'])?' selected="selected"':'').'></option>'."\n";
foreach($data['fltr1_array'] as $Saison)
{
	echo '<option value="'.$Saison->getSaisonID().'"';
	echo (($Saison->getSaisonID() == $data['fltr1'])?' selected="selected"':'').'>'.$Saison.'</option>'."\n";
}
?>
</select></div>

<div class="control line"><label for="sort" class="left">Sortierung</label> <select name="sort" id="sort">
<?php
echo '<option value="0"'.((0 == $data['sort'])?(' selected="selected"'):('')).'>Datum aufst.</option>'."\n";
echo '<option value="1"'.((1 == $data['sort'])?(' selected="selected"'):('')).'>Datum abst.</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>

<h1>Freundschaftsspiel-<br />
ergebnismeldungen</h1>

<?php
$SpErMl_X_Array = $data['sperml_x_array'];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_sperml_freund.php');
?>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>
<?php $SpErMl_X = $data['sperml_x'] ?>

<div class="textbox"><a href="javascript:history.back(-1)">Zurückblättern</a> oder <a
	href="index.php?section=sperml_freund<?php echo (($s = $data['fs_string'])?($s):('')) ?>">zur Übersicht</a><br />
&nbsp;</div>

<?php echo $SpErMl_X->getXHTML() ?>

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>