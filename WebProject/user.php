<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">

<link rel="stylesheet" href="leaflet.css" />
<script type="text/javascript" src="leaflet.js"></script>
<script type="text/javascript" src="buttonsJs.js"></script>
<script type="text/javascript" src="simulationJs.js"></script>

</head>

<body>

<button id="mainButton" onclick="mainPopup()" class="dropbtn" value="open">Smart Parking</button>

<div id="sidenav" class="sidenav">

<button class="btnVer" onclick="popup3()" value="οpen" id="simButton2">Άνοιγμα φόρμας εξομοίωσης</button>

<div class="popup" id="popup3">
<p id="popPar2">Ώρα εξομοίωσης</p>
<button class="btnPop" onclick="subHourUser()">-</button>
<input id="userHour" type="text" placeholder="Ώρα εξομοίωσης (ΩΩ:ΛΛ)" value="12:00" autocomplete="off">
<button class="btnPop" onclick="addHourUser()">+</button>
<button class="btnVer" onclick="simulation(document.getElementById('userHour').value,false,false)">Εξομοίωση</button>
</div>

<button class="btnVer" onclick="popup2()" value="οpen" id="searchB">Αναζήτηση προτάσεων στάθμευσης</button>

<div class="popup" id="popup2">
<p>Επιλέξτε τοποθεσία στο χάρτη.</p>
<p id="fromMap" style="display:none">0</p>
<input type="text" id="strDest" name="" placeholder="Τοποθεσία" autocomplete="off">
<input type="text" id="choosedRange" name="" placeholder="Επιθυμητή απόσταση" autocomplete="off">
<input type="text" id="arrivalTime" name="" placeholder="Ώρα άφιξης" autocomplete="off">
<input type="submit" name="" value="Αναζήτηση" onclick="findDestination()" autocomplete="off">
</div>

<p id="userTSpace" style="display:none"></p>
</div>

<div id="mapid" class="col-9 col-s-9"></div>
<div class="emulationTimeDiv">
<p id="emulationTime">2:40</p>
</div>

<div id="legend" >
  <div class="field1">
		<div class="inlineGreen"></div><div class="inline"> >40% ελεύθερες θέσεις.</div>
  </div>
  <div class="field2">
		<div class="inlineYellow"></div><div class="inline"> 15-40% ελεύθερες θέσεις.</div>
  </div>
  <div class="field3">
		<div class="inlineRed"></div><div class="inline"> &lt;15%   ελεύθερες θέσεις.</div>
  </div>
</div>
 
<script type='text/javascript' src='userMapJs.js'></script>

</body>
 
</html>