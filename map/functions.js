function onMapClick(e) {
	if (e.latlng) {
		popup
		    .setLatLng(e.latlng)
		    .setContent("You clicked the map at " + e.latlng.toString())
		    .openOn(map);
	}
}
map.on('click', onMapClick);

function onLocationFound(e) {
    var radius = e.accuracy / 2;

    L.marker(e.latlng).addTo(map)
        .bindPopup("You are within " + radius + " meters from this point").openPopup();

    L.circle(e.latlng, radius).addTo(map);
}
map.on('locationfound', onLocationFound);

function onLocationError(et) {
    alert(e.message);
}
map.on('locationerror', onLocationError);

function sendGeoCodingRequest() {
      var url = 'https://geocode-maps.yandex.ru/1.x/?format=json&geocode=';
      var element = document.getElementsByClassName('leaflet-control-input-search')[0];
      var query = element.value;
	  var xhttp = new XMLHttpRequest();
	  xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200 && JSON.parse(this.responseText).response.GeoObjectCollection.featureMember.length) {
                    var items = JSON.parse(this.responseText).response.GeoObjectCollection.featureMember;
                    var html = '';
                    var counter = 0;
                    for (var item in items) {
                        var latLong = items[item].GeoObject.Point.pos.split(' ');
                        html += '<option class="geopost-search-item" value="' +  + latLong[1] + ', ' + latLong[0] + '" data-lat="' + latLong[0] + '" data-long="' + latLong[1] + '">' +
                                    items[item].GeoObject.description + ' ' + items[item].GeoObject.name +
                                '</option>';

                        if (counter > 10) {
                            break;
                        }
                        counter++;
                    }
                    html += '';

                    document.getElementsByClassName('leaflet-control-input-search-dropdown')[0].innerHTML = html;
		 			//document.getElementById("demo").innerHTML = this.responseText;
		}
	  };
	  xhttp.open("GET", url + encodeURIComponent(query), true);
	  xhttp.send();
}

/*
posts fetched onto map, use code from ls plugin.
*/

function updatePosts() {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("content").innerHTML = this.responseText;
			for (i=0; i<document.getElementsByClassName("post_lat").length; i++) {
//what if they are not on page? pagination by time\user\coords and load dynamically in shown map range.
				lat = document.getElementsByClassName("post_lat")[i].innerHTML;
				lng = document.getElementsByClassName("post_lng")[i].innerHTML;
				posttitle = document.getElementsByClassName("posttitle")[i].innerHTML;
				posttext = document.getElementsByClassName("posttext")[i].innerHTML;
//cluster as different issues can be in same place. discussions grouped separately on each popup.
				marker[i] = L.marker([lat, lng]).addTo(map);
				marker[i].bindPopup("<b>"+posttitle+"</b><br>"+posttext).openPopup();
			}
		}
	};
	xhttp.open("GET", "posts.php", true);
	xhttp.send();
}

function newPost() {
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			document.getElementById("newpost").innerHTML = this.responseText;
			updatePosts();
		}
	};
	posttext = document.getElementById("posttext").value;
	posttitle = document.getElementById("posttitle").value;
	lat = document.getElementById("lat").value;
	lng = document.getElementById("lng").value;
	xhttp.open("POST", "post.php", true);
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send("user_id=0&title="+posttitle+"&text=" + posttext + "&date=&tags=&lat=" + lat + "&lng=" + lng);
}
