<?php $Mitglied = $SiteManager->getMitglied() ?>

<h1>Profil von <?php echo $Mitglied ?></h1>

<?php echo sni_ProfilMitgliedPrivat($Mitglied->getAthletID()) ?>