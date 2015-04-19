<h1>Kontakt</h1>

<p>Allgemeine Anfragen zur Sparte, Ausschreibungen zu Wettkämpfen, etc. bitte an die folgende E-Mail-Adresse richten:</p>
<p class="dokument textbox"><a href="mailto:info@badminton-gersthofen.de"><em>info@badminton-gersthofen.de</em></a></p>
<p>Die E-Mail geht automatisch an einen ausgewählten Kreis innerhalb der Sparte. Du erreichtst damit maximale
Aufmerksamkeit bzw. Deine Frage wird zuverlässig beantwortet.</p>

<h2 id="cheftrainer">Cheftrainer</h2>
<p>Möchtest Du mehr über das Training und/oder die Sparte erfahren? Dann kannst Du den oben beschriebenen Weg auch
abkürzen und Dich direkt an unser Cheftrainer wenden:</p>
<?php
$AthletIdCheftrainer = CAufgabenzuordnung::getAthletIDArray(S_CHEFTRAINER);
$AthletCheftrainer = reset($AthletIdCheftrainer);
echo sni_ProfilMitgliedVisitenkarte($AthletCheftrainer)
?>

<h2 id="webmaster">Webmaster</h2>
<p>Ist Dir an der Homepage etwas aufgefallen (Lob, Kritik), oder hast Du Probleme mit dem Mitglieder-Login, dann wende
Dich gerne direkt an den Webmaster:</p>
<?php
$AthletIdWebmaster = CAufgabenzuordnung::getAthletIDArray(S_WEBMASTER);
$AthletWebmaster = reset($AthletIdWebmaster);
echo sni_ProfilMitgliedVisitenkarte($AthletWebmaster)
?>

<h2>Hauptverein / Geschäftsstelle</h2>
<p>Für Angelegenheiten bezüglich Deiner Mitgliedschaft im <a href="http://www.tsv-gersthofen.de/">Hauptverein</a>, wende
Dich bitte direkt an die Geschäftsstelle des TSV Gersthofen:</p>
<p class="dokument textbox">Turn- und Sportverein 1909 Gersthofen e. V.<br />
Sportallee 12<br />
86368 Gersthofen<br />
Telefon: +49 (0) 8 21-49 48 49<br />
Telefax: +49 (0) 8 21-49 20 67<br />
E-Mail: <a href="mailto:info@tsv-gersthofen.de">info@tsv-gersthofen.de</a></p>
