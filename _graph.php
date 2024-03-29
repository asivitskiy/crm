<!-- Styles -->
<style>
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.XYChart);

// Add data
chart.data = [
  {date:new Date(2019,5,12), value1:50, value2:48, value3:48, previousDate:new Date(2019, 5, 5)},
  {date:new Date(2019,5,13), value1:53, value2:51, value3:48, previousDate:new Date(2019, 5, 6)},
  {date:new Date(2019,5,14), value1:56, value2:58, value3:48, previousDate:new Date(2019, 5, 7)},
  {date:new Date(2019,5,15), value1:52, value2:53, value3:48, previousDate:new Date(2019, 5, 8)},
  {date:new Date(2019,5,16), value1:48, value2:44, value3:48, previousDate:new Date(2019, 5, 9)},
  {date:new Date(2019,5,17), value1:47, value2:42, value3:48, previousDate:new Date(2019, 5, 10)},
  {date:new Date(2019,5,18), value1:59, value2:55, value3:48, previousDate:new Date(2019, 5, 11)},
  {date:new Date(2019,5,19), value1:47, value2:42, value3:48, previousDate:new Date(2019, 5, 12)},
  {date:new Date(2019,5,20), value1:47, value2:42, value3:48, previousDate:new Date(2019, 5, 13)},
  {date:new Date(2019,5,21), value1:47, value2:42, value3:48, previousDate:new Date(2019, 5, 14)},
  {date:new Date(2019,5,22), value1:47, value2:42, value3:48, previousDate:new Date(2019, 5, 15)},
  {date:new Date(2019,5,23), value1:47, value2:42, value3:48, previousDate:new Date(2019, 5, 16)}
  
]

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.renderer.minGridDistance = 50;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.LineSeries());
series.dataFields.valueY = "value1";
series.dataFields.dateX = "date";
series.strokeWidth = 2;
series.minBulletDistance = 10;
series.tooltipText = "[bold]{date.formatDate()}:[/] {value1}\n[bold]{previousDate.formatDate()}:[/] {value2}";
series.tooltip.pointerOrientation = "vertical";

// Create series
var series2 = chart.series.push(new am4charts.LineSeries());
series2.dataFields.valueY = "value2";
series2.dataFields.dateX = "date";
series2.strokeWidth = 1;
series2.strokeDasharray = "4,5";
series2.stroke = series.stroke;

var series2 = chart.series.push(new am4charts.LineSeries());
series2.dataFields.valueY = "value3";
series2.dataFields.dateX = "date";
series2.strokeWidth = 2;
series.minBulletDistance = 10;
series2.stroke = series.stroke;

// Add cursor
chart.cursor = new am4charts.XYCursor();
chart.cursor.xAxis = dateAxis;

}); // end am4core.ready()
</script>

<!-- HTML -->
<div id="chartdiv"></div>