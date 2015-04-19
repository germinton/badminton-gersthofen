// JavaScript-Funktionen fuer die Bilder-Galerie
// Copyright (C) 2005 Alexander Mueller
// Autor: Alexander Mueller
// Web:   http://www.EvoComp.de/
// Datei: galerie.js
// The copyright notice must stay intact for use!
// You can obtain this and other scripts at http://www.EvoComp.de/scripts/skripte.html
//
// This program is distributed in the hope that it will be useful,
// but without any warranty, expressed or implied.

// Datenstruktur, in der die einzelnen Bilddaten gespeichert werden,
// in Form eines assoziativen Arrays anlegen
var Photos = new Array();

// Photo zur Galerie hinzufuegen
// thumbnail - URL zum Thumbnail
// bild - URL zum Detailbild
// alt - Beschreibung die angezeigt werden soll, wenn man mit der Maus ueber das Bild faehrt
// beschreibung - Beschreibung des Bildes, welches als Beschriftung unter dem Detailbild angezeigt werden soll
function addPhoto (thumbnail, bild, alt, beschreibung)
{
	Photos[Photos.length] = new Object();
	// URL des Thumbnail
	Photos[Photos.length - 1]["datei"] = thumbnail;
	// URL des Bildes
	Photos[Photos.length - 1]["datei_gross"] = bild;
	// Text der angezeigt werden soll, wenn das Bild unter der angegebenen URL nicht gefunden wurde
	Photos[Photos.length - 1]["alt"] = alt;
	// Kurze Bildbeschreibung zum jeweiligen Bild
	Photos[Photos.length - 1]["beschreibung"] = beschreibung;
}

// Zaehlt Bilder mit IDs, die mit 'thumbnail' beginnen und einer ganzen Zahl
// enden und liefert die Anzahl als Rueckgabewert.
// Diese ID muessen die Image-Tags haben, die als Thumbnails verwendet werden.
function zaehle_thumbnails ()
{
	var tn = 0;

	for (i = 0; i < document.images.length; i++)
		if ((document.images[i].id).match (/^thumbnail[0-9]+$/))
			tn++;
	return tn;
}

// Thumbnails automatisch erzeugen, um Fehler zu vermeiden
function erzeuge_thumbnails ()
{
	// 'anzahl_thumbnails' Thumbnails erzeugen
	for (i = 0; i < anzahl_thumbnails; i++)
	{
		// ganz außen ein div fürs gesamtlayot
		paket = document.createElement("div");
		// Ein Thumbnail besteht aus einem LI-Tag, ...
		eintrag = document.createElement ("li");
		
		div = document.createElement("div");
		
		// einem Link ...
		link = document.createElement ("a");
		// , der per JavaScript das entsprechende Bild austauscht
		
		//id setzen
		link.id = "link"+(i+1);
		link.href = Photos[i]["datei_gross"];
		link.className ="highslide";
		//link.onclick="return hs.expand(this)";
		link.setAttribute("onclick", "return hs.expand(this)");

		// und einem IMG-Tag fuer den eigentlichen Thumbnail
		bild = document.createElement ("img");
		//bild.border = "0";
		bild.id = "thumbnail" + (i+1);
		bild.width = 100;//document.getElementById ('thumbnail' + (i + 1)).width;
		bild.height = 100;//document.getElementById ('thumbnail' + (i + 1)).height;
		bild.alt = "Highslide JS";

		// erzeugtes hierarchisch zusammenfuegen
		link.appendChild (bild);
		eintrag.appendChild(div);
		eintrag.appendChild (link);
		paket.appendChild(eintrag);

		// und unter Tag mit der ID 'thumb' ins Dokument einhaengen
		document.getElementById ("thumbs").appendChild (paket);
	}
}

// Thumbnails auf Groesse 'thumb_groesse' ausrichten
function ausrichten ()
{
	for (i = 0; i < anzahl_thumbnails; i++)
	{
		// Thumbnails vertikal ausrichten
		document.getElementById ('thumbnail' + (i + 1)).vspace = (thumb_groesse - document.getElementById ('thumbnail' + (i + 1)).height) / 2;
		// Thumbnails horizontal ausrichten
		document.getElementById ('thumbnail' + (i + 1)).hspace = (thumb_groesse - document.getElementById ('thumbnail' + (i + 1)).width) / 2;
	}
	// Thumbnail-Navigation ausrichten
	document.getElementById ('zurueck').vspace = (thumb_groesse - document.getElementById ('zurueck').height) / 2;
	document.getElementById ('pgup').vspace = (thumb_groesse - document.getElementById ('pgup').height) / 2;
	document.getElementById ('weiter').vspace = (thumb_groesse - document.getElementById ('weiter').height) / 2;
	document.getElementById ('pgdown').vspace = (thumb_groesse - document.getElementById ('pgdown').height) / 2;
}

// Thumbnails gemaess aktuellem index_erstes_bild anzeigen
function thumbnails_auffrischen ()
{
	// Bei allen Thumbnails Daten des jeweiligen IMG-Tags (b1..b3) auffrischen
	for (i = 0; i < anzahl_thumbnails; i++)
	{
		// Bild austauschen
		document.getElementById ('thumbnail' + (i + 1)).src = Photos[index_erstes_bild + i]["datei"];
		// Alt-Text austauschen
		document.getElementById ('thumbnail' + (i + 1)).alt = Photos[index_erstes_bild + i]["alt"];
		// Title-Text austauschen
		document.getElementById ('thumbnail' + (i + 1)).title = Photos[index_erstes_bild + i]["alt"];
		// Ziel-Bild austauschen
		document.getElementById ('link' + (i + 1)).href = Photos[index_erstes_bild + i]["datei_gross"];
	}

	// Navigationslinks fuer Thumbnails anzeigen
	if (index_erstes_bild > 0)
	{
		document.getElementById ('zurueck').src = pfad_zu_navbildern + "/back.gif";
		document.getElementById ('pgup').src = pfad_zu_navbildern + "/pgup.gif";
	}
	else
	{
		document.getElementById ('zurueck').src = pfad_zu_navbildern + "/first.gif";
		document.getElementById ('pgup').src = pfad_zu_navbildern + "/pgup_first.gif";
	}
	if (index_erstes_bild + anzahl_thumbnails < anzahl_bilder)
	{
		document.getElementById ('weiter').src = pfad_zu_navbildern + "/forward.gif";
		document.getElementById ('pgdown').src = pfad_zu_navbildern + "/pgdown.gif";
	}
	else
	{
		document.getElementById ('weiter').src = pfad_zu_navbildern + "/last.gif";
		document.getElementById ('pgdown').src = pfad_zu_navbildern + "/pgdown_last.gif";
	}

	// Falls das P-Tag mit der ID 'thumb_beschriftung' keine Kind-Elemente hat muss eines erzeugt werden,
	// damit die Beschriftungsdaten darin gespeichert werden koennen
	if (!document.getElementById ('thumb_beschriftung').firstChild)
		document.getElementById ('thumb_beschriftung').appendChild (document.createTextNode (""));
	// Variablen in Beschriftungsstring ersetzen
	tnstr = thumbnail_string.replace (/%index_erster%/i, (index_erstes_bild + 1));
	tnstr = tnstr.replace (/%index_letzter%/i, (index_erstes_bild + anzahl_thumbnails));
	tnstr = tnstr.replace (/%anzahl_bilder%/i, anzahl_bilder);
	// Beschriftung der Thumbnails im zugehoerigen P-Tag setzen
	document.getElementById ('thumb_beschriftung').firstChild.data = tnstr;
}

// Thumbnail-Liste ein Bild zurueck scrollen
function zurueck ()
{
	// Aenderung nur noetig, wenn der erste Thumbnail noch nicht vorne ist
	if (index_erstes_bild > 0)
	{
		// Index des ersten anzuzeigenden Thumbnails runterzaehlen
		// damit die Bilder beim Auffrischen um eine Stelle nach links verschoben werden
		index_erstes_bild--;
		// Anzeige der Thumbnails aktualisieren
		thumbnails_auffrischen ();
	}
}

// Thumbnail-Liste ein Bild vorwaerts scrollen
function weiter ()
{
	// nur wenn der letzte Thumbnail noch nicht erreicht ist
	if (!(index_erstes_bild + anzahl_thumbnails > anzahl_bilder - 1))
	{
		// Index des ersten anzuzeigenden Thumbnails hochzaehlen
		// damit die Bilder beim Auffrischen um eine Stelle nach rechts verschoben werden
		index_erstes_bild++;
		// Anzeige der Thumbnails aktualisieren
		thumbnails_auffrischen ();
	}
}

// Thumbnails um 'anzahl_thumbnails' zurueckblaettern
function pgup ()
{
	// nur um 'anzahl_thumbnails' Thumbnails zurueck, wenn noch genuegend vor aktuellem Index
	if (index_erstes_bild - anzahl_thumbnails > 0)
		index_erstes_bild = index_erstes_bild - anzahl_thumbnails;
	// ansonsten Thumbnails ab dem ersten Bild anzeigen
	else
		index_erstes_bild = 0;
	// Anzeige der Thumbnails aktualisieren
	thumbnails_auffrischen ();
}

// folgende 'anzahl_thumbnails' Thumbnails anzeigen
function pgdown ()
{
	// um 'anzahl_thumbnails' weiter, wenn noch genuegend Thumbnails in der Liste
	if (index_erstes_bild + 2 * anzahl_thumbnails < anzahl_bilder)
		index_erstes_bild = index_erstes_bild + anzahl_thumbnails;
	// oder eben die letzten 'anzahl_thumbnails' anzeigen
	else
		index_erstes_bild = anzahl_bilder - anzahl_thumbnails;
	// Anzeige der Thumbnails aktualisieren
	thumbnails_auffrischen ();
}



