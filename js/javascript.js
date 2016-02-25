var venueControlId = 0;
var venues = [];
var fsqEnabled = false;

$(function () {
    
   $(document).on('change', 'input[name="syndication[]"]',function(){
        var latitude = $('#lat').val(), longitude = $('#long').val();
        if ($('input[name="syndication[]"]').prop("checked")) {
            if (longitude && longitude) {
                var ltlg = latitude + "," + longitude;
                var fsq = wwwroot() + "foursquare/venues";
                var options = "";
                var dropdown = '<div class="dropdown">';
                dropdown += '    <a id="venue-button" href="#" class="btn btn-info text-left col-xs-12 dropdown-toggle" type="button" data-toggle="dropdown">';
                dropdown += '        Select 4sq Venue';
                dropdown += '    <span class="caret"></span></a>';
                dropdown += '    <ul class="dropdown-menu">';
                $('input[type="submit"]').prop('disabled', true);
                $.getJSON(fsq, {ll: ltlg})
                        .done(function (data) {
                            $.each(data, function (key, val) {
                                options += '<li> <a href="#" class="venue-name"  data-key = "' + key + '">' + '<img src="' + val.icon32 + '" width="18" height="18"> ' + val.name + '</a></li>';
                            });
                            venues = data;
                            dropdown += options;
                            dropdown += '    </ul>';
                            dropdown += '</div>';
                            $('label[for=placename]').before(dropdown);
                            $('label[for=placename]').attr("for", "venuename");
                            $('#placename').before('<input name="venuename" id="venuename" class="form-control"  value="" type="text" readonly="readonly">');
                            $('#placename').replaceWith('<input name="placename" id="placename"  value="" type="hidden">');
                            $('#user_address').attr("readonly","readonly");
                        });
            }
        }
    });
});



$(document).ready(function () {
    $('.venue-name').each(function () {
        if ($(this).data('key') == venueControlId) {
		var html = $(this).html();
		html.replace('_bg','');
            $('#venue-button').html($(this).html().replace('_bg','') + ' <span class="caret"></span>');
        }
    });
});


$(document).on('click', 'a.venue-name', function () {
    venueControlId = $(this).data('key');
    src = $(this).children('img').attr('src');
    src = src.replace('_bg','');
    $('#venue-button').html($(this).html() + ' <span class="caret"></span>');
    $('#venue-button').children('img').attr('src',src);
    $('#venue-button').click();
    var venue_key = $(this).data('key');
    var venue_address = venues[venue_key].address;
    var venue_name = venues[venue_key].name;
    var lat = venues[venue_key].lat;
    var lng = venues[venue_key].long;
    $('#user_address').val(venue_address);
    $('#placename').val(venue_name);
    $('#venuename').val(venue_name);
    $('#lat').val(venues[venue_key].lat);
    $('#long').val(venues[venue_key].long);
    $('input[type="submit"]').prop('disabled', false);
    queryLocation(lat, lng);
    var newLatLng = new L.LatLng(lat, lng);
    CheckinMarker.setLatLng(newLatLng).update();
    CheckinMap.panTo(newLatLng);
});

//get address from location
function queryLocation(latitude, longitude) {
    $.ajax({
        url: '/checkin/callback',
        type: 'post',
        data: {lat: latitude.toString(), long: longitude.toString()}
    }).done(function (data) {
        $('#lat').val(latitude);
        $('#long').val(longitude);
        $('#address').val(data.display_name);
        $('#user_address').val(data.display_name);
    });
}

// get new venues after moving marker
$(document).on('mouseup mousedown touchstart touchend', '.leaflet-marker-icon', function () {
    var ll = CheckinMarker.getLatLng();
    CheckinMap.setView(ll, 15);
    var latitude = $('#lat').val(), longitude = $('#long').val();
    if (fsqEnabled && latitude && longitude) {
        var ltlg = latitude + "," + longitude;
        var fsq = wwwroot() + "foursquare/venues";
        var options = "";
        $.getJSON(fsq, {ll: ltlg})
                .done(function (data) {
                    $.each(data, function (key, val) {
                        options += '<li> <a href="#" class="venue-name"  data-key = "' + key + '">' + '<img src="' + val.icon32 + '" width="18" height="18"> ' + val.name + '</a></li>';
                    });
                    venues = data;
                    $('ul.dropdown-menu').html(options);
                    $('input[type="submit"]').prop('disabled', true);
                    $('#venue-button').html('        <i class="fa fa-foursquare"></i>Select Foursquare Venue');
                });
    }

});
