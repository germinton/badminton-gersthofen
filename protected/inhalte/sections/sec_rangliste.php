<h1>Rangliste</h1>

<p>&nbsp;</p>
<div class="rangliste_container">
	<div class="rangliste_date"></div>
	<table class="rangliste_table"></table>
</div>

<script>	
function ImportGSS(result){
	// build ranking array
	$('.rangliste_date').text('Stand: ' + result.feed.entry[0].content.$t);
	
	var ranking = [];
	for(i=3; i<result.feed.entry.length; i+=2){
		ranking.push(result.feed.entry[i].content.$t);
	}
	var $table = $('.rangliste_table')
	var rowBreakAfter = 1;
	var currentItemsPerRow = 0
	var content = '<tr>\n';
	for(j=0; j<ranking.length; ++j) {
		var rank = j+1;
		content += '<td class="td_rank">' + rank + '.</td><td class="td_name">' + ranking[j] + '</td>\n'
		
		currentItemsPerRow++;
		if(currentItemsPerRow === rowBreakAfter) { // break
			content += '</tr><tr>\n';
			currentItemsPerRow = 0;
			if(rowBreakAfter < 6) {
				rowBreakAfter++;
			}
		}
	}
	$table.append(content);
}

</script>
<script src="https://spreadsheets.google.com/feeds/cells/1p8h3qZSyf9nmcodlifO7Rsh7QeYXMQHIVbj94_HAf40/o9xbr88/public/values?alt=json-in-script&callback=ImportGSS"></script>

<p>
  <strong>Die Regeln:</strong>
  <ul>
	<li>Die Vereinsrangliste soll die Leistungsstärke im Einzel ermitteln und dient u.a. als Hilfe für die Planungen der Punktspielsaison.</li>
	<li>Es sind zwei Gewinnsätze bis 21 Punkte zu spielen, das gesamte Spiel muss an einem Tag ausgetragen werden.</li>
	<li>Eine Herausforderung darf einmalig abgelehnt werden, beim nächstmöglichen Termin ist das Spiel jedoch auszutragen.</li>
	<li>Die Spielergebnisse (Datum/Partie/Punkte) werden im Spielbuch eingetragen und werden online aktualisiert.</li>
	<li>Es dürfen alle vor einem stehende(n) Spieler(innen) herausgefordert werden, jedoch max. zwei Reihen vor einem platzierte Spieler(innen).</li>
	<li>Gewinnt der/die hintere platzierte Spieler(in), nimmt diese(r) den Platz des vor ihm/ihr stehenden Spielers/Spielerin ein.</li>
	<li>Verliert der/die hintere platzierte Spieler(in), verbleiben die Plätze so, wie sie vor dem Spiel bestanden haben.</li>
	<li>Spieler(innen), die sich noch nicht in der Rangliste befinden, dürfen jede(n) Spieler(in) herausfordern, außer den Plätzen 1-10 bzw. die Reihen 1-4.</li>
	<li>Verliert der/die Spieler(in), die sich noch nicht in der Rangliste befinden, nimmt dieser/diese den Platz hinter dem/der Herausgeforderten ein.</li>
  </ul>
</p>
