<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<h1>Aufgabenverteilung</h1>

<p>Ohne das ehrenamtliche Engagement unserer Mitglieder gäbe es die Sparte nicht. Auf dieser Seite wollen wir uns bei
den Helferinnen und Helfern bedanken, die ein wenig ihrer wertvollen Zeit der Sparte widmen und damit aktiv zum
reibungslosen Ablauf von Training und Wettkämpfen sowie natürlich unseren sozialen Events beitragen.</p>

<div class="divided_tabs"><?php
$MitgliedArray = $data['mitglied_array'];
$MitgliedArrayArray = array_chunk($MitgliedArray, ((count($MitgliedArray)+(count($MitgliedArray)%2))/2));
$Part = 1;
$MitgliedArray = $MitgliedArrayArray[$Part-1];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_aufgabenverteilung.php');
$Part = 2;
$MitgliedArray = $MitgliedArrayArray[$Part-1];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_aufgabenverteilung.php');
?></div>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<?php // NOT USED ?>

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>