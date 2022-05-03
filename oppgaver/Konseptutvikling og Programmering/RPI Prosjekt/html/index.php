<?php
 $page = $_SERVER['PHP_SELF'];
 $sec = "10";
 header("Refresh: $sec; url=$page");
?>


<!DOCTYPE html>
<html lang="en">
<head>
<?php
    $randint = rand(0, 1000);
    echo "<link rel='stylesheet' href='styles.css?v=$randint'>";
?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPI Prosjekt</title>
</head>
<body>
<h1>Ruben sin jobb??????</h1>

<?php 
include 'dbconfig.php';

    $sql = "Select * from temperatur_måling ORDER BY idtemperatur DESC LIMIT 1";
    $resultat = $kobling->query($sql);
    

    if ($resultat->num_rows > 0) {
        // output data of each row
        $temperatur = 0;
        $fuktighet = 0;
        $lys = 0;
        $lufttrykk = 0;
        $timestamp = 0;
        
        while($row = $resultat->fetch_assoc()) {
          $temperatur = $row["temperatur"];
          $fuktighet = $row["fuktighet"];
          $lys = $row["lys"];
          $lufttrykk = $row["lufttrykk"];
          $timestamp = $row["timestamp"];
} } 
?>
<div class="grid-container">
  <div class="tilstand_na">Siste målinger fra RPI</div>
  <div class="temperatur_navn">Temperatur nå</div>
  <div class="fuktighet_navn">Fuktighet nå</div>
  <div class="lys_navn">Lys nå</div>
  <div class="lufttrykk_navn">Lufttrykk nå</div>

  <div class="temperatur"> <?php echo $temperatur; ?> ºC</div> 
  <div class="fuktighet"><?php echo $fuktighet;?> %</div>
  <div class="lys"><?php echo $lys;?> lux</div>
  <div class="lufttrykk"><?php echo $lufttrykk;?> hPa</div>

  <div class="temp_snitt_navn">Temperatursnitt siste døgnet</div>
  <div class="fuktighet_snitt_navn">Fuktighetssnitt siste døgnet </div>
  <div class="lys_snitt_navn">Lyssnitt siste døgnet</div>
  <div class="lufttrykk_snitt_navn">Lufttrykksnitt siste døgnet</div>
<?php

$sql = "select avg(temperatur), avg(fuktighet), avg(lufttrykk), avg(lys),  month(timestamp), year(timestamp), day(timestamp)  from temperatur_måling
group by month(timestamp), year(timestamp), day(timestamp);";
$resultat = $kobling->query($sql);

if ($resultat->num_rows > 0) {
  // output data of each row
  $temp_snitt = 0;
  $fuktighet_snitt = 0;
  $lys_snitt = 0;
  $lufttrykk_snitt = 0;
  
  while($row = $resultat->fetch_assoc()) {
    $temp_snitt = $row["avg(temperatur)"];
    $fuktighet_snitt = $row["avg(fuktighet)"];
    $lys_snitt = $row["avg(lys)"];
    $lufttrykk_snitt = $row["avg(lufttrykk)"];
    
    $temp_snitt = round($temp_snitt, 2);
    $fuktighet_snitt = round($fuktighet_snitt, 2);
    $lys_snitt = round($lys_snitt, 2);
    $lufttrykk_snitt = round($lufttrykk_snitt, 2);
} } 

?>
  <div class="temperatur_snitt"> <?php echo $temp_snitt; ?> ºC</div> 
  <div class="fuktighet_snitt"><?php echo $fuktighet_snitt;?> %</div>
  <div class="lys_snitt"><?php echo $lys_snitt;?> lux</div>
  <div class="lufttrykk_snitt"><?php echo $lufttrykk_snitt;?> hPa</div>

  <div class="footer">Siste oppdatering = <?php echo $timestamp?></div>
</div>

<?php $conn->close(); ?>

</body>
</html>

