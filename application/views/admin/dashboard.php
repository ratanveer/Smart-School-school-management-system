<div class="content-wrapper" style="min-height: 946px;">
    <section class="content">
        <div class="row">
            <?php
            ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a href="<?php echo site_url('studentfee') ?>">
                        <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?php echo $this->lang->line('monthly_fees_collection'); ?></span>
                            <span class="info-box-number"><?php echo $month_collection; ?></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a href="<?php echo site_url('admin/expense') ?>">
                        <span class="info-box-icon bg-red"><i class="fa fa-credit-card"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?php echo $this->lang->line('monthly_expenses'); ?></span>
                            <span class="info-box-number"><?php echo $month_expense; ?></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a href="<?php echo site_url('student/search') ?>">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-user"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?php echo $this->lang->line('student'); ?></span>
                            <span class="info-box-number"><?php echo $total_students; ?></span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <a href="<?php echo site_url('admin/teacher') ?>">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-user-secret"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text"><?php echo $this->lang->line('teachers'); ?></span>
                            <span class="info-box-number"><?php echo $total_teachers; ?></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="row">       
            <div class="col-md-12">               
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Fees Collection & Expenses For <?php echo date('F')." ".date('Y'); ?></h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="barChart" style="height:250px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-md-12">              
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $this->lang->line('fees_collection_&_expenses_for_session'); ?> <?php echo $this->setting_model->getCurrentSessionName(); ?></h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="lineChart" style="height:250px"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
<script>
    $(function () {
        var areaChartOptions = {
            showScale: true,
            scaleShowGridLines: false,
            scaleGridLineColor: "rgba(0,0,0,.05)",
            scaleGridLineWidth: 1,
            scaleShowHorizontalLines: true,
            scaleShowVerticalLines: true,
            bezierCurve: true,
            bezierCurveTension: 0.3,
            pointDot: false,
            pointDotRadius: 4,
            pointDotStrokeWidth: 1,
            pointHitDetectionRadius: 20,
            datasetStroke: true,
            datasetStrokeWidth: 2,
            datasetFill: true,

            maintainAspectRatio: true,
            responsive: true
        };
        var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
        var lineChart = new Chart(lineChartCanvas);
        var lineChartOptions = areaChartOptions;
        lineChartOptions.datasetFill = false;
        var yearly_collection_array = <?php echo json_encode($yearly_collection) ?>;
        var yearly_expense_array = <?php echo json_encode($yearly_expense) ?>;
        var total_month = <?php echo json_encode($total_month) ?>;
        var areaChartData_expense_Income = {
            labels: total_month,
            datasets: [
                {
                    label: "Expense",
                    fillColor: "rgba(215, 44, 44, 0.7)",
                    strokeColor: "rgba(215, 44, 44, 0.7)",
                    pointColor: "rgba(233, 30, 99, 0.9)",
                    pointStrokeColor: "#c1c7d1",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: yearly_expense_array
                },
                {
                    label: "Collection",
                    fillColor: "rgba(102, 170, 24, 0.6)",
                    strokeColor: "rgba(102, 170, 24, 0.6)",
                    pointColor: "rgba(102, 170, 24, 0.9)",
                    pointStrokeColor: "rgba(102, 170, 24, 0.6)",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(60,141,188,1)",
                    data: yearly_collection_array
                }
            ]
        };
        lineChart.Line(areaChartData_expense_Income, lineChartOptions);
        var barChartCanvas = $("#barChart").get(0).getContext("2d");
        var barChart = new Chart(barChartCanvas);
        var current_month_days = <?php echo json_encode($current_month_days) ?>;
        var days_collection = <?php echo json_encode($days_collection) ?>;
        var days_expense = <?php echo json_encode($days_expense) ?>;

        var areaChartData_classAttendence = {
            labels: current_month_days,
            datasets: [
                {
                    label: "Electronics",
                    fillColor: "rgba(102, 170, 24, 0.6)",
                    strokeColor: "rgba(102, 170, 24, 0.6)",
                    pointColor: "rgba(102, 170, 24, 0.6)",
                    pointStrokeColor: "#c1c7d1",
                    pointHighlightFill: "#fff",
                    pointHighlightStroke: "rgba(220,220,220,1)",
                    data: days_collection
                },
                {
                    label: "Digital Goods",
                    fillColor: "rgba(233, 30, 99, 0.9)",
                    strokeColor: "rgba(233, 30, 99, 0.9)",
                    pointColor: "rgba(233, 30, 99, 0.9)",
                    pointStrokeColor: "rgba(233, 30, 99, 0.9)",
                    pointHighlightFill: "rgba(233, 30, 99, 0.9)",
                    pointHighlightStroke: "rgba(60,141,188,1)",
                    data: days_expense
                }
            ]
        };
        var barChartData = areaChartData_classAttendence;
        barChartData.datasets[1].fillColor = "rgba(233, 30, 99, 0.9)";
        barChartData.datasets[1].strokeColor = "rgba(233, 30, 99, 0.9)";
        barChartData.datasets[1].pointColor = "rgba(233, 30, 99, 0.9)";
        var barChartOptions = {
            scaleBeginAtZero: true,
            scaleShowGridLines: true,
            scaleGridLineColor: "rgba(0,0,0,.05)",
            scaleGridLineWidth: 1,
            scaleShowHorizontalLines: true,
            scaleShowVerticalLines: true,
            barShowStroke: true,
            barStrokeWidth: 2,
            barValueSpacing: 5,
            barDatasetSpacing: 1,

            responsive: true,
            maintainAspectRatio: true
        };

        barChartOptions.datasetFill = false;
        barChart.Bar(barChartData, barChartOptions);
    });
</script>
<script src="<?php echo base_url(); ?>backend/plugins/fastclick/fastclick.js"></script>
<script src="<?php echo base_url(); ?>backend/dist/js/app.min.js"></script>
<script src="<?php echo base_url(); ?>backend/plugins/chartjs/Chart.min.js"></script>
<script src="<?php echo base_url(); ?>backend/dist/js/pages/dashboard2.js"></script>