<table id="left_table" class="table  dataTable table-bordered afaf table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th style="text-align:center;">Category</th> 
            <th style="text-align:center;">Code</th> 
            <th style="text-align:center;">Desc</th>  
            <th style="text-align:center;">Location</th>  
            <th style="text-align:center;">In Stock</th>  
        </tr>
    </thead>
        <tbody id=left_tbl_body"">
              <?php 
                        $i = 0; 
                        if(!empty($rep_data['item_list'])){
                            foreach ($rep_data['item_list'] as $item){ 
//            echo '<pre>';            print_r($item); die;
                                if($item['units_available']>0){
                                    echo '
                                        <tr id="itml_'.$item['item_code'].'">
                                            <td>'.($i+1).'</td> 
                                            <td align="center">'.$item['item_category_name'].'</td>
                                            <td align="center">'.$item['item_code'].'</td>
                                            <td align="center">'.$item['item_name'].'</td>
                                            <td align="center">'.$item['location_code'].'</td>
                                            <td align="center">'.$item['units_available'].' '.$item['uom_name'].' '.(($item['uom_id_2']!=0)?'| '.$item['units_available_2'].' '.$item['uom_name_2']:'-').'</td>
                                        </tr>';
                                    $i++;
                                }
                            }
                       }else{
                            echo '<tr>
                                    <td>No Results found</td> 
                                </tr>';
                       } 
                       ?>
        </tbody> 
         </table> 

<script src="<?php echo base_url('templates/plugins/barcode_scan_detector/jquery.scannerdetection.compatibility.js')?>"></script>
<script src="<?php echo base_url('templates/plugins/barcode_scan_detector/jquery.scannerdetection.js')?>"></script>

<script>
$(document).scannerDetection({
    
  //https://github.com/kabachello/jQuery-Scanner-Detection

    timeBeforeScanTest: 200, // wait for the next character for upto 200ms
    avgTimeByChar: 40, // it's not a barcode if a character takes longer than 100ms
    endChar: [4],
  //preventDefault: true, //this would prevent text appearing in the current input field as typed 
    onComplete: function(barcode, qty){ 
        $('#barcode_input_stock').focus(); 
        $('#barcode_input_stock').val('');
        $('#barcode_input_stock').val(barcode);  
        $('#scanned_code').val(barcode);  
        set_checked_list(barcode);
        $('.uncheck_itm').click(function(){ 
            var itm_id = (this.id).split('_')[1]; 
            fl_alert('info',itm_id)
            $('#right_tbl_body #actd_'+itm_id).remove();
        });
//        $('#barcode_input_stock').trigger('click');
//        fl_alert('info',barcode)
        return false;
    }  
});   

 
function set_checked_list(item_id){
    var tr_left_data = $('#itml_'+item_id).html();
    $('#itml_'+item_id).remove();
    if(typeof(tr_left_data)!='undefined'){ 
        var append_row = '<tr id="itmr_'+item_id+'" style="background-color:#ccffcc;">'+tr_left_data+'<td  id="actd_'+item_id+'"><a id="itmrmv_'+item_id+'" title="UnCheck" class="btn btn-primary btn-xs uncheck_itm"><span class="fa fa-chevron-circle-left"></span></a></td></tr>';
        
//        fl_alert('info',append_row);
        $('#right_tbl_body').append(append_row);
        $('#checked_item_count').text($('#right_tbl_body tr').length);
        $('#pending_item_count').text($('#result_search tbody tr').length);
          
        
    }
//    if()
}
</script>