<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control"><input type="hidden" name="section" value="ms_steckbriefe" /></div>

<div class="control line"><label for="fltr1" class="left">Altersklasse</label> <select name="fltr1" id="fltr1">
<?php
echo '<option value="0"'.((0 == $data['fltr1'])?' selected="selected"':'').'></option>'."\n";
foreach($GLOBALS['Enum']['AKlaGruppe'] as $AKlaGruppe)
{
	echo '<option value="'.$AKlaGruppe.'"';
	echo (($AKlaGruppe == $data['fltr1'])?' selected="selected"':'').'>'.C2S_AKlaGruppe($AKlaGruppe).'</option>'."\n";
}
echo '<option value="4"'.((4 == $data['fltr1'])?' selected="selected"':'').'>Unbekannt</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>

<h1>Steckbriefe</h1>

<div class="divided_tabs"><?php
$Anrede = S_HERR;
$MitgliedArray = $data['mitglied_array_'.$Anrede];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_ms_steckbriefe.php');
$Anrede = S_DAME;
$MitgliedArray = $data['mitglied_array_'.$Anrede];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_ms_steckbriefe.php');
?></div>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>
<?php $Mitglied = $data['mitglied'] ?>

<div class="textbox"><a href="index.php?section=ms_steckbriefe<?php echo (($s = $data['fs_string'])?($s):('')) ?>">Zurück
zur Übersicht</a><br />
&nbsp;</div>

<div><?php
if($SiteManager->getMitglied() instanceof CMitglied) {
	if(count($aa = $SiteManager->getMitglied()->getAufgabenstringArray()))
	{
		echo '<div class="info papier">'."\n";
		echo '<p>Du bist ';
		$i = 0;
		foreach($aa as $AString) {echo (($i++)?(' und '):('')).$AString;}
		echo '. Aus diesem Grund darfst Du das private Profil Deiner ';
		echo 'Sportskameraden einsehen. Jemand, der kein Amt in unserer Sparte hat, sieht lediglich ein verkürztes ';
		echo 'Profil.</p>'."\n";
		echo '</div>'."\n";
		echo sni_ProfilMitgliedPrivat($data['mitglied']->getAthletID());
	}
	else {
		echo sni_ProfilMitgliedSteckbrief($data['mitglied']->getAthletID());
	}
}
else {
	echo sni_ProfilMitgliedSteckbrief($data['mitglied']->getAthletID());
}
?></div>

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>