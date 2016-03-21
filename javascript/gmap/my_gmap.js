/*******************************************************************************
 * Javascript für GoogleMap-Integration in Profilen von Austragungsorten
 ******************************************************************************/

function MyGMapLoad()
{
    $(document).ready(function() {
     $('.profil_austragungsort_gmaps').each(function() {
        var $el = $(this);
        MyGMapGenerate(this, $el.data('lat'), $el.data('lng'), 15);
     })
    })
    /*
    var divs = document.getElementsByTagName("div");
    for( var i = 0; i < divs.length; i++)
    {
        if(typeof divs[i] !== 'undefined')
        {
            if(typeof divs[i].id !== 'undefined')
            {
                var ElementID = divs[i].id;
                if(ElementID.substring(0, 23) === "gmap_austragungsort_id:")
                {
                    var pieces = divs[i].firstChild.data.split(";");
                    MyGMapGenerate(ElementID, pieces[0], pieces[1], 15);
                }
            }
        }
    }
    */
}

function MyGMapGenerate(element, lat, lng, zoom)
{   
    var latLng = {
        lat: lat, 
        lng: lng
    };
    map = new google.maps.Map(element, {
        center: latLng,
        zoom: zoom,
        mapTypeId: google.maps.MapTypeId.HYBRID
    });
    var marker = new google.maps.Marker({
        position: latLng,
        map: map
    });
}