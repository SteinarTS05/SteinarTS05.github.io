<?php
$servername = "http://192.168.4.160";
$username = "phpadmin";
$password = "root";
$database = "mydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
?>
<html>
<head>
   <title>Flask introduksjon</title>
</head>
<body>
  <h1>Dette er hovedsiden</h1>
</body>

</html>
<html>
<head>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-linear-gauge.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-circular-gauge.min.js"></script>
  <script src="https://cdn.anychart.com/releases/v8/js/anychart-table.min.js"></script>
  <link href="https://cdn.anychart.com/releases/v8/css/anychart-ui.min.css" type="text/css" rel="stylesheet">
  <link href="https://cdn.anychart.com/releases/v8/fonts/css/anychart-font.min.css" type="text/css" rel="stylesheet">
  <style type="text/css">

    html,
    body,
    #container {
      width: 100%;
      height: 100%;
      margin: 0;
      padding: 0;
    }
  
</style>
</head>
<body>
  
  <div id="container"></div>
  

  <script>

    anychart.onDocumentReady(function () {
      // Create table to place gauges and information
      var layoutTable = anychart.standalones.table(4, 3);
      layoutTable
        .hAlign('center')
        .vAlign('middle')
        .useHtml(true)
        .fontSize(16)
        .cellBorder(null);

      // Set height and width for some cols and rows for layout table
      layoutTable.getCol(2).width('50%');
      layoutTable.getRow(0).height(60).fontSize(18);
      layoutTable.getRow(1).height(60);
      layoutTable.getRow(3).height(60).fontSize(14).vAlign('top');

      // Merge cells in layout table where needed
      layoutTable.getCell(0, 0).colSpan(3);
      layoutTable
        .getCell(1, 0)
        .colSpan(2)
        .fontColor('#212121')
        .fontWeight(600);

      // Put data and charts into the layout table
      layoutTable.contents([
        [
          'The Weather at school<br/><span style="color:#1976d2; font-size: 16px; font-weight: 300">' +
          anychart.format.dateTime(new Date(), 'dd MMMM yyyy') +
          '</span>',
          null,
          null
        ],
        [
         
          'Humidity <span style="color:#212121; font-size: 24px; font-weight: 600">11%</span>'
        ],
        [drawLinearGauge(21), ],
        [
          'Temperature<br/>In the classroom'

        ]
      ]);

      // Set container id and initiate drawing
      layoutTable.container('container');
      layoutTable.draw();

      // Helper function to create linear gauge
      function drawLinearGauge(value) {
        var gauge = anychart.gauges.linear();
        gauge.data([value]);
        gauge.tooltip(false);

        // Create thermometer title
        gauge
          .title()
          .enabled(true)
          .text(value + '°')
          .fontColor('#212121')
          .fontWeight(600)
          .fontSize(24)
          .orientation('bottom')
          .useHtml(true)
          .padding([10, 0, 5, 0]);

        // Create thermometer pointer
        var thermometer = gauge.thermometer(0);

        // Set thermometer settings
        thermometer.offset('1').width('3%').fill('#64b5f6').stroke('#64b5f6');

        // Set scale settings
        var scale = gauge.scale();
        scale
          .minimum(0)
          .maximum(40)
          .ticks({ interval: 10 })
          .minorTicks({ interval: 1 });
        // Set axis and axis settings
        var axis = gauge.axis();
        axis.scale(scale).minorTicks(true).width('0').offset('0%');

        // Set text formatter for axis labels
        axis.labels().useHtml(true).format('{%Value}°');

        return gauge;
      }

      // Helper function to create circular gauge
      function drawCircularGauge(direction, force) {
        var gauge = anychart.gauges.circular();
        gauge.fill('white').margin(30).stroke(null).tooltip(false);
        gauge.data([direction]);

        gauge
          .axis()
          .scale()
          .minimum(0)
          .maximum(360)
          .ticks({ interval: 45 })
          .minorTicks({ interval: 45 });
        gauge
          .axis()
          .startAngle(0)
          .fill('#CECECE')
          .width(2)
          .radius(100)
          .sweepAngle(360);
        gauge
          .axis()
          .ticks()
          .enabled(true)
          .length(20)
          .stroke('2 #CECECE')
          .position('inside')
          .type(function (path, x, y, radius) {
            path
              .moveTo(x, y - radius / 2)
              .lineTo(x, y + radius / 2)
              .close();
            return path;
          });

        gauge
          .axis()
          .labels()
          .fontSize(20)
          .position('outside')
          .format(function () {
            if (this.value === 0) return 'N';
            if (this.value === 45) return 'ne';
            if (this.value === 90) return 'E';
            if (this.value === 135) return 'se';
            if (this.value === 180) return 'S';
            if (this.value === 225) return 'sw';
            if (this.value === 270) return 'W';
            if (this.value === 315) return 'nw';
            return this.value;
          });

        gauge
          .needle()
          .fill('#64b5f6')
          .stroke('#64b5f6')
          .startRadius('45%')
          .middleRadius('5%')
          .endRadius('-85%')
          .startWidth('0%')
          .endWidth('0%')
          .middleWidth('20%');

        gauge
          .cap()
          .radius('30%')
          .enabled(true)
          .fill('#fff')
          .stroke('#CECECE');

        gauge
          .label()
          .hAlign('center')
          .anchor('center')
          .text(
            '<span style="color: #212121; font-weight: 600">' +
            direction +
            '</span>\u00B0<br>' +
            '<span style="color: #212121; font-weight: 600">' +
            force +
            '</span> m/s'
          )
          .useHtml(true);

        return gauge;
      }
    });
  
</script>
</body>
</html>