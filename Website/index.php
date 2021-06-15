<!DOCTYPE HTML>
<HEAD>
    <meta charset="UTF-8">
    <title>Weer Data</title>
    <link rel="stylesheet" href="styling.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</HEAD>

<!-- zodra een user de webpagina laad worden de beschikbare locaties opgehaald via de getLocations functie,
     hierdoor kan de user direct kiezen uit de lijst zonder eerst op een knop te hoeven drukken. -->
<BODY onload="getLocations()">
  <div id="content">
    <h1>Weerdata</h1>
    <br>
    <input type="submit" onclick="getId()" value="Monitoring">
    Laatste
	<!-- met deze for loop worden de opties aangemaakt voor elk uur van de dag in een selectiebox  -->
    <select id="time" class="form-select" name="time">
      <?php
        for ($i=1; $i <= 24; $i++) {
          echo "<option value='{$i}'>{$i}</option>";
        }
      ?>
    </select>
    uur van
    <select id="location" class="form-select" name="location">
    </select>.
    <input type="submit" onclick="getWeatherData()" value="Ophalen">

    <div id="tableHolder">
      <table id="dataHolder">
        <thead>
          <th>Plaats</th>
          <th>Temperatuur</th>
          <th>Weer nu</th>
		  <th>Windrichting</th>
		  <th>Windkracht</th>
		  <th>Luchtdruk</th>
		  <th>Verwachting</th>
		  <th>Zons Opkomst</th>
		  <th>Zons Ondergang</th>
		  <th>Neerslag</th>
		  <th>Ingevoerd op</th>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</BODY>

<script>
   //functie om de beschikbare locaties op te halen wanneer de user de webpagina laad.
   function getLocations(){
   $.ajax({
      type: 'GET',
      url: `http://192.168.178.92/API.php`,
      success: function(result) {
        const json  = JSON.parse(result);
        let selectLocation = document.getElementById('location');

        for(let i = 0; i < json.length; i++) {
          let plaats = json[i];
          let option = document.createElement("option");

          option.text = plaats;
          selectLocation.add(option);
        }
      }
    });
  }

  // fucntie waarmee de data uit de database opgehaald wordt via een GET request en wordt weergegeven op de webpagina.
  function getWeatherData() {
    let value_time     = document.getElementById('time').value;
    let value_location = document.getElementById('location').value;

    $.ajax({
	  //maak een GET request naar de database met de door de user opegegeven data
      type: 'GET',
      url: `http://192.168.178.92/API.php?time=${value_time}&location=${value_location}`, 
      success: function(result) {
        let json  = JSON.parse(result);
        const tBody = document.getElementById('dataHolder').getElementsByTagName('tbody')[0];
        tBody.innerHTML = ''; 
		
		// in deze for loop wordt voor elke opbject die terugegeven wordt van de database een nieuwe rij aangemaakt en wordt de data van de variabelen in cellen gestopt.
        for(let i = 0; i < json.length; i++) {
          let rowData = json[i];
          
		  // maak een nieuwe rij aan aan het einde van de tabel
          let newRow = tBody.insertRow();
		  
          // Maak een cell aan voor elke variabele in het json object
          let cellPlaats = newRow.insertCell();
          let cellTemperatuur  = newRow.insertCell();
          let cellWeer_nu  = newRow.insertCell();
		  let cellWindrichting = newRow.insertCell();
		  let cellWindkracht = newRow.insertCell();
		  let cellLuchtdruk = newRow.insertCell();
		  let cellVerwachting = newRow.insertCell();
		  let cellZons_Opkomst = newRow.insertCell();
		  let cellZons_Ondergang = newRow.insertCell();
		  let cellNeerslag = newRow.insertCell();
		  let cellIngevoerd_op = newRow.insertCell();

          // Stop de data uit het json object als text in een variabele
          let textPlaats = document.createTextNode(rowData.plaats);
          let textTemperatuur = document.createTextNode(rowData.temp);
          let textWeer_nu  = document.createTextNode(rowData.conditie);
		  let textWindrichting = document.createTextNode(rowData.windrichting);
		  let textWindkracht = document.createTextNode(rowData.windkracht);
		  let textLuchtdruk = document.createTextNode(rowData.luchtdruk);
		  let textVerwachting = document.createTextNode(rowData.verwachting);
		  let textZons_Opkomst = document.createTextNode(rowData.zonsopkomst);
		  let textZons_Ondergang = document.createTextNode(rowData.zonsondergang);
		  let textNeerslag = document.createTextNode(rowData.neerslag_kans);
		  let textIngevoerd_Op = document.createTextNode(rowData.timestamp);
		  
		  // zet de aangemaakt variabelen in de aangemaakte cellen
          cellPlaats.appendChild(textPlaats);
		  cellTemperatuur.appendChild(textTemperatuur);
		  cellWeer_nu.appendChild(textWeer_nu);
		  cellWindrichting.appendChild(textWindrichting);
		  cellWindkracht.appendChild(textWindkracht);
		  cellLuchtdruk.appendChild(textLuchtdruk);
		  cellVerwachting.appendChild(textVerwachting);
		  cellZons_Opkomst.appendChild(textZons_Opkomst);
		  cellZons_Ondergang.appendChild(textZons_Ondergang);
		  cellNeerslag.appendChild(textNeerslag);
		  cellIngevoerd_op.appendChild(textIngevoerd_Op);
        }
      }
    });
  }
</script>
