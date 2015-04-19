<div id="loginbox">
<h2>Eingeloggt als</h2>
<form action="index.php?section=logout" method="post" title="Du bist Eingeloggt. Zum Abmelden auf 'Logout' klicken.">
<p><span class="loginHeading">Vorname</span> <br />
<span class="loginName"><?php echo $SiteManager->getMitglied()->getVorname(GET_NBSP); ?></span> <br />
<span class="loginHeading">Nachname</span> <br />
<span class="loginName"><?php echo $SiteManager->getMitglied()->getNachname(); ?></span> <br />
<button type="submit" name="logout">Logout</button>
</p>
</form>
</div>
