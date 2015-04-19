<?php $Height = 200; $XHTMLforIMG = $Austragungsort->getXHTMLforIMG(false, $Height) ?>

<div class="profil austragungsort" id="austragungsort_id:<?php echo $Austragungsort->getAustragungsortID() ?>">

<h2><?php
echo $Austragungsort->getHallenname().', '.$Austragungsort->getOrt().PHP_EOL;
if(!is_null($Verein = $Austragungsort->getVereinID(GET_OFID))) {echo '<br />'.$Verein->getHomepage(GET_SPEC).PHP_EOL;}
?></h2>

<?php
if($Austragungsort->hasGMapCoord())
{
	$GMapLat = $Austragungsort->getGMapLat(GET_SPEC);
	$GMapLon = $Austragungsort->getGMapLon(GET_SPEC);
	echo '<div class="profil_austragungsort_gmaps" ';
	echo 'id="gmap_austragungsort_id:'.$Austragungsort->getAustragungsortID().'">';
	echo $GMapLat.';'.$GMapLon;
	echo '</div>';
}
?>

<div <?php echo (($XHTMLforIMG)?('style="min-height:'.($Height+5).'px"'):('')) ?>><?php echo $XHTMLforIMG ?>
<h3>Adresse</h3>
<?php
echo '<p>'.PHP_EOL;
echo (($s = $Austragungsort->getStrasse())?($s.', '.PHP_EOL):(''));
echo (($s = $Austragungsort->getPLZ())?($s.'&nbsp;'):('')).$Austragungsort->getOrt().PHP_EOL;
echo '<br />'.$Austragungsort->getRoutePlannerLink().PHP_EOL;
echo '</p>'.PHP_EOL;

$felder = $Austragungsort->getFelder();
$info = $Austragungsort->getInfo(GET_SPEC);

if($info or $felder)
{
	echo '<h3>Weitere Infos</h3>'.PHP_EOL;
	if($felder) {echo '<p>Die Halle hat '.$felder.' Felder.</p>'.PHP_EOL;}
	if($info) {echo '<div class="profil_austragungsort_info">'.$info.'</div>'.PHP_EOL;}
}
?></div>
</div>
