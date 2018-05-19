/* global $, URI, window, document */
$(function() {

    // page is now ready, initialize the calendar...

    var available_calenders = {
        Punktspielkalender: {
            googleCalendarId: 'rl44va0f88i5h572ptgfm2t1n4@group.calendar.google.com', //Punktspielkalender
            //className: 'Punktspielkalender'
            color: '#D50000',
            textColor: '#ffffff'
        },
        Hallenkalender: {
            googleCalendarId: 'idj3i9sa1hdh4tkgv8odk9mcq4@group.calendar.google.com', //Hallenkalender
            //className: 'Hallenkalender',
            color: '#009688',
            textColor: '#ffffff'
        },
        Events: {
            googleCalendarId: 'germinton@googlemail.com', //Events
            //className: 'Events'
            color: '#7986CB',
            textColor: '#ffffff'
        }

    }
    var query = URI(window.location.href).search(true)
    $(document).attr('title', query.title || 'Kalender');

    var search_calendars = query.calendars.split(',');
    var calenders = [];
    for(var i = 0; i<search_calendars.length; ++i) {
        calenders.push(available_calenders[search_calendars[i]]);
    }

    var $popup = $('#popup');
    var $popup_header = $popup.find('.header');
    var $popup_title = $popup.find('.title');
    var $popup_start = $popup.find('.start');
    var $popup_end = $popup.find('.end');
    var $popup_location = $popup.find('.location');

    var onEventClick = function( calEvent, jsEvent /*,view*/) {
        jsEvent.preventDefault();
        $popup_title.html(calEvent.title);
        $popup_header.css({
            backgroundColor: calEvent.source.color,
            color: calEvent.source.textColor,
        })

        $popup_start.html('<strong>Begin:</strong> ' + calEvent.start.format('LLLL'));
        $popup_end.html('<strong>Ende:</strong> ' + calEvent.end.format('LLLL'));
        $popup_location.html('<strong>Ort:</strong> ' + (calEvent.location || 'unbekannt'));
        $popup.show(0);
    };
    
    $('#popup').on('click', function() {
        $popup.hide(0);
    });

    $('#calendar').fullCalendar({
        themeSystem: 'bootstrap4',   
        googleCalendarApiKey: 'AIzaSyCwqyykiwHS1ccTduwsD7MjgVhpJkpZu40',
        weekNumbers: true,
        header: {
            left: 'prev,next',
            center: 'title',
            right: 'today month,listMonth'
        },
        buttonText: {
            listYear: 'Jahr',
            listMonth: 'Liste'
        },
        defaultView: 'month',
        eventSources: calenders,
        eventClick: onEventClick
    })

});
