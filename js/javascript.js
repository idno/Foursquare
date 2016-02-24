
var venues = [];
var map = null;

$(function () {
    
    $('input[name="syndication[]"]').change(function () {
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
                console.log("fsq " + fsq + "?ll=" + ltlg);
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


$('.DDvenue-name').on('click', function (p) {
    p.preventDefault();
    var venue_key = $(this).data('key');
    var venue_address = venue[venue_key].address;
    var venue_name = venue[venue_key].name;
    $('user_address').val(venue_address);
    $('#placename').val(venue_name);
    $('#venuename').val(venue_name);
    $('input[type="submit"]').prop('disabled', false);
});

$(document).ready(function () {
    $('.venue-name').each(function () {
        if ($(this).data('key') == venue - control - id) {
            $('#venue-button').html($(this).html() + ' <span class="caret"></span>');
        }
    })
});


$(document).on('click', 'a.venue-name', function () {
    console.log("VENUE CLICKED");
    venueControlId = $(this).data('key');
    $('#venue-button').html($(this).html() + ' <span class="caret"></span>');
    $('#venue-button').click();
    var venue_key = $(this).data('key');
    var venue_address = venues[venue_key].address;
    var venue_name = venues[venue_key].name;
    var lat = venues[venue_key].lat;
    var lng = venues[venue_key].long;
    console.log("venue name: " + venue_name);
    console.log("venue addresse: " + venue_address);
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

$('#access-control-id').on('change', function () {

});
var venueControlId = 0;


function queryLocation(latitude, longitude) {
    $.ajax({
        url: '/checkin/callback',
        type: 'post',
        data: {lat: latitude.toString(), long: longitude.toString()}
    }).done(function (data) {
        console.log(data);
        $('#lat').val(latitude);
        $('#long').val(longitude);
        $('#address').val(data.display_name);
        $('#user_address').val(data.display_name);
    });
}



