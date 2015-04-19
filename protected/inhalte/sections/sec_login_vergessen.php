<form action="index.php?section=login_vergessen" method="post" id="form_detail" class="dokument">

<h1>Login-Daten vergessen?</h1>

<fieldset>

<p>Solltest Du Deine Login-Daten vergessen haben, kannst Du Dir über dieses Formular Deinen Benutzernamen und ein neues
Passwort an Deine E-Mail-Adresse schicken lassen.</p>



<div class="control"><label for="email" class="input_heading">E-Mail Adresse</label> <input type="text" name="email"
	id="email" maxlength="50" size="50" /></div>

<div class="control"><label for="vorname"><span class="optional">* </span>Vorname</label> <input type="text"
	name="vorname" id="vorname" maxlength="30" size="30" /></div>

</fieldset>

<fieldset>

<p>Das mit <span class="optional">* </span>markierte Eingabefeld muss nur ausgefüllt werden, wenn mehrere Personen Deine
E-Mail-Adresse verweden. Andernfalls wird es ignoriert.</p>

<p class="formularbuttons">
<button type="submit" name="save" value="save">Login-Daten zuschicken!</button>
<button type="submit" name="cancel" value="cancel">Abbrechen</button>
</p>

</fieldset>

</form>
