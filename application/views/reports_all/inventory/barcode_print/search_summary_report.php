
<script>
    
$(document).ready(function(){  
	get_results();
    $("#supp_invoice_no").keyup(function(){ 
		event.preventDefault();
		get_results();
    }); 
    $("#search_btn").click(function(){
		event.preventDefault();
		get_results();
    });
    $("#print_btn").click(function(){
        var post_data = jQuery('#form_search').serialize(); 
//        var json_data = JSON.stringify(post_data)
        window.open('<?php echo $this->router->fetch_class()."/print_report?";?>'+post_data,'ZV VINDOW',width=600,height=300)
    });
	
	
	function get_results(){
        $("#result_search").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Retrieving Data..');    
        
        var post_data = jQuery('#form_search').serializeArray(); 
        post_data.push({name:"function_name",value:'search'});
        console.log(post_data);
        $.ajax({
			url: "<?php echo site_url($this->router->directory.$this->router->fetch_class().'/fl_ajax');?>", 
			type: 'post',
			data : post_data,
			success: function(result){ 
                             $("#result_search").html(result);
//                             $(".dataTable").DataTable();
        }
		});
	}
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
                  <h3 class="box-title">Search </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
              
            <?php echo form_open("", 'id="form_search" class="form-horizontal"')?>  
   
                    <div class="box-body">
                        <div class="row"> 
                            <div class="row col-md-12 ">  
                                        
                                        <div class="col-md-3">  
                                                <div class="form-group pad">
                                                    <label for="supplier_id">Supplier</label>
                                                     <?php echo form_dropdown('supplier_id',$supplier_list,set_value('supplier_id'),' class="form-control select2" id="supplier_id"');?>
                                              
                                                </div> 
                                        </div>  
                                        <div class="col-md-3">  
                                                <div class="form-group pad">
                                                    <label for="supplier_invoice_no">Supplier Invoice No</label>
                                                    <?php  echo form_input('supplier_invoice_no',set_value('supplier_invoice_no'),' class="form-control" id="supplier_invoice_no" placeholder="Search by Invoice Number"');?>
                                                </div> 
                                        </div>  
                                        <div class="col-md-3">  
                                                <div class="form-group pad">
                                                    <label for="purchase_from_date">From</label>
                                                    <?php  echo form_input('purchase_from_date',set_value('purchase_from_date',date('m/d/Y',strtotime("-1 month"))),' class="form-control datepicker" readonly  id="purchase_from_date"');?>
                                                </div> 
                                        </div>  
                                        <div class="col-md-3">  
                                                <div class="form-group pad">
                                                    <label for="purchase_to_date">To</label>
                                                    <?php  echo form_input('purchase_to_date',set_value('purchase_to_date',date('m/d/Y')),' class="form-control datepicker" readonly  id="purchase_to_date"');?>
                                                </div> 
                                        </div>    
                                    </div>
                              
                        </div>
                    </div>
                <div class="panel-footer">
                                    <button class="btn btn-default">Clear Form</button>                                    
                                    <!--<a id="print_btn" class="btn btn-info margin-r-5 pull-right"><span class="fa fa-print"></span> Print</a>-->
                                    <a id="search_btn" class="btn btn-primary margin-r-5 pull-right"><span class="fa fa-search"></span> Search</a>
                                </div>
              </div>
    </section>
                            <?php echo form_close(); ?>               
                                
                         
                            
                        </div>
     <div class="col-md-12">
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Search Results</h3>
            </div>
            <!-- /.box-header -->
            <div  id="result_search" class="box-body"> </div>
            <!-- /.box-body -->
          </div>
       
     </div>
</div> 