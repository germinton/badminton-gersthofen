<form action="index.php" method="get" id="form_filter_sort" class="dokument">

<div class="control"><input type="hidden" name="section" value="dienste_aktivitaeten" /></div>

<div class="control line"><input type="checkbox" name="fltr1" id="fltr1" value="1"
<?php echo (($data['fltr1'])?(' checked="checked"'):('')) ?> class="right" /> <label for="fltr1">Alle einblenden</label></div>

<div class="control line"><label for="fltr2" class="left">Altersklasse</label> <select name="fltr2" id="fltr2">
<?php
echo '<option value="0"'.((0 == $data['fltr2'])?' selected="selected"':'').'></option>'."\n";
foreach($GLOBALS['Enum']['AKlaGruppe'] as $AKlaGruppe)
{
	echo '<option value="'.$AKlaGruppe.'"';
	echo (($AKlaGruppe == $data['fltr2'])?' selected="selected"':'').'>'.C2S_AKlaGruppe($AKlaGruppe).'</option>'."\n";
}
echo '<option value="4"'.((4 == $data['fltr2'])?' selected="selected"':'').'>Unbekannt</option>'."\n";
?>
</select></div>

<div class="control line"><label for="sort" class="left">Sortierung</label> <select name="sort" id="sort">
<?php
echo '<option value="0"';
echo ((0 == $data['sort'])?(' selected="selected"'):('')).'>Last Login</option>'."\n";
echo '<option value="1"';
echo ((1 == $data['sort'])?(' selected="selected"'):('')).'>Last Update</option>'."\n";
echo '<option value="2"';
echo ((2 == $data['sort'])?(' selected="selected"'):('')).'>Name</option>'."\n";
?>
</select></div>

<div class="control">
<button type="submit" class="right">Anwenden</button>
</div>

</form>

<h1>Aktivitätenprotokoll</h1>

<form action="index.php?section=dienste_aktivitaeten<?php echo (($s = $data['fs_string'])?($s):('')) ?>" method="post"
	id="form_overview">

<p>&nbsp;</p>
<p>&nbsp;</p>

<table>

	<colgroup span="4" />
	
	
	<thead>
		<tr>
			<th>Anrede</th>
			<th>Name</th>
			<th>Last Login</th>
			<th>Last Update</th>
			<th>A.Kla.Gruppe<sup>1</sup></th>
		</tr>
	</thead>
	<tbody>
	<?php
	if(count($data['mitglied_array']))
	{
		foreach ($data['mitglied_array'] as $i => $Mitglied)
		{
			?>
		<tr class="<?php echo (($Mitglied->getAusblenden())?('special'):((($i%2)?('even'):('odd')))) ?>">
			<td><?php echo $Mitglied->getAnrede(GET_C2SC) ?></td>
			<td style="text-align: left"><?php echo '&nbsp;'.$Mitglied->getNachnameVorname() ?></td>
			<td><?php echo $Mitglied->getLastLogin(array(GET_NBSP, GET_DTDE)) ?></td>
			<td><?php echo $Mitglied->getLastUpdate(array(GET_NBSP, GET_DTDE)) ?></td>
			<td><?php echo $Mitglied->getAKlaGruppe(array(GET_NBSP, GET_C2SC)) ?></td>
		</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>

<div class="foot"><sup>1</sup> Stichtag zum <?php echo $data['stichtag'] ?></div>

</form>
