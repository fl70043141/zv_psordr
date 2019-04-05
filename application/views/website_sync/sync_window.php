
<script>
    
$(document).ready(function(){   
    $("#sync_btn").click(function(){ 
        if(confirm('Click ok button to start Sync.')){
//            $('#loading_display').show();                
            data_sync(); 
            $('#success_msg').show();
        }
    }); 
	
	
	function data_sync(){
            fl_alert('info',);              
        $.ajax({
                    url: "<?php echo site_url('Website_sync/fl_ajax');?>",
			type: 'post',
			data : {'function_name':'initial_item_upoad'},
                    success: function(result){
                         $("#success_msg").html(result);
                         $('#loading_display').hide(); 

                    }
		});
	}
});
</script>
 


<div class="row">
<div class="col-md-12">
                             
			<?php echo form_open("", 'id="form_search" class="form-horizontal"')?>               
                                
                                <?php  if($this->session->flashdata('error') != ''){ ?>
					<div class='alert alert-danger ' id="msg2">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					<i ></i>&nbsp;<?php echo $this->session->flashdata('error'); ?>
					<script>jQuery(document).ready(function(){jQuery('#msg2').delay(3000).slideUp(2000);});</script>
					</div>
				<?php } ?>
				
					<?php  if($this->session->flashdata('warn') != ''){ ?>
					<div class='alert alert-success ' id="msg2">
					<a class="close" data-dismiss="alert" href="#">&times;</a>
					<i ></i>&nbsp;<?php echo $this->session->flashdata('warn'); ?>
					<script>jQuery(document).ready(function(){jQuery('#msg2').delay(3000).slideUp(2000);});</script>
					</div>
				<?php } ?>  
                            <div class="panel panel-default">
                                <div class="panel-heading ui-draggable-handle">
                                    <h3 class="panel-title"><strong>Reports Sync Window</strong> </h3>
                                    
                                </div>
                                
                                <div class="panel-body">                                                                        
                                    <p>Click the Sync button for send BGL Report Data to online database;</p>
                                    <p><code><b>Note: </b>Before click the button make sure that your current Computer machine has active internet connection.</code></p>
                                    <div class="col-md-10">
                                        
                                      
<!--                                            <div class="progress">
                                                <div class="progress-bar  progress-bar-success progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                                  <span class="sr-only">40% Complete (success)</span>
                                                </div>
                                              </div>
 -->
                                        <center>
                                            <div hidden id='loading_display'><p>Please wait... &nbsp;&nbsp;&nbsp; <img class='fa-spin' src="<?php echo base_url().OTHER_IMAGES.'loading.png';?>"></p></div>
                                            <div  id="success_msg"><p class="text-success">111</p></div>
                                            
                                            <button id="sync_btn" type="button" class="btn btn-default btn-lrg ajax " title="Ajax Request">   <i class="fa  fa-refresh"></i>&nbsp; Start Data Sync. </button>
                                            <!--<button id="cancel_sync_btn" type="button" class="btn btn-default btn-lrg ajax " title="Ajax Request">   <i class="fa  fa-stop"></i>&nbsp; Stop Sync. </button>-->

                                        </center>
                                    </div>
                                   
                                </div>
                                <div class="panel-footer">
                                                                   
                                    <a href="<?php echo base_url();?>" id="search_btn" class="btn btn-primary "><span class="fa fa-backward"></span>Back</a>
                                </div>
                            </div>
                            <?php echo form_close(); ?>               
                                
                         
                     
</div>
