//setting the map
let mymap = L.map('mapid', {
    renderer: L.svg(),
	zoomControl:false 
});
mymap.createPane('labels');
mymap.getPane('labels').style.zIndex = 650;
mymap.createPane('circle');
mymap.getPane('circle').style.zIndex = 550;
mymap.getPane('labels').style.pointerEvents = 'none';
var positron = L.tileLayer('http://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png', {
        attribution: '©OpenStreetMap, ©CartoDB'
}).addTo(mymap);

var positronLabels = L.tileLayer('http://{s}.basemaps.cartocdn.com/light_only_labels/{z}/{x}/{y}.png', {
        attribution: '©OpenStreetMap, ©CartoDB',
        pane: 'labels'
}).addTo(mymap);
mymap.setView([40.643012616714856, 22.93400457702626], 16);

fetch('timelapse.txt')
		.then(onSuccess, onFail);
		
	function onSuccess(response){
		response.text().then(function (text){
			document.getElementById("userTSpace").innerHTML = text;
		});
	}
	function onFail(error){
		console.log("Error" + error);
}

//η τωρινη ωρα για την εξομοιωση στην αρχη της σελιδας
var curDate = new Date(); 
var hour = curDate.getHours();
var minute = curDate.getMinutes();
document.getElementById("userHour").value = hour + ":" + minute; 
var time = "h" + hour;

simulation(document.getElementById('userHour').value,false,false);

function onMapClick(e) {
	
	var formDisplay  = document.getElementById("popup2").style.display;
	var range = parseInt(document.getElementById("choosedRange").value);
	if(formDisplay == "block"){
		coordinates = e.latlng.toString();
		var n = coordinates.length;
		coordinates = coordinates.slice(7, n-1);
		var partsOfCoordinates = coordinates.split(',');
		
		x = Number( partsOfCoordinates[0] );
		y = Number( partsOfCoordinates[1] );

		for(i in mymap._layers) {
			if(mymap._layers[i] instanceof L.Marker || mymap._layers[i] instanceof L.Circle) {
				try {
					mymap.removeLayer(mymap._layers[i]);
				}
				catch(e) {
					console.log("problem with " + e + mymap._layers[i]);
				}
			}
		}
		var myIcon = L.icon({
			iconUrl: 'images/marker-icon-red.png',
			shadowUrl: 'images/marker-shadow.png',
			iconSize: null,
			iconAnchor: [12, 41],
			popupAnchor: [0, -34],
			shadowSize: null,
			shadowAnchor: [12, 41]
		});
		var marker = L.marker([x,y],{interactive:false ,icon:myIcon}).addTo(mymap);
		var strDest = x + " " + y;
		document.getElementById("strDest").value = strDest;
	}
	
}
mymap.on('click', onMapClick);
	
function findDestination(){
	var coordsstr = document.getElementById("strDest").value;
	var coords = document.getElementById("strDest").value.split(" ");
	if(coordsstr.length == 0){
		alert("Εισάγετε τοποθεσία.");
		return -1;
	}
	if(coordsstr.indexOf(" ") == -1 || isNaN(Number(coords[0])) || isNaN(Number(coords[1]))){
		alert("Οι συντεταγμένες δεν είναι στην σωστή μορφή.");
		return -1;
	}
	var arvTimeFormat = document.getElementById('arrivalTime').value;
	if(arvTimeFormat.length == 0 || arvTimeFormat.indexOf(":")== -1 ){
		var curDate = new Date(); 
		arvTimeFormat = curDate.getHours() + ":" + curDate.getMinutes();
		document.getElementById('arrivalTime').value = arvTimeFormat;
		document.getElementById('userHour').value = arvTimeFormat;
	}else{
		cTimeFormat = arvTimeFormat.split(":");
		if(!Number.isInteger(parseInt(cTimeFormat[0])) || !Number.isInteger(parseInt(cTimeFormat[1]))){
			var curDate = new Date(); 
			arvTimeFormat = curDate.getHours() + ":" + curDate.getMinutes();
			document.getElementById('arrivalTime').value = arvTimeFormat;
			document.getElementById('userHour').value = arvTimeFormat;	
		}else if(cTimeFormat[0]<0 || cTimeFormat[0]>23 || cTimeFormat[1]>59 || cTimeFormat[1]<0){
			var curDate = new Date(); 
			arvTimeFormat = curDate.getHours() + ":" + curDate.getMinutes();
			document.getElementById('arrivalTime').value = arvTimeFormat;
			document.getElementById('userHour').value = arvTimeFormat;
		}
	}	
	
	var tf = arvTimeFormat.split(":");
	var x = coords[0];
	var y = coords[1];
	var range = document.getElementById("choosedRange").value;
	if(isNaN(Number(range))){
		alert("Η ακτίνα αναζήτησης δεν είναι στην σωστή μορφή");
		return -1;
	}
	if(range.length == 0){
		range = 100;
		document.getElementById("choosedRange").value = 100;
	}
	var arrivalHour = "h" + tf[0];
	var params = [x,y,range,arrivalHour];
	//console.log(params);
	
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var destination = JSON.parse(this.responseText);
			if(destination == -1){
				alert("Δεν βρέθηκαν διαθέσιμες θέσεις στάθμευσης");
			}else{
				destination.forEach(function(element,index){
					var ll1 = L.latLng([destination[index][0], destination[index][1]]);
					var ll2 = L.latLng([x, y]);
					//var polyline = L.polyline([ll1,ll2],{color:'blue'}).addTo(mymap);
					var distance = ll1.distanceTo(ll2);
					distance = Math.floor(distance*10);
					distance /= 10;
					//polyline.bindPopup(distance.toString() + "m").openPopup();
					var dest= L.marker([destination[index][0], destination[index][1]],{title:'Destination'}).addTo(mymap);
					dest.bindPopup(distance.toString() + "m",{autoClose:false}).openPopup();
				});
				var myIcon = L.icon({
					iconUrl: 'images/marker-icon-red.png',
					shadowUrl: 'images/marker-shadow.png',
					iconSize: null,
					iconAnchor: [12, 41],
					popupAnchor: [0, -34],
					shadowSize: null,
					shadowAnchor: [12, 41]
				});
				
				var choice = L.marker([x, y],{icon:myIcon}).addTo(mymap);
				
				//choice.bindPopup("Destination",{autoClose:false}).openPopup();
			}
		}
	};
	urlJsonArray = encodeURIComponent(JSON.stringify(params));
	urlJsonFunctionName = encodeURIComponent(JSON.stringify("destination_function"));
	url_string = "js_calls.php?a=" + urlJsonArray + "&f=" + urlJsonFunctionName;
	myUrl = encodeURIComponent(url_string);
	xmlhttp.open("GET",url_string, true);
	xmlhttp.send();
	
	if(!(document.getElementById('arrivalTime').value.length == 0)){
		simulation(document.getElementById('arrivalTime').value,false,false);
	}else{
		simulation(document.getElementById('userHour').value,false,false);
	}
	
	var circleD = L.circle([x, y], {
		color: 'white',
		fillColor: 'white',
		fillOpacity: 0.1,
		opacity: 0.7,
		pane:'circle',
		radius:range
	}).addTo(mymap);
}


