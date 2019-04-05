
<script>
    
$(document).ready(function(){  
	get_results();
    $("#amount").keyup(function(){ 
		event.preventDefault();
		get_results();
    });
    $("#reference").keyup(function(){ 
		event.preventDefault();
		get_results();
    });
	 
    $("#category").change(function(){
		event.preventDefault();
		get_results();
    });
	
	
	function get_results(){
        $.ajax({
			url: "<?php echo site_url('Transections/search');?>",
			type: 'post',
			data : jQuery('#form_search').serializeArray(),
			success: function(result){
                             $("#result_search").html(result);
                             $(".dataTable").DataTable();
        }
		});
	}
});
</script>
 
<?php // echo '<pre>'; print_r($facility_list); die;?>

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
<!--            <a href="<?php // echo base_url($this->router->fetch_class().'/add');?>" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>-->
            <a href="<?php echo base_url($this->router->fetch_class());?>" class="btn btn-app "><i class="fa fa-search"></i>Search</a>

        </div>
    </div>
    
 <br><hr>
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
                            
<!--                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Reference<span style="color: red"></span></label>
                                    <div class="col-md-9">                                            
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <?php // echo form_input('reference', set_value('reference'), 'id="reference" class="form-control" placeholder="Search by Invoice No etc"'); ?>

                                        </div>                                            
                                        <span class="help-block"><?php // echo form_error('reference');?></span>
                                    </div>
                                </div> 
                            </div>-->
                            <div class="col-md-6"> 
                                <div class="form-group">
                                       <label class="col-md-3 control-label">Transection Type</label>
                                           <div class="col-md-9">                                            
                                               <div class="input-group">
                                                   <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                                    <?php  echo form_dropdown('category',$category_list,set_value('category'),' class="form-control select2" id="category"');?>
                                               </div>                                             
                                           </div>
                                       </div> 
                                </div> 
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Amount<span style="color: red"></span></label>
                                        <div class="col-md-9">                                            
                                            <div class="input-group">
                                                <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                                <?php echo form_input('amount', set_value('amount'), 'id="amount" class="form-control" placeholder="Search by Tranection amount"'); ?>

                                            </div>                                            
                                            <span class="help-block"><?php echo form_error('amount');?></span>
                                        </div>
                                    </div> 
                            </div>
                        </div>
                    </div>
                <div class="panel-footer">
                                    <button class="btn btn-default">Clear Form</button>                                    
                                    <a id="search_btn" class="btn btn-primary pull-right"><span class="fa fa-search"></span>Search</a>
                                </div>
              </div>
    </section>
                            <?php echo form_close(); ?>               
                                
                         
                            
                        </div>
     <div class="col-md-12">
    <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Table With Full Features</h3>
            </div>
            <!-- /.box-header -->
            <div  id="result_search" class="box-body fl_scrollable_x"> </div>
            <!-- /.box-body -->
          </div>
       
     </div>
</div> 