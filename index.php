<?php
	include("connect.php"); 	
	
	$link=Connection();
	/*working show table */
	$table=mysql_query("SELECT * FROM `<name of your table>` ORDER BY `timeStamp` DESC",$link);


{
$newest = mysql_query("SELECT * FROM `<name of your table>` ORDER BY `ID` DESC LIMIT 1",$link);
if (mysql_num_rows($newest) > 0) {
   $max_public_id = mysql_fetch_row($newest);
  

   $last = mysql_query("SELECT * FROM <name of your table> WHERE ID = '$max_public_id[0]'");
if (!$last) {
    echo 'Could not run query: ' . mysql_error();
    exit;
}
$row = mysql_fetch_row($last);
{
    $LastTime=$row[1];
    $LastTemp0=$row[3];
    $LastTemp1=$row[2];
    $LastHum=$row[4];
    mysql_free_result($newest);
  }
 }
}
//google charts
$min=-30;$max=70;
$greenfrom=15;$greenTo=30;
$yellowTo=50;
$width=200;$height=200;
// end of google charts
$refresh=10;
$page="<!DOCTYPE html><html><head><title>$LastTemp1"."°C"."</title>"."<meta http-equiv=".'"refresh" content="'."$refresh".'">'.'<meta charset="utf-8" /><script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["gauge"]});
      google.setOnLoadCallback(drawChart);
      google.setOnLoadCallback(drawhumChart);
      function drawChart() {var data = google.visualization.arrayToDataTable([
          ['."'Label', 'Value'"."],
          ['Out', $LastTemp1],['IN', $LastTemp0]"."]);
          
         var options = {
		 min: $min, max: $max,
		 greenFrom:$greenfrom, greenTo: $greenTo,
		 yellowFrom:$greenTo, yellowTo: $yellowTo,
		 redFrom: $yellowTo, redTo: $max,
          
          minorTicks: 5
        };
        
        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));
        chart.draw(data, options);
        
        setInterval(function() {
          data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
          chart.draw(data, options);
        }, 100000);
        
        setInterval(function() {
          data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
          chart.draw(data, options);
        }, 100000);
        
}".'function drawhumChart() {var hum_data = google.visualization.arrayToDataTable([
          ['."'Label', 'Value'"."],
          ['Hum', $LastHum]"."]);


         var hum_options = {
		 min: 0, max: 100,
		 greenFrom:30, greenTo: 60,
		 yellowFrom:60, yellowTo: 80,
		 redFrom: 80, redTo: 100,
          
          minorTicks: 5
        };
        
        var hum_chart = new google.visualization.Gauge(document.getElementById('hum_chart_div'));
        hum_chart.draw(hum_data, hum_options);
        
        setInterval(function() {
          data.setValue(0, 1, 40 + Math.round(60 * Math.random()));
          hum_chart.draw(hum_data, hum_options);
        }, 100000);
	}
    </script>
   </head>
<body>";
      

// Text output // $page .="<h1>Temperature</h1>" . "<h1>Outside temperature is: <content>$LastTemp1</content>°C</h1><h2>Inside temperature is: <content>$LastTemp0</content>°C</h2><h2>Humidity is $LastHum %</h2>";

$page .='<div id="chart_div" ></div>';
$page .='<div id="hum_chart_div" ></div>';
$page .="Last update: $LastTime";

$page .='<div style="overflow:auto;height:300px;width:300px;overflow: scroll;">'.'<table border="1" cellspacing="1" cellpadding="1"><tr><td>&nbsp;Timestamp&nbsp;</td><td>&nbsp;Outside temp&nbsp;</td><td>&nbsp;Inside temp&nbsp;</td><td>&nbsp;Humidity&nbsp;</td></tr>';


		  if($result!==FALSE){
		     while($row = mysql_fetch_array($table)) {
		     $page.=sprintf("<tr><td> &nbsp;%s </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td><td> &nbsp;%s&nbsp; </td></tr>", 
		           $row["timeStamp"], $row["temperature0"], $row["temperature1"], $row["Humidity"]);
		     }
		     mysql_free_result($table);
		     mysql_close();
		  }
		  $pagea.="</table></div><footer>Petr Potoček @ ".date("Y")."</footer></body></html>";
		  echo "$page";    
    ?>
