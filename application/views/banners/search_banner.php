
<script>
    
$(document).ready(function(){  
	get_results();
    $("#user_name").keyup(function(){ 
		event.preventDefault();
		get_results();
    });
	
    $("#email").keyup(function(){ 
		event.preventDefault();
		 get_results();
    });
    
	
    $("#search_btn").click(function(){
		event.preventDefault();
		get_results();
    });
	
	
	function get_results(){
        $.ajax({
			url: "<?php echo site_url('Banners/search');?>",
			type: 'post',
			data : jQuery('#form_search').serializeArray(),
			success: function(result){
                             $("#result_test").html(result);
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
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'add'))?'<a href="'.base_url($this->router->fetch_class().'/add').'" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>':''; ?>
            <?php echo ($this->user_default_model->check_authority($this->session->userdata(SYSTEM_CODE)['user_role_ID'], $this->router->class, 'index'))?'<a href="'.base_url($this->router->fetch_class()).'" class="btn btn-app "><i class="fa fa-search"></i>Search</a>':''; ?>
           
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
                            <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Banner Name</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                                      <?php echo form_input(array('name'=>'user_name', 'id' => 'user_name', 'class'=>'form-control','placeholder'=>'First name or last name')); ?>
                                                    </div>                                            
                                                    <!--<span class="help-block">This is sample of text field</span>-->
                                                </div>
                                            </div> 
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">Email</label>
                                                <div class="col-md-9">                                            
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-search"></span></span>
                                                        
                                                      <?php echo form_input(array('name'=>'email', 'id' => 'email', 'class'=>'form-control','placeholder'=>'Email Address')); ?>
                                                    </div>                                            
                                                    <!--<span class="help-block">This is sample of text field</span>-->
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
              <h3 class="box-title">Search Result</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table dataTable table-bordered table-striped">
               <thead>
                        <tr>
                            <th>#</th>
                            <th>Banner</th> 
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="result_test">
                        <?php
                         $i = 0;
                          foreach ($banner_list as $banner){ 
                              echo '
                                  <tr>
                                      <td>'.($i+1).'</td>
                                      <td>'.$banner['banner_name'].'</td> 
                                      <td>
                                          <a href="'.  base_url($this->router->fetch_class().'/view/'.$banner['id']).'"><span class="fa fa-eye"></span></a> |
                                          <a href="'.  base_url($this->router->fetch_class().'/edit/'.$banner['id']).'"><span class="fa fa-pencil"></span></a> |
                                          <a href="'.  base_url($this->router->fetch_class().'/delete/'.$banner['id']).'"><span class="fa fa-trash"></span></a> 
                                      </td>  ';
                              $i++;
                          }
                         ?>  

                      </tbody>
                <tfoot>
                <tr> 
                    <th>#</th>
                    <th>Banner</th> 
                    <th>Action</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
       
     </div>
    
</div>
