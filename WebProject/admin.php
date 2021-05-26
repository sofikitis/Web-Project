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

<!--<h2>Ευφυης διαχειριση παροδιας σταθμευσης</h2>-->

<button class="btnVer" onclick="popup4()" value="οpen" id="loadButton">Φόρτωση νέου KML</button>

<div class="popup" id="popup4">
<form action="map_data_load.php" method="POST" enctype="multipart/form-data">
    Επιλέξτε νέο KML:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Υποβολή" name="submit">
</form>
</div>

<button class="btnVer" onclick="emptyDatabase()">Διαγραφή υπάρχοντος KML</button>

<button class="btnVer" onclick="popup()" value="οpen" id="simButton">Άνοιγμα φόρμας εξομοίωσης</button>

<div class="popup" id="popup">
<p id="popPar">Ώρα εξομοίωσης</p>
<button class="btnPop" onclick="subHour()">-</button>
<input id="hour" type="text" placeholder="Ώρα εξομοίωσης (ΩΩ:ΛΛ)" value="" autocomplete="off">
<button class="btnPop" onclick="addHour()">+</button>
<button class="btnVer" onclick="simulation(document.getElementById('hour').value,true,false)">Εξομοίωση</button>

</div>

<button class="btnVer" onclick="popup5()" value="οpen" id="timelapseButton">Διάστημα μεταβολής χρόνου</button>

<div class="popup" id="popup5">
<p id="popPar5">Επιλέξτε το διάστημα μεταβολής χρόνου σε λεπτά για την επιλογή ώρας στην εξομοίωση.<p>
<input id="tSpace" type="text" value="" autocomplete="off">
<button class="btnVer" onclick="changes();popup5();">Αλλαγή τιμής</button>
</div>

</div>

<div id="mapid"></div>
<div class="emulationTimeDiv">
<p id="grey" style="display:none;">0</p>
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

<script type='text/javascript' src='adminMapJs.js'></script>

</body>

