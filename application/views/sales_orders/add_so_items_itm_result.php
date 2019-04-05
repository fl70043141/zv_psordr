<style> 
    .cat_click {
        cursor: pointer;
    }
</style>
<div class="row ">        
    <?php
    
//        echo '<pre>';        print_r($search_list_items_chunks); die;
    
    if(!empty($search_list_items_chunks)){
        foreach ($search_list_items_chunks as $search){
//            echo '<pre>';        print_r($res_page_count); die;
            echo form_hidden('itm_data_'.$search['id'], json_encode($search));
            echo '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div id="'.$search['id'].'"  class="thumbnail itm_click">
                          <a > <img src="'. base_url(ITEM_IMAGES.$search['id'].'/'.$search['image']).'" alt="'.$search['item_name'].'" style="width:100%;overflow: hidden"></a>

                          <div class="caption">
                              <div class="mailbox-attachment-info">
                                <a class="mailbox-attachment-name cat_click">'.$search['item_name'].'</a> 
                                </div> 
                          </div>
                    </div>
                </div>';
        }
    }else{
        echo '<p><span class="fa fa-warning"></span> No Items found for this Category!</p>';
    }
    ?>
</div>


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Nextlook Item </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <?php echo form_open("", 'id="form_itm"')?>  
   
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner"> 
                        ...
                    </div>
                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                      <span class="fa fa-angle-left"></span>
                    </a>
                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                      <span class="fa fa-angle-right"></span>
                    </a>
              </div>
             <div class="caption">
                <div class="mailbox-attachment-info">
                  <div class="mailbox-attachment-name">
                      <h5>NAME : <span id="modal_item_desc">--</span></h5>
                      <h5>ITEM NO : <span id="modal_item_code">--</span></h5>
                      <h5>ITEM DESC : <span id="modal_item_info">--</span></h5>
                      <div class="row">
                          <div class="col-md-6  col-sm-6  col-xs-6">
                                UNITS : <span id="modal_item_uom">--</span>
                                <input name="modal_qty" class="form-control" type="number" id="modal_qty" min="1" value="1">
                            </div>
                          <div class="col-md-6  col-sm-6  col-xs-6">
                                Price : <span id="modal_item_price"></span>
                                <input name="modal_price" class="form-control" type="text" id="modal_price" min="0" value="0">
                            </div>
                      </div> 
                      <input hidden="" name="modal_itm_id" readonly type="text" id="modal_itm_id" value="">
                      <input hidden="" name="order_id" readonly type="text" id="order_id" value="<?php echo $order_id;?>">
                      <input  hidden="" name="item_code_txt" readonly type="text" id="item_code_txt" value="">
                      <input  hidden="" name="item_uom_id_txt" readonly type="text" id="item_uom_id_txt" value="">
                      <input  hidden="" name="item_det_json" readonly type="text" id="item_det_json" value="">
                      <div id="res1_fl"></div>
                  </div> 
                  </div>  

          </div>
          <div class="modal-footer"> 
              <div class="row">
                  <div style="padding-top: 5px;" class="col-md-6 col-sm-6  col-xs-6">
                      <a id="confirm_order_item" type="button" class="btn btn-block btn-success btn-lg">Add to Order</a>
                  </div>
                  <div style="padding-top: 5px;" class="col-md-6 col-sm-6  col-xs-6">
                        <a type="button" class="btn btn-block btn-primary btn-lg" data-dismiss="modal">Back</a>
                  </div>
              </div>
          </div>
              <?php echo form_close();?>
        </div>
      </div>
</div>

<script>
 
$(document).ready(function() {
    $('#confirm_order_item').click(function(){
//        fl_alert('info',)
        add_item_to_order();
    });
    $('.itm_click').click(function(){
//        fl_alert('info',this.id);
        var itm_data_jsn = $('[name="itm_data_'+this.id+'"]').val(); 
        var itm_data = JSON.parse(itm_data_jsn);
//        console.log(itm_data)
        $('#modal_item_uom').text(itm_data.unit_abbreviation);
        $('#modal_item_code').text(itm_data.item_code);
        $('#modal_item_desc').text(itm_data.item_name);
        $('#modal_item_info').text(itm_data.description);
        $('#exampleModalLongTitle').text(itm_data.description);
        
        $('#item_code_txt').val(itm_data.item_code);
        $('#item_uom_id_txt').val(itm_data.item_uom_id);
        $('#modal_itm_id').val(itm_data.id);
        $('#modal_price').val(parseFloat(itm_data.item_price_amount).toFixed(2));
        $('#item_det_json').val(itm_data_jsn);
        
        if(typeof(itm_data.image) != "undefined" && itm_data.image !== ""){ 
            var img_def = '<div class="item active"><img src="<?php echo base_url(ITEM_IMAGES);?>/'+itm_data.id+'/'+itm_data.image+'" alt="First slide"></div>';
            $('.carousel-inner').html(img_def); 
        }  
            
        if(typeof(itm_data.images) != "undefined" && itm_data.images !== ""){
            
            var itm_imgdata = JSON.parse(itm_data.images);
            if(typeof(itm_imgdata) != "undefined" && itm_imgdata !== ""){
                $(itm_imgdata).each(function (index, o) {   
                     var $img = '<div class="item"><img src="<?php echo base_url(ITEM_IMAGES);?>/'+itm_data.id+'/other/'+o+'" alt="First slide"></div>';
                     $('.carousel-inner').append($img);
                 });
            }
         } 
        $('#exampleModalCenter').modal('toggle')
    });
});
 
    function add_item_to_order(){ 
        $("#res1_fl").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Retrieving Data..');    
        set_list_cookies()
        return false;
        var itm_data_jsn = $('[name="itm_data_'+$('[name="modal_itm_id"]').val()+'"]').val();  
        var itm_data = JSON.parse(itm_data_jsn);
        
            $.ajax({
                url: "<?php echo site_url('Sales_orders/fl_ajax');?>",
                type: 'post',
                data : {function_name:'add_items_order',item_dets:itm_data,order_id:$('#order_id').val(),modal_qty:$('#modal_qty').val(),modal_price:$('#modal_price').val()},
                success: function(result){
//                    fl_alert('info',result)
                    if(result){
                        $("#res1_fl").html('<br><p style="color:green;">Item added Suucessfully</p>');
                    }else{
                        $("#res1_fl").html('<br><p style="color:red;">Error! Something went wrong. Please Retry!</p>');
                    }
                       
                }
            });
	}
        
        function set_list_cookies(){
            var tabl_data = jQuery('#form_itm').serializeArray(); 
            var input_lengt = tabl_data.length;
            tabl_data[input_lengt] = {name:'function_name',value:'item_list_set_cookies'}
//            fl_alert('info',)
            $.ajax({
			url: "<?php echo site_url('Sales_orders/fl_ajax?function_name=item_list_set_cookies');?>",
			type: 'post',
			data : tabl_data,
			success: function(result){
                                $("#res1_fl").html(result);
                                if(result){
                                    $("#res1_fl").html('<br><p style="color:green;"><span class="fa fa-check-circle"></span> Item added to order list.</p>');
                                    $('#modal_qty').val(1);
                                }else{
                                    $("#res1_fl").html('<br><p style="color:red;">Error! Something went wrong. Please Retry!</p>');
                                }
                                jQuery('#res1_fl p').delay(1000).slideUp(2000);
                        }
            });
        }
        
    </script>