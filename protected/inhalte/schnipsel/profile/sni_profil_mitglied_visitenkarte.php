<?php $Height = 100; $XHTMLforIMG = $Mitglied->getXHTMLforIMG(false, $Height) ?>

<div class="profil mitglied visitenkarte" id="athlet_id:<?php echo $Mitglied->getAthletID() ?>"
<?php echo (($XHTMLforIMG)?('style="min-height:'.($Height+5).'px"'):('')) ?>><?php echo $XHTMLforIMG ?>

<h2>Visitenkarte von <?php echo $Mitglied ?></h2>

<dl>
	<dt>Name</dt>
	<dd><?php echo $Mitglied->getVornameNachname() ?></dd>
	<dt>Straße</dt>
	<dd><?php echo $Mitglied->getStrasse(GET_NBSP) ?></dd>
	<dt>Ort</dt>
	<dd><?php echo $Mitglied->getPLZ(GET_NBSP).'&nbsp;'.$Mitglied->getOrt(GET_NBSP) ?></dd>
	<dt>Privat</dt>
	<dd><?php echo $Mitglied->getTelPriv(GET_NBSP) ?></dd>
	<dt>Mobil</dt>
	<dd><?php echo $Mitglied->getTelMobil(GET_NBSP) ?></dd>
	<dt>E-Mail</dt>
	<dd><?php echo $Mitglied->getEMail(array(GET_NBSP, GET_SPEC)) ?></dd>
</dl>

</div>
