<div id="result1"></div>
  <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div id="top_sale_box" class="small-box bg-green">
            <div class="inner">
              <h3 id="top_sale_box_amount"><?php // echo $total_1['count'];?></h3>

              <p id="top_sale_box_label"><?php // echo $total_1['label'];?></p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-basket"></i>
            </div>
            <a href="<?php echo base_url('Sales_invoices');?>" class="small-box-footer">New Sales Invoice<i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div id="top_purch_box" class="small-box bg-aqua">
            <div class="inner">
              <h3 id="top_purch_box_amount"><?php // echo $total_2['count'];?></h3>

              <p id="top_purch_box_label"><?php // echo $total_2['label'];?></p>
            </div>
            <div class="icon">
              <i class="fa fa-users"></i>
            </div>
            <a href="<?php echo base_url('Purchasing_gemstones');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div id="top_quick_entry_box" class="small-box <?php echo $total_5['color'];?>">
              <div id="" class="inner">
              <h4 id="top_expense_box_amount"><?php echo $total_5['count'];?></h4>

              <p style="font-size:20px;" id="top_expense_box_alabel"><?php echo $total_5['label'];?></p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <a href="<?php echo base_url('reports/ledgers/Pnl_gemstones');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div id="" class="small-box bg-yellow">
            <div class="inner">
              <h4 id="top_stock_box_amount"><?php echo ($total_3['count']);?></h4>

              <p style="font-size:20px;" id="top_stock_box_label"><?php echo $total_3['label'];?></p>
            </div>
            <div class="icon">
              <i class="fa fa-list"></i>
            </div>
              <a href="<?php echo base_url('reports/Stock_costing');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
         
          <!-- BAR CHART -->
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Bar Chart</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div class="chart" id="bar-chart" style="height: 300px;"></div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- /.nav-tabs-custom -->
   

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

          <!-- DONUT CHART -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Activity Summary</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <!--<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>-->
              </div>
            </div>
            <div class="box-body chart-responsive">
              <div class="chart" id="sales-chart" style="height: 280px; position: relative;"></div>
            </div>
            <!-- /.box-body -->
          </div> 
        </section>
        <section class="col-lg-6 connectedSortable">

          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-bar-chart-o"></i>

              <h3 class="box-title">Sales</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div id="area-chart" style="height: 338px;" class="full-width-chart"></div>
            </div>
            <!-- /.box-body-->
          </div>
        </section>
          <!-- /.box -->
          </div>
          <!-- /.box -->
 
       
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content --> 
  <!-- /.content-wrapper -->
  
 
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
  
<script src="<?php echo base_url('templates/plugins/flot/jquery.flot.min.js');?>"></script> 
<!-- ./wrapper -->
<script>
    
$(function () {
     
   
  // Donut Chart
  var donut = new Morris.Donut({
    element  : 'sales-chart',
    resize   : true,
    colors   : ['#3c8dbc', '#f56954', '#00a65a'],
    data     : [
      { label: 'SALES', value: <?php echo $donut['sales']?>},
      { label: 'PURCHASE', value: <?php echo $donut['purch']?> },
      { label: 'EXPENSES', value: <?php echo $donut['expenses']?> }
    ],
    hideHover: 'auto'
  });
  
    //BAR CHART
    var bar = new Morris.Bar({
      element: 'bar-chart',
      resize: true,
      data: [
        <?php
            
            foreach ($barchart as $bc_info){
                echo "{y: '".$bc_info['month']."', a: ".$bc_info['res'].", b: ".$bc_info['inv']."},";
            }
        ?> 
      ],
      barColors: ['#3c8dbc', '#f56954'],
      xkey: 'y',
      ykeys: ['a', 'b'],
      labels: ['Purchase Invoices', 'Sales Invoices'],
      hideHover: 'auto'
    });
    
    

    /*
     * FULL WIDTH STATIC AREA CHART
     * -----------------
     */
    var areaData = [[2, 88.0], [3, 93.3], [4, 102.0], [5, 108.5], [6, 115.7], [7, 115.6],
      [8, 124.6], [9, 130.3], [10, 134.3], [11, 141.4], [12, 146.5], [13, 151.7], [14, 159.9],
      [15, 165.4], [16, 167.8], [17, 168.7], [18, 169.5], [19, 168.0]];
    $.plot("#area-chart", [areaData], {
      grid: {
        borderWidth: 0
      },
      series: {
        shadowSize: 0, // Drawing is faster without shadows
        color: "#00c0ef"
      },
      lines: {
        fill: false //Converts the line chart to area chart
      },
      yaxis: {
        show: false
      },
      xaxis: {
        show: false
      }
    });

    /* END AREA CHART */
    
    
    get_sales_info();
    get_purch_info();
//    get_quick_entry_info();
    
});


    function get_sales_info(){
        $('#top_sale_box').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...');    
         
        $.ajax({
                    url: "<?php echo site_url($this->router->directory.$this->router->fetch_class().'/fl_ajax');?>", 
                    type: 'post',
                    data : {function_name:'get_sales_info'},
                    success: function(result){ 
//                             $("#result1").html(result); 
                        var res2 = JSON.parse(result); 
                        var sale_amount = addCommas(Math.abs(parseFloat(res2['total']).toFixed(0)));
                        
                        var html_sale = '<div class="inner">'+
                                        '<h4>'+((typeof(res2['symbol_left'])=='undefined')?'':res2['symbol_left'])+' '+sale_amount+' '+((typeof(res2['symbol_right'])=='undefined')?'':res2['symbol_right'])+'</h4>'+
                                        '<p style="font-size:20px;">SALES</p>'+
                                    '</div>'+
                                    '<div class="icon">'+
                                '<i class="fa fa-shopping-basket"></i>'+
                             '</div>'+
                             '<a href="<?php echo base_url('Sales_invoices');?>" class="small-box-footer">More info<i class="fa fa-arrow-circle-right"></i></a>';
                     
                        $('#top_sale_box').html(html_sale); 
                    }
            });
    }

    function get_purch_info(){
        $('#top_purch_box').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...');    
         
        $.ajax({
                    url: "<?php echo site_url($this->router->directory.$this->router->fetch_class().'/fl_ajax');?>", 
                    type: 'post',
                    data : {function_name:'get_purch_info'},
                    success: function(result){ 
//                             $("#result1").html(result); return false;
                        var res2 = JSON.parse(result); 
                        var purch_amount = addCommas(Math.abs(parseFloat(res2['total']).toFixed(0)));
                        
                        var html_purch = '<div class="inner">'+
                                        '<h4>'+((typeof(res2['symbol_left'])=='undefined')?'':res2['symbol_left'])+' '+purch_amount+' '+((typeof(res2['symbol_right'])=='undefined')?'':res2['symbol_right'])+'</h4>'+
                                        '<p style="font-size:20px;">PURCHASING</p>'+
                                    '</div>'+
                                    '<div class="icon">'+
                                '<i class="fa fa-suitcase"></i>'+
                             '</div>'+
                             '<a href="<?php echo base_url('Purchasing_gemstones');?>" class="small-box-footer">More info<i class="fa fa-arrow-circle-right"></i></a>';
                     
                        $('#top_purch_box').html(html_purch); 
                    }
            });
    }
    
    function get_quick_entry_info(){
        $('#top_quick_entry_box').html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Loading...');    
         
        $.ajax({
                    url: "<?php echo site_url($this->router->directory.$this->router->fetch_class().'/fl_ajax');?>", 
                    type: 'post',
                    data : {function_name:'get_expenses_info'},
                    success: function(result){ 
//                        alert()
//                             $("#result1").html(result); return false;
                        var res2 = JSON.parse(result); 
                        var exp_amount = addCommas(Math.abs(parseFloat(res2['total']).toFixed(0)));
                        var html_exp = '<div class="inner">'+
                                        '<h4>'+((typeof(res2['symbol_left'])=='undefined')?'':res2['symbol_left'])+' '+exp_amount+' '+((typeof(res2['symbol_right'])=='undefined')?'':res2['symbol_right'])+'</h4>'+
                                        '<p style="font-size:20px;">EXPENSES</p>'+
                                    '</div>'+
                                    '<div class="icon">'+
                                '<i class="fa fa-money"></i>'+
                             '</div>'+
                             '<a href="<?php echo base_url('reports/Ledger_reports/expenses');?>" class="small-box-footer">More info<i class="fa fa-arrow-circle-right"></i></a>';
                     
                        $('#top_quick_entry_box').html(html_exp); 
                    }
            });
    }
function addCommas(nStr)
{
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
</script>