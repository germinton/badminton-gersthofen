<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<h1>Vereine</h1>

<div class="divided_tabs"><?php
$VereinArray = $data['verein_array'];
$VereinArrayArray = array_chunk($VereinArray, ((count($VereinArray)+(count($VereinArray)%2))/2));
$Part = 1;
$VereinArray = $VereinArrayArray[$Part-1];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_vereine.php');
$Part = 2;
$VereinArray = $VereinArrayArray[$Part-1];
include('protected/inhalte/schnipsel/tabellen/sni_tabelle_vereine.php');
?></div>

<?php /*===========================================================================================================*/ ?>
<?php } else if(VIEW_DETAIL == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<?php // NOT USED ?>

<?php /*===========================================================================================================*/ ?>
<?php } ?>
<?php /*===========================================================================================================*/ ?>