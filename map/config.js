var littleton = L.marker([39.61, -105.02]).bindPopup('This is Littleton, CO.'),
    denver    = L.marker([39.74, -104.99]).bindPopup('This is Denver, CO.'),
    aurora    = L.marker([39.73, -104.8]).bindPopup('This is Aurora, CO.'),
    golden    = L.marker([39.77, -105.23]).bindPopup('This is Golden, CO.');
var cities = L.layerGroup([littleton, denver, aurora, golden]);

var grayscale = L.tileLayer('http://{s}.tiles.wmflabs.org/bw-mapnik/{z}/{x}/{y}.png', {id: 'grayscale', attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'}),
    streets   = L.tileLayer('https://{s}.tile.thunderforest.com/cycle/{z}/{x}/{y}.png', {id: 'streets', attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'}),
    mapnik   = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {id: 'mapnik', attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'});

var map = L.map('map', {
    center: [39.73, -104.99],
    zoom: 10,
    layers: [mapnik, cities]
}).fitWorld();
L.control.fullscreen().addTo(map);
//map.locate({setView: true, maxZoom: 16});

var baseMaps = {
    "<span style='color: gray'>Grayscale</span>": grayscale,
    "Streets": streets,
	"Mapnik": mapnik
};
var overlayMaps = {
    "Cities": cities
};
L.control.layers(baseMaps, overlayMaps).addTo(map);

var marker = new Array();
marker[0] = L.marker([51.5, -0.09]).addTo(map);
marker[0].bindPopup("<b>Hello world!</b><br>I am a popup.").openPopup();

var circle = L.circle([51.508, -0.11], {
    color: 'red',
    fillColor: '#f03',
    fillOpacity: 0.5,
    radius: 500
}).addTo(map);
circle.bindPopup("I am a circle.");

var polygon = L.polygon([
    [51.509, -0.08],
    [51.503, -0.06],
    [51.51, -0.047]
]).addTo(map);
polygon.bindPopup("I am a polygon.");

var timeDelay = false;
var coords = new Array();
    var searchControl = L.Control.extend({
        options: {
            position: 'topright'
        },
        onAdd: function (map) {
            var controlDiv = L.DomUtil.create('div', 'leaflet-control-command');
            var controlInput = L.DomUtil.create('input', 'leaflet-control-input-search', controlDiv);
            var controlDropdown = L.DomUtil.create('select', 'leaflet-control-input-search-dropdown', controlDiv);
            L.DomEvent
                .addListener(controlDiv, 'click', L.DomEvent.stopPropagation)
                .addListener(controlDiv, 'click', L.DomEvent.preventDefault)
                .addListener(controlInput, 'mousedown', function (e) {
					document.getElementsByClassName('leaflet-control-input-search-dropdown')[0].innerHTML = '';
                })
                .addListener(controlDropdown, 'click', function (e) {
                    if (this.value) {
						coords = JSON.parse("[" + this.value + "]");
						lat = this.value.split(", ")[0];
						lng = this.value.split(", ")[1];
                        map.setView(coords, map.getZoom());
						popup.setLatLng(coords).setContent('<p class="popup" id="' + this.options[this.selectedIndex].innerHTML + '">' + this.options[this.selectedIndex].innerHTML + '</p>'+postform).openOn(map);
						document.getElementById("lat").value = lat;
						document.getElementById("lng").value = lng;
						document.getElementById("posttitle").value = this.options[this.selectedIndex].innerHTML;
                    }
                })
                .addListener(controlDiv, 'keyup', function () {
                    if (!timeDelay) {
                        timeDelay = setTimeout(sendGeoCodingRequest, 1000);
                    } else {
                        clearTimeout(timeDelay);
                        timeDelay = setTimeout(sendGeoCodingRequest, 1000);
                    }
                });

            return controlDiv;
        }
    });
	map.addControl(new searchControl());

var url = window.location.href;
var arr = url.split("=");
var posttext, posttitle;
var lat, lng;
var postform = "<form method='POST' action='post.php'><input type=hidden id='lat' value=0><input type=hidden id='lng' value=0><input type=text id='posttitle' value=''><br><textarea id='posttext'></textarea><br><button type='button' onclick='newPost()'>Post</button><button type='button' onclick='updatePosts()'>Reload</button></form>";
if (arr[1]) {
	arr[1] = arr[1].replace("%20", " ");
	arr[1] = arr[1].replace("&name", "");
	coords = JSON.parse("[" + arr[1] + "]");
	lat = arr[1].split(", ")[0];
	lng = arr[1].split(", ")[1];
	map.setView(coords, 16);
	var popup = L.popup()
		.setLatLng(coords)
		.setContent("<p id='"+arr[2]+"'>"+arr[2]+"</p>"+postform)
		.openOn(map);
	document.getElementById("lat").value = lat;
	document.getElementById("lng").value = lng;
} else {
	var popup = L.popup()
		.setLatLng([0, 0])
		.setContent("<p class='popup' active='true'>popup</p>"+postform)
		.openOn(map);
}
