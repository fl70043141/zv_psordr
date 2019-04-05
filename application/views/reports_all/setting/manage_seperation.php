
<!-- FastClick -->
<script>
    
$(document).ready(function(){  
    
	get_results(); 
    $("#invoice_date").keyup(function(){ 
		event.preventDefault();
		get_results();
    });
    $("#invoice_no").keyup(function(){ 
		event.preventDefault();
		get_results();
    });
	 
    $("#search_btn").click(function(){
        
		event.preventDefault();
		get_results();
    });
	
     $('#submit_seperation').click(function(){
//         alert('aa');
        var notgrouped = []; 
        $("#multiselect option").each(function(){
            notgrouped.push(this.value);
        }); 
        var grouped = []; 
        $("#multiselect_to option").each(function(){
            grouped.push(this.value);
        }); 
    
        $.ajax({
                url: "<?php echo site_url('reports/setting/'.$this->router->fetch_class().'/fl_ajax');?>",
                type: 'post',
                data : {function_name:'submit_seperation', grouped:grouped, grouped_id:$('input[name=multiselect_to_group_id]').val(), notgrouped:notgrouped},
                success: function(result){ 
//                        alert(result);
                        if(result=='1'){ 
                            fl_alert('success','Invoice Grouping updated suceesfully!');
                        }else{ 
                            fl_alert('danger','Something went wrong! Please Retry!');
                        } 
//                             $("#result_search").html(result);
                    }
//                    get_results();
                });
                get_results()
     });   
	
	function get_results(){ 
            
        $("#result_search").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Retrieving Data..'); 
        $.ajax({
			url: "<?php echo site_url('reports/setting/'.$this->router->fetch_class().'/search');?>",
			type: 'post',
			data : jQuery('#form_search').serializeArray(),
			success: function(result){ 
                             $("#result_search").html(result); 
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
                                                    <label for="invoice_no"> Invoice No</label>
                                                    <?php  echo form_input('invoice_no',set_value('invoice_no'),' class="form-control" id="invoice_no" placeholder="Search by Invoice Number"');?>
                                                </div> 
                                        </div>  
                                        <div class="col-md-3">  
                                                <div class="form-group pad">
                                                    <label for="invoice_date">Date</label>
                                                    <?php  echo form_input('invoice_date',set_value('invoice_date',date(SYS_DATE_FORMAT)),' class="form-control datepicker" readonly  id="invoice_date"');?>
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
            
            <div  id="result_search" class="box-body">
                
            </div>
            <div  id="result_search" class="box-body"> 
                <a id="submit_seperation" class="btn btn-lg btn-success pull-right">Submit</a>
            </div>
            <!-- /.box-body -->
          </div>
       
     </div>
</div> 