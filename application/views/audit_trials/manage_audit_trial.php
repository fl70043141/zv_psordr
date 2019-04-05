<?php 
$log_data = $log_data[0];
//echo '<pre>'; print_r(unserialize($log_data['data_new'])); die; ?>

<section class="invoice">
  <div class="">
            <!--<a  href="<?php // echo base_url($this->router->fetch_class()."/add");?>" class="btn btn-app "><i class="fa fa-plus"></i>Create New</a>-->
            <a href="<?php echo base_url($this->router->fetch_class());?>" class="btn btn-app "><i class="fa fa-search"></i>Search</a>

        </div>
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
              <i class="fa fa-globe"></i> <?php echo $log_data['first_name'].' '.$log_data['last_name'].' ('.$log_data['user_id'].')';?>
              <small class="pull-right">Date: <?php echo date('d/F/Y');?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="col-md-12 invoice-info">
        <div class="col-sm-4 invoice-col">
            <strong>Changes Made</strong>
            <br>
            <br>
          <address>
            Module Object : <?php echo $log_data['module_id']?><br>
            Action : <?php echo $log_data['action_id']?><br>
            User IP Address : <?php echo $log_data['ip']?><br>
            Time : <?php echo date('H:i A (d/F/Y)');?><br>
            DB Table : <?php echo $log_data['table_name']?><br
          </address>
        </div> 
      </div>
      <!-- /.row -->

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12 col-md-12 table-responsive">
            <div class="col-xs-12 col-md-6">
                <h4>Data After Changes</h4>
                <table class="table table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Col-ID</th>
                    <th>Value</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php
                      $i=1;
                        $tbl_old = unserialize($log_data['data_new']);
                        
                        if(!empty($tbl_old)){
                          foreach ($tbl_old[0] as $tab1_data=>$key){
                              echo ' <tr>
                                       <td>'.$i.'</td>
                                       <td>'.$tab1_data.'</td>
                                       <td>'.$key.'</td> 
                                   </tr>';
                              $i++;
                         }
                        }
                      ?> 
                  </tbody>
                </table>
            </div>
            <div class="col-xs-12 col-md-6">
                <h4>Data Before Changes</h4>
                <table class="table table-striped">
                  <thead>
                  <tr>
                    <th>No</th>
                    <th>Col-ID</th>
                    <th>Value</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php
                      $j=1;
                        $tbl_new = unserialize($log_data['data_old']);
//                        echo '<pre>';                        print_r($log_data); 
                        if(!empty($tbl_new)){
                          foreach ($tbl_new[0] as $tab1_data=>$key){
                              echo ' <tr>
                                       <td>'.$i.'</td>
                                       <td>'.$tab1_data.'</td>';
                              if(empty($tbl_old)){
                                    echo '<td><span">'.$key.'</span></td> ';
                              }else{
                                if($key==$tbl_old[0][$tab1_data]){
                                    echo '<td><span">'.$key.'</span></td> ';
                                }else{
                                    echo'<td><span style="background-color:hsla(0, 71%, 55%, 0.52);">'.$key.'</span></td> ';
                                }
                              }
                              echo '</tr>';
                              $i++;
                         }
                        }
                      ?> 
                  </tbody>
                </table>
            </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
 
      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
            <a href="<?php echo base_url('AuditTrials');?>" class="btn btn-default"><i class="fa fa-backward"></i> Back</a>
           
        </div>
      </div>
    </section>
    <!-- /.content -->
    </div>