<table id="example1" class="table  dataTable table-bordered table-striped"> 
            <thead>
                <tr>
                    <th>#</th>
                    <th style="text-align:center;">Invoice No</th> 
                    <th style="text-align:center;">Date</th>   
                    <th style="text-align:center;">Action</th>
                </tr>
            </thead>
            <tbody> 
              <?php 
                   foreach ($rep_data as $cust_id => $search){ 
//                       echo '<pre>';                       print_r($search); die;
                       
                        
                        
//                        $inv_date = date('d M Y',$search['invoice_date']+($search['days_after']*60*60*24));
//                       echo $due_date = strtotime();
//                       die;
                        $i = 0; 
                        if(!empty($search['invoices'])){
                            foreach ($search['invoices'] as $invoice){ 
                                echo '
                                    <tr>
                                        <td>'.($i+1).'</td> 
                                        <td align="center">'.$invoice['supplier_invoice_no'].'</td>
                                        <td align="center">'.(($invoice['invoice_date']>0)?date('d M Y',$invoice['invoice_date']):'').'</td>
                                        <td align="center"><a id="print_'.$invoice['id'].'" class="btn btn-sm btn-success print_btn"><span class="fa fa-print"></span></a></td> 
                                    </tr>';
                                $i++;
                            }
                       }else{ 
                       } 
                   }
              ?>   
        </tbody> 
         </table> 
<script>
    $(document).ready(function(){
        $('.print_btn').click(function(){
            
            var purchse_id = (this.id).split('_')[1];
//            fl_alert('info',this.id)  
            window.open('<?php echo $this->router->fetch_class()."/print_report?";?>'+'prc_id='+purchse_id,'ZV VINDOW',width=600,height=300)
        });
    });
</script>