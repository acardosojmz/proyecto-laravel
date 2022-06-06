<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf8">
        <script type="text/javascript" 
            src="https://www.gstatic.com/charts/loader.js">
        </script>
    </head>
<body onload="init()">
    <div class="graphics">
        <style>
            .pie-chart {
                width: 600px;
                height: 400px;
                margin: 0 auto;
            }
            .text-center{
                text-align: center;
            }
        </style>
        <img src="{{ asset('image/deploy.png') }}" />

        <h2 class="text-center">Generate PDF with Chart in Laravel</h2>
        
        <div id="chartDiv" class="pie-chart"> </div>
        
        <div class="text-center">
            <a href="{{ route('download') }}">Download PDF File</a>
            <h2>Elecciones ITVO</h2>
        </div>
    </div> 
    
<script type="text/javascript">
    function init() {
        google.load("visualization", "1.1", {
            packages: ["corechart"],
            callback: 'drawChart'
        });
    };
  
    function drawChart() {
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Pizza');
        data.addColumn('number', 'Populartiy');
        data.addRows([
            ['Laravel', 33],
            ['Codeigniter', 26],
            ['Symfony', 22],
            ['CakePHP', 10],
            ['Slim', 9]
        ]);
  
        var options = {
            title: 'Popularity of Types of Framework',
            sliceVisibilityThreshold: .2
        };
  
        var chart = new google.visualization.PieChart(document.getElementById('chartDiv'));
        chart.draw(data, options);
    }
</script>
   
</body>
</html>     