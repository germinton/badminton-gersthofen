<h1>Kontakt</h1>

<p>Allgemeine Anfragen zur Abteilung, Ausschreibungen zu Wettkämpfen, etc. bitte an die folgende E-Mail-Adresse richten:</p>
<p class="dokument textbox"><a href="mailto:info@badminton-gersthofen.de"><em>info@badminton-gersthofen.de</em></a></p>
<p>Die E-Mail geht automatisch an einen ausgewählten Kreis innerhalb der Abteilung. Du erreichtst damit maximale
Aufmerksamkeit bzw. Deine Frage wird zuverlässig beantwortet.</p>

<h2 id="abteilungsleiter">Abteilungsleiter</h2>
<?php
$AthletIdAbteilunsleiter = CAufgabenzuordnung::getAthletIDArray(S_ABTEILUNGSLEITER);
$AthletAbteilunsleiter = reset($AthletIdAbteilunsleiter);
echo sni_ProfilMitgliedVisitenkarte($AthletAbteilunsleiter)
?>

<h2 id="cheftrainer">Cheftrainer</h2>
<?php
$AthletIdCheftrainer = CAufgabenzuordnung::getAthletIDArray(S_CHEFTRAINER);
$AthletCheftrainer = reset($AthletIdCheftrainer);
echo sni_ProfilMitgliedVisitenkarte($AthletCheftrainer)
?>

<h2 id="webmaster">Webmaster</h2>
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
