/*******************************************************************************
 * Javascript für GoogleMap-Integration in Profilen von Austragungsorten
 ******************************************************************************/

function MyGMapLoad()
{
	if(GBrowserIsCompatible())
	{
		var divs = document.getElementsByTagName("div");
		for( var i = 0; i < divs.length; i++)
		{
			if(typeof divs[i] != 'undefined')
			{
				if(typeof divs[i].id != 'undefined')
				{
					var ElementID = divs[i].id;
					if(ElementID.substring(0, 23) == "gmap_austragungsort_id:")
					{
						var pieces = divs[i].firstChild.data.split(";");
						MyGMapGenerate(ElementID, pieces[0], pieces[1], 15);
					}
				}
			}
		}
	}
}

function MyGMapGenerate(id, lat, lon, zoom)
{
	var map = new GMap2(document.getElementById(id));
	var point = new GPoint(lon, lat); // ACHTUNG: (lon, lat) also vertauscht
	var marker = new GMarker(point);

	// mit Zoom (auch möglich: GSmallMapControl, GLargeMapControl,
	// GSmallZoomControl, GScaleControl)
	//map.addControl(new GSmallMapControl());
	map.addControl(new GLargeMapControl());
	// mit Typ-Auswahl (auch möglich: GMapTypeControl,
	// GHierarchicalMapTypeControl, GOverviewMapControl)
	// map.addControl(new GOverviewMapControl());
	map.addControl(new GMapTypeControl());
	// ((Breitengrad, Längengrad), Zoomstufe,
	// G_NORMAL_MAP/G_SATELLITE_MAP/G_HYBRID_MAP)
	map.setCenter(new GLatLng(lat, lon), zoom, G_HYBRID_MAP);
	/*
	 * var html = "";
	 * 
	 * html += "<div class='my_gmap_info'>"; html += " <p class='headline'>Google
	 * Map mit Marker und Infofenster</p>"; html += " <p>test</p>"; html += "</div>";
	 * 
	 * GEvent.addListener(marker, "click", function() {
	 * marker.openInfoWindowHtml(html) });
	 */
	map.addOverlay(marker);

	return(0);

}