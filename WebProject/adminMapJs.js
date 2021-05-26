//setting the map
let mymap = L.map('mapid', {
    renderer: L.svg(),
	zoomControl:false 
});
mymap.createPane('labels');
mymap.getPane('labels').style.zIndex = 650;
mymap.getPane('labels').style.pointerEvents = 'none';
var positron = L.tileLayer('http://{s}.basemaps.cartocdn.com/light_nolabels/{z}/{x}/{y}.png', {
        attribution: '©OpenStreetMap, ©CartoDB'
}).addTo(mymap);

var positronLabels = L.tileLayer('http://{s}.basemaps.cartocdn.com/light_only_labels/{z}/{x}/{y}.png', {
        attribution: '©OpenStreetMap, ©CartoDB',
        pane: 'labels'
}).addTo(mymap);
mymap.setView([40.643012616714856, 22.93400457702626], 16);
/*
let osmUrl='https://tile.openstreetmap.org/{z}/{x}/{y}.png';
let osmAttrib='Map data © <a href="https://openstreetmap.org">OpenStreetMap</a> contributors';
let osm = new L.TileLayer(osmUrl, {attribution: osmAttrib});
mymap.addLayer(osm);
mymap.setView([40.643012616714856, 22.93400457702626], 16);*/

fetch('timelapse.txt')
		.then(onSuccess, onFail);
		
	function onSuccess(response){
		response.text().then(function (text){
			document.getElementById("tSpace").value = text;
		});
	}
	function onFail(error){
		console.log("Error" + error);
}

simulation(document.getElementById('hour').value,true,true);

var curDate = new Date(); 
var timeFormat = curDate.getHours() + ":" + curDate.getMinutes();
document.getElementById('hour').value = timeFormat;

function saveButton() {	

	//var population = document.getElementById("newPopulation").value;
	var population = document.getElementById("newPopulation").innerHTML;
	var slots =  document.getElementById("newSlots").value;
	var demand =  document.getElementById("demand").value;
	var polygonId = document.getElementById("squareId").innerHTML;
	var errorMsg = "";
	var errorFlag = 0;
	
	if(population<0){
		errorMsg += "Ο πλυθησμός δεν μπορεί να είναι αρνητικός αριθμός.";
		errorFlag = 1;
	}
	if(slots<0){
		errorMsg += "Οι θέσεις στάθμευσης δεν μπορεί να είναι αρνητικός αριθμός.";
		errorFlag = 1;
	}
	if(demand == ""){
		errorMsg += "Η ζήτηση πρέπει να έχει τιμή.";
		errorFlag = 1;
	}
	if(errorFlag == 1){
		alert(errorMsg);
		return -1;
	}
	var string = "UPDATE city_square SET population = "+population+", parking_slots = "+slots+", type = '"+demand+"' WHERE square_ID = "+polygonId;
	var req = new XMLHttpRequest();
	req.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var reqResult = JSON.parse(this.responseText);
			if(reqResult != "Success"){
				alert(reqResult);
			}else{
				mymap.closePopup();
				//alert("Επιτυχής αποθήκευση");
			}
		}
	};
	urlJsonArray = encodeURIComponent(JSON.stringify(string));
	urlJsonFunctionName = encodeURIComponent(JSON.stringify("sql_update"));
	url_string = "js_calls.php?a=" + urlJsonArray + "&f=" + urlJsonFunctionName;
	req.open("GET",url_string, true);
	req.send();	
	
	if(document.getElementById("grey").innerHTML == "1"){
		simulation(document.getElementById('hour').value,true,false);
	}else{
		simulation(document.getElementById('hour').value,true,true);
	}
	
	return 1;
	
}

function emptyDatabase() {
	
	if (confirm('Θέλετε σίγουρα να διαγράψετε το υπαρχον ΚΜL από την βάση.')) {
		
		var reqDelete = new XMLHttpRequest();
		reqDelete.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if(JSON.parse(this.responseText) == "Success"){
					alert("Τα περιεχόμενα του KML διαγράφηκαν με επιτυχία από την βάση δεδομένων.");
				}else{
					alert("Η διαγραφή δεν ολοκληρώθηκε με επιτυχία");
				}
			}
		};
		urlJsonArray = encodeURIComponent(JSON.stringify("not used parameter"));
		urlJsonFunctionName = encodeURIComponent(JSON.stringify("empty_DB"));
		url_string = "js_calls.php?a=" + urlJsonArray + "&f=" + urlJsonFunctionName;
		reqDelete.open("GET",url_string, true); //--------
		reqDelete.send();
		location.reload();	
	}
	
		
}

