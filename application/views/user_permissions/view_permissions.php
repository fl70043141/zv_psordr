

<div class="row">  
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
                            <!-- START DEFAULT DATATABLE -->
                    <div class="col-md-12">
                        <br>
                        <div class="box">
                                <div class="box-header">
                                  <h3 class="box-title">User Access Permision</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                  <table id="example1" class="table dataTable table-bordered table-striped">
                                   <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Permission Level</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="result_search">
                                          <?php
                                           $i = 0;
                                            foreach ($user_permission_list as $row){ 
                                                echo '
                                                    <tr>
                                                        <td>'.($i+1).'</td>
                                                        <td>'.$row['user_role'].'</td> 
                                                        <td>
                                                           |
                                                            <a href="'.  base_url('userPermission/edit/'.$row['id']).'"><span class="fa fa-pencil"></span></a> |
                                                            
                                                        </td>  ';
                                                $i++;
                                            }
                                           ?>  
                                             
                                        </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Permission Level</th>
                                        <th>Action</th>
                                    </tr>
                                    </tfoot>
                                  </table>
                                </div>
                                <!-- /.box-body -->
                              </div>

                         </div>
                             
                            <!-- END DEFAULT DATATABLE -->

     </div>
</div>
