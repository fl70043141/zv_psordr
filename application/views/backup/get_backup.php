
<script>
//    
//$(document).ready(function(){   
//    $("#sync_btn").click(function(){ 
//        if(confirm('Click ok button to start Sync.')){
//            $('#loading_display').show();                
//            data_sync(); 
//            $('#success_msg').show();
//        }
//    }); 
//	
//	
//	function data_sync(){
//            
//        $.ajax({
//                    url: "<?php echo site_url('reportSync/sync_local_remote');?>",
////			type: 'post',
////			data : jQuery('#form_search').serializeArray(),
//                    success: function(result){
//                         $("#success_msg").html(result);
//                         $('#loading_display').hide(); 
//
//                    }
//		});
//	}
//});
</script>
 


<div class="row">
<div class="col-md-12">
                             
			<?php echo form_open("", 'id="form_search" class="form-horizontal"')?>               
                                
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
                            <div class="panel panel-default">
                                <div class="panel-heading ui-draggable-handle">
                                    <!--<h3 class="panel-title"><strong>Backup System.</strong> </h3>-->
                                    
                                </div>
                                
                                <div class="panel-body">                                                       
                                      <div class="row col-md-12"> 
                                        <div class="col-md-5">
                                            <h5>Click to download Database Backup</h5>
                                            <p><code><b>Note: </b> It may take some time.</code></p>
                                        </div>

                                        <div class="col-md-7">

                                            <center> 

                                                <a href="backup/backup_db" target="_blank" id="db_bckup" type="button" class="btn btn-success btn-lrg " title="DB Backup">   <i class="fa  fa-database"></i>&nbsp; Download </a>
                                                <!--<button id="cancel_sync_btn" type="button" class="btn btn-default btn-lrg ajax " title="Ajax Request">   <i class="fa  fa-stop"></i>&nbsp; Stop Sync. </button>-->

                                            </center>
                                        </div>
                                    </div>
                                    <br><br><hr>
                                      <div class="row col-md-12"> 
                                        <div class="col-md-5">
                                            <h5>Click to download Folder Backup</h5>
                                             <p><code><b>Note: </b> It may take some time.</code></p>
                                        </div>

                                        <div class="col-md-7">

                                            <center> 

                                                <a href="backup/backup_folder" target="_blank"  id="file_bckup" type="button" class="btn btn-warning btn-lrg " title="DB Backup">   <i class="fa  fa-hdd-o"></i>&nbsp; Download </a>
                                                <!--<button id="cancel_sync_btn" type="button" class="btn btn-default btn-lrg ajax " title="Ajax Request">   <i class="fa  fa-stop"></i>&nbsp; Stop Sync. </button>-->

                                            </center>
                                        </div>
                                    </div>
                                    
                                   
                                </div>
                                <div class="panel-footer">
                                                                   
                                    <a href="<?php echo base_url('dashboard');?>" id="search_btn" class="btn btn-primary "><span class="fa fa-backward"></span> Back</a>
                                </div>
                            </div>
                            <?php echo form_close(); ?>               
                                
                         
                     
</div>
</div>
