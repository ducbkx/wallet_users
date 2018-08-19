@extends('layouts.app')

@section('content')
<script src="http://demo.itsolutionstuff.com/demoTheme/js/Chart.bundle.js"></script>
<script type="text/javascript">
    var month = <?php echo ("" . $date) ?>;
    var data_income = <?php echo $income; ?>;
    var data_expense = <?php echo $expense; ?>;

    console.log(data_income);
    console.log(data_expense);

    var barChartData = {
        labels: month,
        datasets: [{
                label: 'Thu nhập',
                backgroundColor: "rgba(220,220,220,0.5)",
                data: data_income
            }, {
                label: 'Chi  tiêu',
                backgroundColor: "rgba(0, 128, 128, 0.7)",
                data: data_expense
            }],
    };

    window.onload = function () {
        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                elements: {
                    rectangle: {
                        borderWidth: 2,
                        borderColor: 'rgb(0, 255, 0)',
                        borderSkipped: 'bottom'
                    }
                },
                responsive: true,
                title: {
                    display: true,

                },
                scales: {
                    yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                }

            }
        });


    };
</script>


<div class="container" >
    <div class="row" style="margin-top: 60px">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading"><h4>Số tiền thu chi hàng tháng</h4></div>
                <div class="panel-body">
                    <canvas id="canvas" height="500" width="600"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection