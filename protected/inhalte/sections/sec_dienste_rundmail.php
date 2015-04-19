<?php /*===========================================================================================================*/ ?>
<?php if(VIEW_LIST == $data['view']) { ?>
<?php /*===========================================================================================================*/ ?>

<h1>Rundmail</h1>

<div class="error papier">
<p>ACHTUNG BAUSTELLE!</p>
<p>Die Funktionalitäten sind noch nicht fretig!</p>
</div>

<p>Wähle unten zunächst den gewünschen Empfängerkreis aus. Anschließend kann entweder die Empfängerliste kopiert und in
den eingenen Mail-Client übernommen werden oder gleich über das Webformular eine Rundmail verschickt werden.</p>

<p>Hinweis: Die Empfängerliste enthält ausschließlich Mitglieder die nicht ausgeblendet sind und eine E-Mail-Adresse
hinterlegt haben.</p>

<form action="index.php?section=dienste_rundmail" method="post" id="form_overview">

<fieldset><legend>Optionen</legend>

<p>Globale Optionen für die Empfängerliste:</p>

<div class="control"><label for="nflag">Newsletter-Flag</label> <select name="nflag" id="nflag">
	<option value="0" selected="selected">beachten</option>
	<option value="1">ignorieren</option>
	<option value="2">invertieren</option>
</select></div>

<div class="control"><label for="format">Format</label> <select name="format" id="format">
	<option value="0" selected="selected">max@mustermann.de</option>
	<option value="1">Max&nbsp;Mustermann&nbsp;(max@mustermann.de)</option>
	<option value="2">Max&nbsp;Mustermann&nbsp;&lt;max@mustermann.de&gt;</option>
</select></div>

<div class="control"><label for="delim">Trennzeichen</label> <select name="delim" id="delim">
	<option value="0" selected="selected">Komma</option>
	<option value="1">Semikolon</option>
	<option value="2">Newline</option>
</select></div>

</fieldset>


<fieldset><legend>Filterung</legend>

<p>Jede Tabelle entspricht einem Filter. Ein Filter findet erst dann Anwendung, wenn mindestens ein Kriterium ausgewählt
wurde:</p>

<div style="display: inline-block; width: 200px">
<table>
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Anrede</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($GLOBALS['Enum']['Anrede'] as $i => $Anrede) { ?>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>">
			<td><input type="checkbox" name="geschlecht:<?php echo $Anrede ?>" id="geschlecht:<?php echo $Anrede ?>" value="1" /></td>
			<td><?php echo C2S_Anrede($Anrede) ?></td>
		</tr>
		<?php
	} ?>
	</tbody>
</table>
</div>

<div style="display: inline-block; width: 300px">
<table>
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Altersklasse</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($GLOBALS['Enum']['AKlaGruppe'] as $i => $AKlaGruppe) { ?>
		<tr class="<?php echo (($i%2)?('even'):('odd')) ?>">
			<td><input type="checkbox" name="aklagruppe:<?php echo $AKlaGruppe ?>" id="aklagruppe:<?php echo $AKlaGruppe ?>"
				value="1" /></td>
			<td><?php echo C2S_AKlaGruppe($AKlaGruppe) ?></td>
		</tr>
		<?php
	} ?>
	</tbody>
</table>
</div>

<div style="display: inline-block; width: 300px">
<table>
	<thead>
		<tr>
			<th>&nbsp;</th>
			<th>Verteilerliste</th>
		</tr>
	</thead>
	<tbody>
		<tr class="odd">
			<td><input type="checkbox" name="verteilerliste:1" id="verteilerliste:1" value="1" /></td>
			<td>TSV Gersthofen 1</td>
		</tr>
		<tr class="odd">
			<td><input type="checkbox" name="verteilerliste:2" id="verteilerliste:2" value="1" /></td>
			<td>TSV Gersthofen 2</td>
		</tr>
		<tr class="odd">
			<td><input type="checkbox" name="verteilerliste:3" id="verteilerliste:3" value="1" /></td>
			<td>TSV Gersthofen 3</td>
		</tr>
	</tbody>
</table>
</div>


</fieldset>

<p>&nbsp;</p>

<div class="control">
<button type="submit" name="new" value="new">Rundmail verfassen!</button>
</div>

</form>

	<?php /*===========================================================================================================*/ ?>
	<?php } else if(VIEW_DETAIL == $data['view']) { ?>
	<?php /*===========================================================================================================*/ ?>

<form action="index.php?section=dienste_rundmail" method="post" id="form_detail" class="dokument">

<h1>Rundmail</h1>



<fieldset>
<div class="control"><label for="empfaenger">Empfänger</label> <textarea name="empfaenger" id="empfaenger" cols="75"
	rows="5" readonly="readonly"><?php echo $data['empfaenger'] ?></textarea></div>

<br />
<div class="control"><label for="text">Text</label> <textarea name="text" id="text" cols="75" rows="20"></textarea></div>
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