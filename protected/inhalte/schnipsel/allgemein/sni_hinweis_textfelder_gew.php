<div id="hinweis_textfelder_gew">
<h3>Textfelder (allgemein)</h3>
<p>In Texteingabefeldern sind grundsätzlich alle Zeichen erlaubt. Enthält der Eingabetext jedoch Zeichen, die in XHTML
eine spezielle Bedeutung besitzen, so findet im Hintergrund eine Konvertierung statt. Womöglich besteht das Formular
danach die Datenprüfung nicht mehr, da der Textfeld-Inhalt plötzlich zu lang ist. Dies liegt daran, dass die im
Hintergrund laufende Zeichenkonvertierung die nachfolgend aufgelisteten Zeichen in sogenannte "benannte
Zeichenreferenzen" umwandelt, welche drei bis vier Zeichen länger sind als das Ursprungszeichen für sich genommen. Im
Einzelnen betrifft das die folgenden Zeichen:</p>

<table class="schattiert">
	<tr>
		<th>Ursprungszeichen</th>
		<th>Bedeutung</th>
		<th>Konversionsergebnis</th>
	</tr>
	<tr>
		<td>&amp;</td>
		<td>kaufmännisches 'Und'</td>
		<td>&amp;amp;</td>
	</tr>
	<tr>
		<td>&quot;</td>
		<td>doppeltes Anführungszeichen</td>
		<td>&amp;quot;</td>
	</tr>
	<tr>
		<td>&lt;</td>
		<td>'kleiner als'-Zeichen</td>
		<td>&amp;lt;</td>
	</tr>
	<tr>
		<td>&gt;</td>
		<td>'größer als'-Zeichen</td>
		<td>&amp;gt;</td>
	</tr>
</table>

<p>Wird in einem Texteingabefeld ein Datum verlangt, so ist die im Format 'TT.MM.JJJJ' anzugeben.</p>

<p>Damit Telefonnummern ohne Probleme elektronisch weiterverarbeitet werden können, sollten diese immer im <a
	href="http://de.wikipedia.org/wiki/Kanonisches_Format">kanonischen Format</a> für Rufnummern angegeben werden.
Beispielsweise lautet die kanonische Schreibweise für 0821-123456 (eine gewöhnliche Telefonnummer mit Ausgburger
Vorwahl) '+49 (821) 123456'.</p>

</div>
