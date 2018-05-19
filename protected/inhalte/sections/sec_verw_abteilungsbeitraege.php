<?php
/*===========================================================================================================*/
if (VIEW_LIST == $data['view']) {
    /*===========================================================================================================*/
?>

<h1>Abteilungsbeiträge</h1>

<form action="index.php?section=verw_abteilungsbeitraege" method="post" id="form_overview">

<div class="control">
<button type="submit" name="new" value="new">Neuen Beitrag erstellen</button>
</div>

<?php
$BeitraegeArray = $data['beitraege_array'];
    include('protected/inhalte/schnipsel/tabellen/sni_tabelle_verw_abteilungsbeitraege.php')
?>
</form>

<h2>Nicht löschbare Einträge</h2>
<p>Datensätze, bei denen das 'Löschen-Symbol' nicht angezeigt wird, sind nicht löschbar. Würde dieser Datensatz gelöscht
werden, so würden abhängige Datensätze in anderen Tabellen automatisch mit gelöscht.</p>

<?php /*===========================================================================================================*/ ?>
<?php

} elseif (VIEW_DETAIL == $data['view']) {
    ?>
<?php /*===========================================================================================================*/ ?>
<?php $Beitrag = $data['beitrag'] ?>

<form action="index.php?section=verw_abteilungsbeitraege" method="post" id="form_detail"
	class="dokument">

<h1>Beitrag <?php echo (MODE_NEW == $data['modus']) ? ('erstellen') : ('bearbeiten') ?></h1>

<fieldset>
  <div class="control hidden">
    <input type="hidden" name="beitrag_id" value="<?php echo $Beitrag->getBeitragID() ?>" />
  </div>

  <div class="control"><label for="bezeichnung">Bezeichnung</label>
    <input type="text" name="bezeichnung" id="bezeichnung" value="<?php echo $Beitrag->getBezeichnung() ?>" size="20" />
  </div>

  <div class="control"><label for="beitrag">Beitrag/Monat in €</label>
    <input type="text" name="beitrag" id="beitrag" value="<?php echo $Beitrag->getBeitrag() ?>" size="20" />
  </div>
</fieldset>
<fieldset>

<p>Mit <span class="optional">* </span>markierte Eingabefelder sind optional.</p>

<p class="formularbuttons">
<button type="submit" name="save" value="save">Speichern</button>
<button type="submit" name="cancel" value="cancel">Abbrechen</button>
</p>

</fieldset>
<?php
/*===========================================================================================================*/
}
/*===========================================================================================================*/
?>
