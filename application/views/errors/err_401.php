
    <!-- Main content -->
    <section class="content"> 
      <div class="error-page">
        <h2 class="headline text-yellow"> 401</h2>

        <div class="error-content">
          <h3><i class="fa fa-warning text-yellow"></i> Oops! Unauthorized Access.</h3>

          <p>
            Unfortunately you are the not authorized user to access this area.! 
          </p>

         <div class="error-actions">                                
                <div class="row">
                    <div class="col-md-6">
                        <a class="btn btn-info btn-block btn-lg" href="<?php echo base_url('dashboard');?>">Back to dashboard</a>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-primary btn-block btn-lg" onclick="history.back();">Previous page</button>
                    </div>
                </div>                                
            </div>
        </div>
        <!-- /.error-content -->
      </div>
      <!-- /.error-page --> 
  <!-- /.content-wrapper -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  
