@extends("layouts.adminheader")
@section("content")
@include("layouts.adminavigation")

@php
$total_transaction = \App\Models\Activities::count();
$vtu_transactions = \App\Models\Activities::where("api_platform","=","vtpass")->count();
$deposit_transactions = \App\Models\Activities::where("api_platform","=","deposit")->count();
$transfer_transactions = \App\Models\Activities::where("api_platform","=","transfer")->count();
$withdrawal_transactions = \App\Models\Activities::where("api_platform","=","withdrawal")->count();

$vtu_percent = ($vtu_transactions/$total_transaction) * 100;
$deposit_percent = ($deposit_transactions/$total_transaction) * 100;
$transfer_percent = ($transfer_transactions/$total_transaction) * 100;
$withdrawal_percent = ($withdrawal_transactions/$total_transaction) * 100;
$year = date("Y");

$january_debit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","January")->where('year','=',$year)->count();
$january_credit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","January")->where('year','=',$year)->count();

$february_debit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","February")->where('year','=',$year)->count();
$february_credit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","February")->where('year','=',$year)->count();

$march_debit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","March")->where('year','=',$year)->count();
$march_credit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","March")->where('year','=',$year)->count();

$april_debit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","April")->where('year','=',$year)->count();
$april_credit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","April")->where('year','=',$year)->count();

$may_debit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","May")->where('year','=',$year)->count();
$may_credit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","May")->where('year','=',$year)->count();

$june_debit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","June")->where('year','=',$year)->count();
$june_credit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","June")->where('year','=',$year)->count();

$july_debit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","July")->where('year','=',$year)->count();
$july_credit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","July")->where('year','=',$year)->count();

$august_debit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","August")->where('year','=',$year)->count();
$august_credit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","August")->where('year','=',$year)->count();

$september_debit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","September")->where('year','=',$year)->count();
$september_credit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","September")->where('year','=',$year)->count();

$october_debit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","October")->where('year','=',$year)->count();
$october_credit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","October")->where('year','=',$year)->count();

$november_debit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","November")->where('year','=',$year)->count();
$november_credit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","November")->where('year','=',$year)->count();

$december_debit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","December")->where('year','=',$year)->count();
$december_credit = \App\Models\Activities::where("transaction_type","=","debit")->where("month","=","December")->where('year','=',$year)->count();










@endphp


<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);
    google.charts.setOnLoadCallback(drawChart2);

    function drawChart() {

      var data = google.visualization.arrayToDataTable([
        ['Transaction', 'Percentage'],
        ['VTU',     <?php echo $vtu_percent; ?> ],
        ['Deposit',      <?php echo $deposit_percent; ?>],
        ['Withdrawal',  <?php echo $withdrawal_percent; ?>],
        ['Transfers', <?php echo $transfer_percent; ?>],
       
      ]);

      var options = {
        title: 'Total Transactions'
      };

      var chart = new google.visualization.PieChart(document.getElementById('piechart'));

      chart.draw(data, options);
    }



    function drawChart2() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Debit', 'Credit'],
          ['Jan',  <?php echo $january_debit  ; ?>,     <?php echo $january_credit; ?> ],
          ['Feb',  <?php echo $february_debit  ; ?>,     <?php echo $february_credit; ?> ],
          ['Mar',  <?php echo $march_debit  ; ?>,     <?php echo $march_credit; ?> ],
          ['Apr',  <?php echo $april_debit  ; ?>,     <?php echo $april_credit; ?> ],
          ['May',  <?php echo $may_debit  ; ?>,     <?php echo $may_credit; ?> ],
          ['Jun',  <?php echo $june_debit  ; ?>,     <?php echo $june_credit; ?> ],
          ['Jul',  <?php echo $july_debit  ; ?>,     <?php echo $july_credit; ?> ],
          ['Aug',  <?php echo $august_debit  ; ?>,     <?php echo $august_credit; ?> ],
          ['Sep',  <?php echo $september_debit  ; ?>,     <?php echo $september_credit; ?> ],
          ['Oct',  <?php echo $october_debit  ; ?>,     <?php echo $october_credit; ?> ],
          ['Nov',  <?php echo $november_debit  ; ?>,     <?php echo $november_credit; ?> ],
          ['Dec',  <?php echo $december_debit  ; ?>,     <?php echo $december_credit; ?> ],
         
        ]);

        var options = {
          title: 'Year Performance',
          hAxis: {title: 'Year',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
  </script>











<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Records</a>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Total Users</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_users}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div>
                           Total Transactions</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$total_transactions}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-book fa-2x text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>


     <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                           User's Transactions</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$users_transactions}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                           Admin's Total Earnings</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{$admin_earnings}}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

  

</div>           

     

<div class="row">

    <!-- Area Chart -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Activities Overview</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                        aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <div id="chart_div" style="width: 100%; height: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

   

    <!-- Pie Chart -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div
                class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Transaction sources</h6>
               
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-pie pt-4 pb-2">
                    <div id="piechart" style="width: 100%; height: 100%;"></div>
                </div>
                <div class="mt-4 text-center small">
                    
                   
                </div>
            </div>
        </div>
    </div>
</div>




@include('layouts.adminfooter')
@endsection