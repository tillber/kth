<html>
<head>
<meta charset="ISO-8859-1">
<title>FuelCalculator</title>

<!-- CSS File -->
<link href="index.css" rel="stylesheet" type="text/css"/>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>
    <h1>FuelCalculator</h1>
    <p>Compare fuel prices between petrol stations</p>
	<form class="converter" id="calcForm">
	<fieldset id="compareStations">
	  <legend>Compare stations</legend>
		<div class="formDiv">
		<label for="station1">Company 1</label>
		<select id="station1" name="ps1"></select>
		</div>
		<i>compared to</i>
		<div class="formDiv">
		<label for="station2">Company 2</label>
			<select id="station2" name="ps2"></select>
		</div>
		<div class="formDiv">
			<label for="distance">Distance (km)</label>
			<input type="number" id="distance" name="distance" step="1" min="0" placeholder="Distance"/>
		</div>
		<div class="formDiv">
			<label for="distance">Consumption (l/10km)</label>
			<input type="number" name="consumption" step="0.1" min="0" placeholder="Fuel consumption"/>
		</div>
		<input class="submit" type="submit" id="calculate" value="Calculate">
		</fieldset>
	</form>
	
	<div id="results"></div>
	
    <button id="getall">Get all stations</button>
    
    <span class="bycompany">
	    <select id="bycompany"></select>
	    <button id="getbycompany">Get station</button>
	</span>
    
    <table id="table">
    	<thead>
	    	<tr>
	    		<th>Company</th>
	    		<th>Unleaded 95 (kr/l)</th>
	    		<th>Unleaded 98 (kr/l)</th>
	    		<th>Diesel (kr/l)</th>
	    		<th>Ethanol (kr/l)</th>
	    	</tr>
    	</thead>
    	<tbody></tbody>
    </table>
    
    <form id="addStationForm">
	 <fieldset id="addStation">
	  <legend>Add station</legend>
	  <div class="formDiv">
	  	<label for="addCompanyName">Company</label>
	  	<input id="addCompanyName" name="addCompanyName" type="text" placeholder="Company name"/>
	  </div>
	  <div class="formDiv margin-left">
	  	<label for="addUnleaded95">Unleaded 95 (kr/l)</label>
	  	<input id="addUnleaded95" name="addUnleaded95" type="number" placeholder="Unleaded 95"/>
	  </div>
	  <div class="formDiv">
	  	<label for="addUnleaded98">Unleaded 98 (kr/l)</label>
	  	<input id="addUnleaded98" name="addUnleaded98" type="number" placeholder="Unleaded 98"/>
	  </div>
	  <div class="formDiv">
	  	<label for="addDiesel">Diesel (kr/l)</label>
	  	<input id="addDiesel" name="addDiesel" type="number" placeholder="Diesel"/>
	  </div>
	  <div class="formDiv">
	  	<label for="addEthanol">Ethanol (kr/l)</label>
	  	<input id="addEthanol" name="addEthanol" type="number" placeholder="Ethanol"/>
	  </div>
	  <input class="submit" type="submit" id="add" value="Add company">
	 </fieldset>
	</form>
	
	<p id="successfulAdd"></p>
    
    <script type="text/javascript" src="index.js"></script>
</body>
</html>
