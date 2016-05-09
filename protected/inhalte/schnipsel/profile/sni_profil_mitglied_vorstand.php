<?php $Height = 100; $XHTMLforIMG = $Mitglied->getXHTMLforIMG(false, $Height) ?>

<div class="profil mitglied vorstand" id="athlet_id:<?php echo $Mitglied->getAthletID() ?>"
<?php echo ($XHTMLforIMG) ? ('style="min-height:'.($Height + 5).'px"') : ('') ?>><?php echo $XHTMLforIMG ?>

<h2>Visitenkarte von <?php echo $Mitglied ?></h2>

<dl>
	<dt>Name</dt>
	<dd><?php echo $Mitglied->getVornameNachname() ?></dd>
	<?php if (count($aa = $Mitglied->getAufgabenstringArray())) {
    ?>
  <dt>Aufgaben</dt>
	<dd><?php foreach ($aa as $AString) {
    echo $AString.'<br />';
}
    ?></dd>
	<?php

} ?>
</dl>

</div>
