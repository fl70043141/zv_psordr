
<script>
    
$(document).ready(function(){  
	get_results(); 
    $("#customer_id").change(function(){ 
		event.preventDefault();
		 get_results();
    }); 
	
	
	function get_results(){
        $.ajax({
			url: "<?php echo site_url('CustomerBalance/search');?>",
			type: 'post',
			data : jQuery('#form_search').serializeArray(),
			success: function(result){ 
                             $("#result_test").html(result); 
                             $(".dataTable").DataTable();
        }
		});
	}
});
</script>
 

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
    
        <div class="">
            <!--<a  href="<?php // echo base_url($this->router->fetch_class()."/add");?>" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>-->
            <a href="<?php echo base_url($this->router->fetch_class());?>" class="btn btn-app "><i class="fa fa-search"></i>Search</a>

        </div>
    </div>
    
 <br><hr>
            <?php echo form_open("CustomerBalance/print_result_report/", 'id="form_search" class="form-horizontal"')?>  
    <section  class="content"> 
        <div class="">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Search </h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
              
                
                    <div class="box-body">
                              
                        <div class="row"> 
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Customers</label>
                                    <div class="col-md-9">                                            
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                             <?php  echo form_dropdown('customer_id',$customer_list,set_value('customer_id'),' class="form-control select2" id="customer_id"');?>
                                        </div>                                             
                                    </div>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                
                        </div>
                    </div>
                <div class="panel-footer">
                    <button class="btn btn-default">Clear Form</button>                                    
                    <a id="search_btn" class="btn btn-primary pull-right"><span class="fa fa-search"></span>Search</a>
                </div>
              </div>
    </section> 
        </div>
<div class="col-md-12">
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Search Result</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="result_test">
              
            </div>
            <!-- /.box-body -->
            <button type="submit" class="btn btn-default pull-right">Print Result</button>
          </div>
     </div>
        <?php echo form_close(); ?>   
    
</div>
