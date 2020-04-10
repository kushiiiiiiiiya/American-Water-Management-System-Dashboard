<script>
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawTrendlines);

function drawTrendlines() {

      var data = new google.visualization.DataTable();
      data.addColumn('timeofday', 'Time of Day');
      data.addColumn('number', 'Customers');
      data.addColumn('number', 'Bottles');

      data.addRows([
        <?php 
          foreach ($hourlyBreakdown as $item) {
            echo $item;
          }
        ?>
      ]);

      var options = {
        backgroundColor: { fill:'transparent'},
        title: null,
        height:400,
        hAxis: {
          title: 'Time of Day',
          format: 'h:mm a',
          viewWindow: {
            min: [7, 30, 0],
            max: [17, 30, 0]
          }
        },
        vAxis: {
          title: 'Delivery Count'
        }
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      chart.draw(data, options);
    }
</script>