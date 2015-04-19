<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<h1>Adressenliste</h1>

<form action="index.php?section=ms_adressenliste" method="post" id="form_overview">

<p>Die folgenden Feldnamen sollen im Export berücksichtig werden:</p>

<table style="width: 300px; margin: auto">
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Feldname</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($data['feldnamen_array'] as $i => $Feldname) { ?>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>">
			<td><input type="checkbox" name="<?php echo $Feldname ?>" id="<?php echo $Feldname ?>" value="1" checked="checked" />
			</td>
			<td><?php echo $Feldname ?></td>
		</tr>
		<?php
	} ?>
	</tbody>
</table>

<p>&nbsp;</p>

<div class="control" style="text-align: center">
<button type="submit" name="new" value="new">Export zusammenstellen!</button>
</div>

</form>

	<?php /*===========================================================================================================*/ ?>
	<?php } else if(VIEW_DETAIL == $data['view']) { ?>
	<?php /*===========================================================================================================*/ ?>

<form action="index.php?section=ms_adressenliste" method="post" id="form_detail" class="dokument">

<h1>Adressenliste</h1>

<fieldset>
<p>Das folgende Textfeld enthält einen aktuellen Export aus der Mitgliederdatenbank im CSV-Format. Es wird empfohlen,
den Inhalt des Textfelds mit Strg+A zu markieren, mit Strg+C zu kopieren und in eine leere Textdatei mit Strg+V
einzufügen. Anschließend kann die Textdatei in ein Programm wie z. B. Excel importiert und weiterverarbeitet werden.</p>
</fieldset>

<fieldset>
<div class="control"><label for="adressenliste">Adressenliste</label> <textarea name="adressenliste" id="adressenliste"
	cols="75" rows="12" readonly="readonly"><?php echo $data['export'] ?></textarea></div>
</fieldset>

<fieldset>

<p class="formularbuttons">
<button type="submit" name="cancel" value="cancel">Zurück</button>
</p>

</fieldset>

</form>

	<?php /*===========================================================================================================*/ ?>
	<?php } ?>
	<?php /*===========================================================================================================*/ ?>