<?php

$connect = mysqli_connect("192.168.4.160", "phpmyadmin", "root", "temperatur_måling")
$query = "SELECT * FROM temperatur_måling"
$result = mysqli_query($connect, $query);
$chart_data = '';
while($row = mysqli_fetch_array($result))

{

  $chart_data .="{ tid:'".$row["timestamp"]."', temperatur:".$row["Temperatur"].", idtemperatur:".
  $row["idtemperatur"].", id:".$row["idtemperatur"]."};


?>


<html>
<head>

<title>Graph</title>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

</head>

<br /> <br />
<div class="container" style="width:900px; ">
<h2 align="center">Morris.js chart with PHP & Mysql</h2>
  <h3 align="center">Last 10 years profit, purchase and sale data</h3>
  <br /> <br />
  <div id="chart"></div>
</div>

</body>
</html>


<script>
    Morris.Bar({
    element : 'chart',
    data:[<?php echo $chart_data; ?>],
   xkey: 'year',
    ykeys:['profit', 'purchase', 'sale'],
    labels:['profit', 'purchase', 'sale'],
    hideHover:'auto',
</script>

    });