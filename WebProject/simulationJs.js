function simulation(timeFormat,admin,grey){ 
//timeFormat --> hour:minute | admin--->true if admin calls function | grey--->true if squares must be grey	
	
	if(timeFormat.length == 0 || timeFormat.indexOf(":")== -1 ){
		var curDate = new Date(); 
		timeFormat = curDate.getHours() + ":" + curDate.getMinutes();
	}else{
		var cTimeFormat = timeFormat.split(":");
		if(!Number.isInteger(parseInt(cTimeFormat[0])) || !Number.isInteger(parseInt(cTimeFormat[1]))){
			var curDate = new Date(); 
			timeFormat = curDate.getHours() + ":" + curDate.getMinutes();
		}else if(cTimeFormat[0]<0 || cTimeFormat[0]>23 || cTimeFormat[1]>59 || cTimeFormat[1]<0){
			var curDate = new Date(); 
			timeFormat = curDate.getHours() + ":" + curDate.getMinutes();
		}
	}
	
	var res = timeFormat.split(":");
	var time = "h" + parseInt(res[0]);
	if(res[0].length == 1){
		res[0]= "0" + res[0];
	}
	if(res[1].length == 1){
		res[1]= "0" + res[1];
	}
	timeFormat = res[0] + ":" + res[1];
	
	clearMap();
	
	var demandNames = [];
	fetch('demand_curves.txt')
		.then(onSuccess, onFail);
		
	function onSuccess(response){
		response.text().then(function (text){
			splitedRow = [];
			row = text.split("\n");
			row.forEach(function(element,index){
				splitedRow = element.split(":")
				demandNames[splitedRow[0]] = "<option value='"+ splitedRow[0] +"'>" + splitedRow[0] + "</option>";
			})
		});
	}
	
	function onFail(error){
		console.log("Error" + error);
	}
	
	var req = new XMLHttpRequest();
	req.open("GET", "sql_join.php?q=" + time, true);
	req.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
			if(JSON.parse(this.responseText) === ""){
				alert("Η βάση δεδομένων δεν περιέχει στοιχεία.");
			}else{
				var data = JSON.parse(this.responseText);
			
				var polygon = [];
				var parkingSlots,takenSlots,parkedPrcnt,availableSlots,i = 0;
				var redPrcnt = 0.85
				var yellowPrcnt = 0.60
				var polygonColor = "grey";
				var dataLength = data.length;
				
				for(i = 0; i < dataLength; i++){
					point = [data[i].point_y, data[i].point_x];
					polygon.push(point);
					if( i == dataLength-1 || data[i+1].square_ID != data[i].square_ID){
						
						if(!grey){
							parkingSlots = data[i].parking_slots;
							takenSlots = data[i].population*0.20 + parkingSlots*data[i][time];
							
							if(takenSlots>parkingSlots){
								parkedPrcnt = 1;
								availableSlots = 0;
							}
							else{
								parkedPrcnt = takenSlots/parkingSlots;
								availableSlots = Math.floor(parkingSlots - takenSlots);
							}
							
							if (parkedPrcnt >= redPrcnt){	
								polygonColor = "red";	
							} else if (parkedPrcnt >= yellowPrcnt) {	
								polygonColor = "yellow";
							} else {
								polygonColor = "green";
							}
						}
						
						createSquare(polygonColor,data[i],polygon,admin,grey,demandNames,availableSlots);
						polygon = [];
					}
				}
			}
		}
	}
	req.send();
	document.getElementById("emulationTime").innerHTML = timeFormat;
	if(admin){
		document.getElementById("hour").value = timeFormat;
	}else{
		document.getElementById("userHour").value = timeFormat;
	}
	if(!grey && admin){
		document.getElementById("grey").innerHTML = 1;
	}else if(admin){
		document.getElementById("grey").innerHTML = 0;
	}
}			

function createSquare(col,polygon_data,polygon,admin,grey,demandNames,availableSlots){
	
	if(admin){
		let square = L.polygon(polygon,{color:col, opacity:0.1, fillColor:col, fillOpacity:0.3}).addTo(mymap);
		var i = 0;
		var dropDown = "<select name='demand' id='demand' value='"+polygon_data.name+"'>"+demandNames[polygon_data.name];
		var val;
		for(val in demandNames){
			if(polygon_data.name!=val){
			dropDown += demandNames[val];
			}
		}
		dropDown += "</select>";
		var popupContent = 
		'Οικοδομικό τετράγωνο: ' + '<p id="squareId" style="display:inline;">' + polygon_data.square_ID + '</p>' + 
		/*'<br/>Πληθυσμός: ' + '<input type="text" id="newPopulation" value="'+polygon_data.population+'">' +*/
		'<br/>Πληθυσμός: ' + '<p id="newPopulation" style="display:inline;">'+polygon_data.population+'</p>' +
		'<br/>Θέσεις στάθμευσης: ' + '<input type="text" id="newSlots" value="'+polygon_data.parking_slots+'">' +
		'<br/>Ζήτηση: ' + dropDown +
		'<br/><input type="submit" name="" value="Αποθήκευση" onclick="saveButton()">';				
		square.bindPopup(popupContent);
	}else{
		let square = L.polygon(polygon,{color:col, opacity:0.1, fillColor:col, fillOpacity:0.3, interactive:false}).addTo(mymap);
		var popupContent = polygon_data.centroid_x + '|' + polygon_data.centroid_y + '|' + availableSlots;
		/*'<p id="centroid_x" style="display:inline;">' + polygon_data.centroid_x + '</p>' + 
		'<p id="centroid_y" style="display:inline;">' + polygon_data.centroid_y + '</p>' + 
		'<p id="availableSlots" style="display:inline;">' + availableSlots + '</p>';*/			
		square.bindPopup(popupContent);
	}
}

function clearMap(){
	for(i in mymap._layers) {
        if(mymap._layers[i]._path != undefined || mymap._layers[i] instanceof L.Marker) {
            try {
                mymap.removeLayer(mymap._layers[i]);
            }
            catch(e) {
                console.log("problem with " + e + mymap._layers[i]);
            }
        }
    }
}
			