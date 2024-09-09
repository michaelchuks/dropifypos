@extends("layouts.adminheader")
@section("content")
@include("layouts.adminavigation")

<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['Transaction', 'Percentage'],
        ['VTU',     <?php echo $vtu; ?> ],
        ['Deposit',      <?php echo $deposit; ?>],
        ['Withdrawal',  <?php echo $withdrawal; ?>],
        ['Transfers', <?php echo $transfer; ?>],
       
      ]);

      var options = {
        title: 'Total Transactions'
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
    }

    </script>

<div class="card shadow mb-4">
    <div class="card-header py-3">
   <h6 class="m-0 font-weight-bold text-success" style="display:flex;align-items:center;justify-content:space-between;"><span>Dropifypay Pos Analytics for {{$data}}</span> 
     <a class="btn btn-sm btn-danger"  href="{{url("/redirect")}}">Back</a>
    </h6>
   </div>
       
       <div class="card-body">
           <div class="card-body">
              
            <div id="piechart" style="width: 100%; height: 100%;"></div>
          
       
   
       </div>
      </div>
   

     


@include("layouts.adminfooter")
@endsection