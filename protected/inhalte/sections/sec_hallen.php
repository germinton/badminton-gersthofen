<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control"><input type="hidden" name="section" value="hallen" /></div>

<div class="control line"><label for="fltr1" class="left">Verein</label> <select name="fltr1" id="fltr1">
<?php
echo '<option value="0"'.((!$data['fltr1'])?' selected="selected"':'').'>Alle Vereine</option>'."\n";
foreach($data['fltr1_array'] as $Verein)
{
	echo '<option value="'.$Verein->getVereinID().'"';
	echo (($Verein->getVereinID() == $data['fltr1'])?' selected="selected"':'').'>'.$Verein.'</option>'."\n";
}
?>
</select></div>

<div class="control line"><label for="sort" class="left">Sortierung</label> <select name="sort" id="sort">
<?php
echo '<option value="0"';
echo ((0 == $data['sort'])?(' selected="selected"'):('')).'>Ort</option>'."\n";
echo '<option value="1"';
echo ((1 == $data['sort'])?(' selected="selected"'):('')).'>Verein</option>'."\n";
echo '<option value="2"';
echo ((2 == $data['sort'])?(' selected="selected"'):('')).'>Hallenname</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>

<h1>Sporthallen</h1>

<?php
$AustragungsortArray = $data['austragungsort_array'];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_hallen.php');
?>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>
<?php $Austragungsort = $data['austragungsort'] ?>

<div class="textbox"><a href="javascript:history.back(-1)">Zurückblättern</a> oder <a
	href="index.php?section=hallen<?php echo (($s = $data['fs_string'])?($s):('')) ?>">zur Übersicht</a><br />
&nbsp;</div>

<?php echo sni_ProfilAustragungsort($Austragungsort->getAustragungsortID()) ?>

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>