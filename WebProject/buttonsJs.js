function subHour() {
	var sub = document.getElementById("hour").value;
	var res = sub.split(":");
	var time = parseInt(res[0])* 60 + parseInt(res[1]);
	//var timeSlot = document.getElementById("tslot").value;
	time = time - time%parseInt(document.getElementById("tSpace").value);
	time = time - parseInt(document.getElementById("tSpace").value);
	if (time < 0) {
		time = 24*60 + time;
	}
	if (time%60 == 0) {
		document.getElementById("hour").value = parseInt(time / 60) + ":" + time%60 + "0";
	} else if (time%60 < 10) {
		document.getElementById("hour").value = parseInt(time / 60) + ":" + "0" + time%60;		
	} else {
		document.getElementById("hour").value = parseInt(time / 60) + ":" + time%60;
	}
	
}

function subHourUser() {
	var sub = document.getElementById("userHour").value;
	var res = sub.split(":");
	var time = parseInt(res[0])* 60+ parseInt(res[1]);
	//var timeSlot = document.getElementById("tslot").value;
	time = time - time%parseInt(document.getElementById("userTSpace").innerHTML);
	time = time - parseInt(document.getElementById("userTSpace").innerHTML);
	if (time < 0) {
		time = 24*60 + time;
	}
	if (time%60 == 0) {
		document.getElementById("userHour").value = parseInt(time / 60) + ":" + time%60 + "0";
	} else if (time%60 < 10) {
		document.getElementById("userHour").value = parseInt(time / 60) + ":" + "0" + time%60;		
	} else {
		document.getElementById("userHour").value = parseInt(time / 60) + ":" + time%60;
	}
	
}

function addHour() {
	var add = document.getElementById("hour").value;
	var res = add.split(":");
	var time = parseInt(res[0])* 60+ parseInt(res[1]);
	//var timeSlot = document.getElementById("tslot").value;
	time = time - time%parseInt(document.getElementById("tSpace").value);
	time = time + parseInt(document.getElementById("tSpace").value);
	if (time >= 24*60) {
		time = time - 24*60;
	}
	if (time%60 == 0) {
		document.getElementById("hour").value = parseInt(time / 60) + ":" + time%60 + "0";
	} else if (time%60 < 10) {
		document.getElementById("hour").value = parseInt(time / 60) + ":" + "0" + time%60;		
	}else {
		document.getElementById("hour").value = parseInt(time / 60) + ":" + time%60;
	}
	
}

function addHourUser() {
	var add = document.getElementById("userHour").value;
	var res = add.split(":");
	var time = parseInt(res[0])* 60+ parseInt(res[1]);
	//var timeSlot = document.getElementById("tslot").value;
	time = time - time%parseInt(document.getElementById("userTSpace").innerHTML);
	time = time + parseInt(document.getElementById("userTSpace").innerHTML);
	if (time >= 24*60) {
		time = time - 24*60;
	}
	if (time%60 == 0) {
		document.getElementById("userHour").value = parseInt(time / 60) + ":" + time%60 + "0";
	} else if (time%60 < 10) {
		document.getElementById("userHour").value = parseInt(time / 60) + ":" + "0" + time%60;		
	}else {
		document.getElementById("userHour").value = parseInt(time / 60) + ":" + time%60;
	}
	
}

function popup() {
	
	var elem = document.getElementById("simButton");
	
    if (elem.value == "open") {
		elem.value = "close";
		elem.innerHTML = "Κλείσιμο φόρμας εξομοίωσης";
		document.getElementById("popup").style.display = "block";
		if(document.getElementById("popup4").style.display == "block"){
			popup4();
		}
		if(document.getElementById("popup5").style.display == "block"){
			popup5();
		}
	} else if (elem.value == "close") {
		elem.value = "open";
		elem.innerHTML = "Άνοιγμα φόρμας εξομοίωσης";
		document.getElementById("popup").style.display = "none";
	} else {
		elem.value = "close";
		elem.innerHTML = "Κλείσιμο φόρμας εξομοίωσης";
		document.getElementById("popup").style.display = "block";
		if(document.getElementById("popup4").style.display == "block"){
			popup4();
		}
		if(document.getElementById("popup5").style.display == "block"){
			popup5();
		}
	}
    
	
}


function popup2() {
	
	var elem = document.getElementById("searchB");
	
    if (elem.value == "open") {
		elem.value = "close";
		elem.innerHTML = "Κλείσιμο";
		document.getElementById("popup2").style.display = "block";
		if(document.getElementById("popup3").style.display == "block"){
			popup3();
		}
	} else if (elem.value == "close") {
		elem.value = "open";
		elem.innerHTML = "Αναζήτηση προτάσεων στάθμευσης";
		document.getElementById("popup2").style.display = "none";
	} else {
		elem.value = "close";
		elem.innerHTML = "Κλείσιμο";
		document.getElementById("popup2").style.display = "block";
		if(document.getElementById("popup3").style.display == "block"){
			popup3();
		}
	}
    
	
}


function popup3() {
	
	var elem = document.getElementById("simButton2");
	
    if (elem.value == "open") {
		elem.value = "close";
		elem.innerHTML = "Κλείσιμο φόρμας εξομοίωσης";
		document.getElementById("popup3").style.display = "block";
		if(document.getElementById("popup2").style.display == "block"){
			popup2();
		}
	} else if (elem.value == "close") {
		elem.value = "open";
		elem.innerHTML = "Άνοιγμα φόρμας εξομοίωσης";
		document.getElementById("popup3").style.display = "none";
	} else {
		elem.value = "close";
		elem.innerHTML = "Κλείσιμο φόρμας εξομοίωσης";
		document.getElementById("popup3").style.display = "block";
		if(document.getElementById("popup2").style.display == "block"){
			popup2();
		}
	}
    
	
}

function popup4() {
	
	var elem = document.getElementById("loadButton");
	
    if (elem.value == "open") {
		elem.value = "close";
		elem.innerHTML = "Κλείσιμο";
		document.getElementById("popup4").style.display = "block";
		if(document.getElementById("popup").style.display == "block"){
			popup();
		}
		if(document.getElementById("popup5").style.display == "block"){
			popup5();
		}
	} else if (elem.value == "close") {
		elem.value = "open";
		elem.innerHTML = "Φόρτωση νέου KML";
		document.getElementById("popup4").style.display = "none";
	} else {
		elem.value = "close";
		elem.innerHTML = "Κλείσιμο";
		document.getElementById("popup4").style.display = "block";
		if(document.getElementById("popup").style.display == "block"){
			popup();
		}
		if(document.getElementById("popup5").style.display == "block"){
			popup5();
		}
	}
	
}

function popup5(){
	
	var elem = document.getElementById("timelapseButton");
	
    if (elem.value == "open") {
		elem.value = "close";
		elem.innerHTML = "Κλείσιμο";
		document.getElementById("popup5").style.display = "block";
		if(document.getElementById("popup").style.display == "block"){
			popup();
		}
		if(document.getElementById("popup4").style.display == "block"){
			popup4();
		}
	} else if (elem.value == "close") {
		elem.value = "open";
		elem.innerHTML = "Διάστημα μεταβολής χρόνου";
		document.getElementById("popup5").style.display = "none";
	} else {
		elem.value = "close";
		elem.innerHTML = "Κλείσιμο";
		document.getElementById("popup5").style.display = "block";
		if(document.getElementById("popup").style.display == "block"){
			popup();
		}
		if(document.getElementById("popup4").style.display == "block"){
			popup4();
		}
	}
	
}

function mainPopup() {

	var elem = document.getElementById("mainButton");
	
    if (elem.value == "open") {
		elem.value = "close";
		document.getElementById("sidenav").style.display = "block";
	} else if (elem.value == "close") {
		elem.value = "open";
		document.getElementById("sidenav").style.display = "none";
	} else {
		elem.value = "close";
		document.getElementById("sidenav").style.display = "block";
	}
    
	
}

function remove() {
	/*let points = [[38.246598,21.736236],
	[38.24723,21.737019],
	[38.246733,21.737652],
	[38.246101, 21.736836]];
	
	let polygon = L.polygon(points);
	
	mymap.removeLayer(polygon);*/

    for(i in mymap._layers) {
        if(mymap._layers[i]._path != undefined) {
            try {
                mymap.removeLayer(mymap._layers[i]);
            }
            catch(e) {
                console.log("problem with " + e + mymap._layers[i]);
            }
        }
    }
}

function changes(){
	var timelapse = document.getElementById("tSpace").value;	
	//console.log(timelapse);
	if(timelapse<=0 || isNaN(timelapse))timelapse=5;
	var data = new FormData();
	data.append("data" ,  timelapse);
	var xhr = new XMLHttpRequest();
	xhr.open('post','timelapse.php', true );
	xhr.send(data);
	document.getElementById("tSpace").value = timelapse;
}

