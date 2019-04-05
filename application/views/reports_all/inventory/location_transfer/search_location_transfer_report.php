<?php
    $fiscyear_info = get_single_row_helper(GL_FISCAL_YEARS,'id = '.$this->session->userdata(SYSTEM_CODE)['active_fiscal_year_id']);
//     echo '<pre>'; print_r($fiscyear_info); die;
?>
<script>
    
$(document).ready(function(){  
//	get_results();
    $("#supp_invoice_no").keyup(function(){ 
		event.preventDefault();
//		get_results();
    }); 
    $("#search_btn").click(function(){
		event.preventDefault();
//		get_results();
    });
    $("#print_btn").click(function(){
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
                  <h3 class="box-title">Search </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
              
            <?php echo form_open("", 'id="form_search" class="form-horizontal"')?>  
   
                    <div class="box-body">
                        <div class="row"> 
                            <div class="row col-md-12 center-block">  
                                        
                                        <div class="col-md-3">  
                                                <div class="form-group pad">
                                                    <label for="from_location_id">From Location</label>
                                                     <?php echo form_dropdown('from_location_id',$location_list,set_value('from_location_id'),' class="form-control select2" id="from_location_id"');?>
                                              
                                                </div> 
                                        </div>  
                                        <div class="col-md-3">  
                                                <div class="form-group pad">
                                                    <label for="to_location_id">From Location</label>
                                                     <?php echo form_dropdown('to_location_id',$location_list,set_value('to_location_id'),' class="form-control select2" id="to_location_id"');?>
                                              
                                                </div> 
                                        </div>  
                                        <div class="col-md-3">  
                                                <div class="form-group pad">
                                                    <label for="transfer_from_date">From</label>
                                                    <?php  echo form_input('transfer_from_date',set_value('transfer_from_date',date('m/d/Y',$fiscyear_info['begin'])),' class="form-control datepicker" readonly  id="transfer_from_date"');?>
                                                </div> 
                                        </div>  
                                        <div class="col-md-3">  
                                                <div class="form-group pad">
                                                    <label for="transfer_to_date">To</label>
                                                    <?php  echo form_input('transfer_to_date',set_value('transfer_to_date',date('m/d/Y',$fiscyear_info['end'])),' class="form-control datepicker" readonly  id="transfer_to_date"');?>
                                                </div> 
                                        </div> 
                                
                                    </div>
                              
                        </div>
                    </div>
                <div class="panel-footer">
                                    <button class="btn btn-default">Clear Form</button>                                    
                                    <a id="print_btn" class="btn btn-info margin-r-5 pull-right"><span class="fa fa-print"></span> Print</a>
                                    <!--<a id="search_btn" class="btn btn-primary margin-r-5 pull-right"><span class="fa fa-search"></span> Search</a>-->
                                </div>
              </div>
    </section>
                            <?php echo form_close(); ?>               
                                
                         
                            
                        </div> 
</div> 