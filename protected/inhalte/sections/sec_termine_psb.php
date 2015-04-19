<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control hidden"><input type="hidden" name="section" value="termine_psb" /></div>

<div class="control line"><label for="fltr1" class="left">Mannschaft</label> <select name="fltr1" id="fltr1">
<?php
echo '<option value="0"'.((!$data['fltr1'])?' selected="selected"':'').'>Alle Mannschaften</option>'."\n";
foreach($data['fltr1_array'] as $Mannschaft)
{
	echo '<option value="'.$Mannschaft->getMannschaftID().'"';
	echo (($Mannschaft->getMannschaftID() == $data['fltr1'])?' selected="selected"':'').'>'.$Mannschaft.'</option>'."\n";
}
?>
</select></div>

<div class="control line"><label for="group" class="left">Gruppierung</label> <select name="group" id="group">
<?php
echo '<option value="0"'.((0 == $data['group'])?(' selected="selected"'):('')).'>Mannschaft</option>'."\n";
echo '<option value="1"'.((1 == $data['group'])?(' selected="selected"'):('')).'>Monat</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>

<h1>Punktspieltermine <?php echo new CSaison(CDBConnection::getInstance()->getSaisonID()) ?></h1>

<?php /*===========================================================================================================*/ ?>
<?php if(0 == $data['group']) { // Mannschaft ?>
<?php /*===========================================================================================================*/ ?>

<?php
$TerminPSBArrayArrayArray = $data['termin_psb_array_array_array'];
foreach($TerminPSBArrayArrayArray as $MannschaftID => $TerminPSBArrayArray)
{
	$Mannschaft = new CMannschaft($MannschaftID);
	echo '<h2>'.$Mannschaft.'</h2>'."\n";
	$resetResult = reset($TerminPSBArrayArray);
	if(reset($resetResult) instanceof CTerminPSB) {
		include('protected/inhalte/schnipsel/speziell/sni_mannschaft_doppelspieltagsansicht.php');
	}
	else {
		echo '<p class="textbox schattiert">Keine Punktspieltermine für '.$Mannschaft.'.</p>';
	}
}
?>

<?php /*===========================================================================================================*/ ?>
<?php } else { ?>
<?php /*===========================================================================================================*/ ?>

<?php
$TerminPSBArrayArrayArrayArray = $data['termin_psb_array_array_array_array'];
$Saison = new CSaison(CDBConnection::getInstance()->getSaisonID());
$Jahr = (int)substr($Saison->getBeginn(), 0, 4);
foreach($TerminPSBArrayArrayArrayArray as $Monat => $TerminPSBArrayArrayArray)
{
	$MonatString = C2S_Monat($Monat).' '.$Jahr;

	$Tmp1 = reset($TerminPSBArrayArrayArray);
	$Tmp2 = reset($Tmp1);
	if(reset($Tmp2) instanceof CTerminPSB)
	{
		echo '<h2>'.$MonatString.'</h2>'."\n";
		include('protected/inhalte/schnipsel/speziell/sni_termin_psb_monatsdoppelspieltagsansicht.php');
	}
	else if(C2S_Monat(date('n')).' '.date('Y') == $MonatString)
	{
		echo '<h2>'.$MonatString.'</h2>'."\n";
		echo '<p class="textbox schattiert">Keine Punktspieltermine im '.C2S_Monat($Monat).'.</p>';
	}

	if(12 == $Monat) {$Jahr++;}
}
?>

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>