
<script>
    
$(document).ready(function(){
    $("#print_btn_a4").click(function(){
        if($('#company_name').val() == ''){
            fl_alert('warning','Company name required!');
            return false;
        }
        if($('#item_code').val() == ''){
            fl_alert('warning','Item Code required!');
            return false;
        }
        var units = parseInt($('#units').val());
        var from = parseInt($('#start_from').val());
        if($('#units').val() == '' || $('#start_from').val() == '' || isNaN(from) || isNaN(units)){
            fl_alert('warning','Unit or Start From Input ivalid!');
            return false;
        }
        var post_data = jQuery('#form_search').serialize(); 
//        var json_data = JSON.stringify(post_data)
        window.open('<?php echo $this->router->fetch_class()."/print_report?";?>'+post_data,'ZV VINDOW',width=600,height=300)
    });
	
});
</script>
 
<?php // echo '<pre>'; print_r($search_list); die;?>

<div class="row">
<div class="col-md-12">
    <br>   
    <div class="col-md-12">

    <!--Flash Error Msg-->
        <?php  if($this->session->flashdata('error') != ''){ ?>
        <div class='alert alert-danger ' id="msg2">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <i ></i>&nbsp;<?php echo $this->session->flashdata('error'); ?>
        <script>jQuery(document).ready(function(){jQuery('#msg2').delay(1500).slideUp(1000);});</script>
        </div>
        <?php } ?>

        <?php  if($this->session->flashdata('warn') != ''){ ?>
        <div class='alert alert-success ' id="msg2">
        <a class="close" data-dismiss="alert" href="#">&times;</a>
        <i ></i>&nbsp;<?php echo $this->session->flashdata('warn'); ?>
        <script>jQuery(document).ready(function(){jQuery('#msg2').delay(1500).slideUp(1000);});</script>
        </div>
        <?php } ?>  
    
       
    </div>
     
    <section  class="content"> 
        <div class="">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Print Info </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
              
            <?php echo form_open("", 'id="form_search" class="form-horizontal"')?>  
   
                    <div class="box-body">
                        <div class="row"> 
                            <div class="row col-md-12 ">  
                                         
                                        <div class="col-md-3">  
                                                <div class="form-group pad">
                                                    <label for="company_name">Company Name</label>
                                                    <?php  echo form_input('company_name',set_value('company_name'),' class="form-control" id="company_name" placeholder="Enter Company Name / Shop Name"');?>
                                                </div> 
                                        </div>  
                                         
                                        <div class="col-md-3">  
                                                <div class="form-group pad">
                                                    <label for="city_name">City Name</label>
                                                    <?php  echo form_input('city_name',set_value('city_name'),' class="form-control" id="city_name" placeholder="Enter City Name"');?>
                                                </div> 
                                        </div> 
                                        <div class="col-md-3">  
                                                <div class="form-group pad">
                                                    <label for="item_name">Item Name</label>
                                                    <?php  echo form_input('item_name',set_value('item_name'),' class="form-control" id="item_name" placeholder="Enter Item  Name"');?>
                                                </div> 
                                        </div>   
                            </div>
                            <div class="row col-md-12 "> <hr></div>
                            <div class="row col-md-12 ">  
                                         
                                        <div class="col-md-2">  
                                                <div class="form-group pad">
                                                    <label for="item_code">Item Code</label>
                                                    <?php  echo form_input('item_code',set_value('item_code'),' class="form-control" id="item_code" placeholder="Enter Item Code"');?>
                                                </div> 
                                        </div>  
                                        <div class="col-md-2">  
                                                <div class="form-group pad">
                                                    <label for="supp_code">Supplier Code</label>
                                                    <?php  echo form_input('supp_code',set_value('supp_code'),' class="form-control"  id="supp_code"');?>
                                                </div> 
                                        </div>      
                                        <div class="col-md-2">  
                                                <div class="form-group pad">
                                                    <label for="cost_code">Cost Code</label>
                                                    <?php  echo form_input('cost_code',set_value('cost_code'),' class="form-control"  id="cost_code"');?>
                                                </div> 
                                        </div>        
                                        <div class="col-md-2">  
                                                <div class="form-group pad">
                                                    <label for="sales_price">Sales Price</label>
                                                    <?php  echo form_input('sales_price',set_value('sales_price'),' class="form-control"  id="sales_price"');?>
                                                </div> 
                                        </div>        
                                        <div class="col-md-2">  
                                                <div class="form-group pad">
                                                    <label for="other_entry">Other</label>
                                                    <?php  echo form_input('other_entry',set_value('other_entry'),' class="form-control"  id="other_entry"');?>
                                                </div> 
                                        </div>        
                                        <div class="col-md-2">  
                                                <div class="form-group pad">
                                                    <label for="cost_code">Price Fixed</label>
                                                    <input type="checkbox" id="pric_fixed" name="pric_fixed" value="1" class="checkout_form" checked>
                                                </div> 
                                        </div>  
                                        
                                    </div>
                            
                            <div class="row col-md-12 "> <hr></div>
                                <div class="col-md-12">
                                       
                                        <div class="col-md-2">  
                                                <div class="form-group pad">
                                                    <label for="start_from">Start from</label>
                                                    <?php  echo form_input('start_from',set_value('start_from', 1),' class="form-control"  id="start_from"');?>
                                                </div> 
                                        </div>      
                                        <div class="col-md-2">  
                                                <div class="form-group pad">
                                                    <label for="units">Units</label>
                                                    <?php  echo form_input('units',set_value('units',10),' class="form-control"  id="units"');?>
                                                </div> 
                                        </div> 
                                </div>
                              
                        </div>
                    </div>
                <div class="panel-footer">
                    <button type="reset" class="btn btn-default">Clear Form</button>                                    
                                    <!--<a id="print_btn" class="btn btn-info margin-r-5 pull-right"><span class="fa fa-print"></span> Print</a>-->
                                    <a id="print_btn_a4" class="btn btn-primary margin-r-5 pull-right"><span class="fa fa-search"></span> Print Sheet</a>
                                </div>
              </div>
    </section>
                            <?php echo form_close(); ?>               
                                
                         
                            
                        </div>
        
</div> 