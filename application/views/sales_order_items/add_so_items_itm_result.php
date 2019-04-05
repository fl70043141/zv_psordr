<style> 
    .cat_click {
        cursor: pointer;
    }
</style>
<div id="item_contents_swipe" class="row ">        
    <?php
    
//        echo '<pre>';        print_r($search_list_items_chunks); die;
    
    if(!empty($search_list_items_chunks)){
        $j=1;
        foreach ($search_list_items_chunks as $search){
//            echo '<pre>';        print_r($res_page_count); die;
            echo form_hidden('itm_data_'.$search['id'], json_encode($search));
            echo '<div style="padding:5px;" class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div id="'.$j.'_'.$search['id'].'"  class="thumbnail itm_click swipeitm_'.$j.'">
                          <a > <img class="toResizeClass" src="'. base_url(ITEM_IMAGES.$search['id'].'/'.$search['image']).'" alt="'.$search['item_name'].'" style="width:100%;height:100px;;overflow: hidden"></a>

                          <div class="caption">
                              <div class="mailbox-attachment-info">
                                <a class="mailbox-attachment-name cat_click"><span style="font-size:10px;">'.$search['item_name'].'</span></a> 
                                </div> 
                          </div> 
                    </div>
                </div>';
             
            if($j%3==0) echo '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> </div>';
            $j++;
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
            <h5 class="modal-title" id="exampleModalLongTitle">Nextlook Item</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <?php echo form_open("", 'id="form_itm"')?>  
   
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner"> 
                        ...
                    </div>
                    <a id="thumb-left-click" class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                      <span class="fa fa-angle-left"></span>
                    </a>
                    <a  id="thumb-right-click" class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                      <span class="fa fa-angle-right"></span>
                    </a>
                    <div class="carousel-small-img row pad">  
                    </div>
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
                      <input hidden="" name="order_id" readonly type="text" id="order_id" value="<?php echo (isset($order_id))?$order_id:0;;?>">
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
        var id2 = (this.id).split('_')[1];
        var id21 = (this.id).split('_')[0];
//        fl_alert('info',id2);
        var itm_data_jsn = $('[name="itm_data_'+id2+'"]').val(); 
        var itm_data = JSON.parse(itm_data_jsn);
//        console.log(itm_data)
        $('#modal_item_uom').text(itm_data.unit_abbreviation);
        $('#modal_item_code').text(itm_data.item_code);
        $('#modal_item_desc').text(itm_data.item_name);
        $('#modal_item_info').text(itm_data.description);
        
        $('#item_code_txt').val(itm_data.item_code);
        $('#item_uom_id_txt').val(itm_data.item_uom_id);
        $('#modal_itm_id').val(itm_data.id);
        $('#modal_price').val(parseFloat(itm_data.item_price_amount).toFixed(2));
        $('#item_det_json').val(itm_data_jsn);
        
        if(typeof(itm_data.image) != "undefined" && itm_data.image !== ""){ 
            var img_def = '<div id="img_1"  name="'+id21+'" class="item active"><img src="<?php echo base_url(ITEM_IMAGES);?>/'+itm_data.id+'/'+itm_data.image+'" alt="First slide" style="width:100%"></div>';
            var img_def_thumb = '<img id="imgtmb_1" style="border-width:5px;height:80px;  border-style:ridge;" class="itm-thmb pad col-md-3 col-sm-3 col-xs-3 border-left" src="<?php echo base_url(ITEM_IMAGES);?>/'+itm_data.id+'/'+itm_data.image+'">';
            $('.carousel-inner').html(img_def); 
            $('.carousel-small-img').html(img_def_thumb); 
        }  
            
        if(typeof(itm_data.images) != "undefined" && itm_data.images !== ""){
            
            var itm_imgdata = JSON.parse(itm_data.images);
            var cnt = 2;
            if(typeof(itm_imgdata) != "undefined" && itm_imgdata !== ""){
                $(itm_imgdata).each(function (index, o) {   
                     var $img = '<div id="img_'+cnt+'" name="'+id21+'" class="item"><img src="<?php echo base_url(ITEM_IMAGES);?>/'+itm_data.id+'/other/'+o+'" alt="First slide" style="width:100%"></div>';
                     var img_def_thumb = '<img id="imgtmb_'+cnt+'" style="border-width:5px;height:80px; border-style:ridge;" class="pad col-md-3 col-sm-3 col-xs-3 itm-thmb" src="<?php echo base_url(ITEM_IMAGES);?>/'+itm_data.id+'/other/'+o+'">';
                        $('.carousel-inner').append($img);
                        $('.carousel-small-img').append(img_def_thumb);
                        cnt++;
                 });
            }
         }  
        $('#exampleModalCenter').modal({
            backdrop: 'static',
            keyboard: false
        })
        $('.item').swipe( {
                //Generic swipe handler for all directions
                swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
                
//                fl_alert('info',$(this).closest('div').attr('name'));
                    var swipe_for = parseFloat($(this).closest('div').attr('name'));
                    if(swipe_for==9 && direction=='left'){ 
                    var page_swip_no = parseFloat($("#page_count_str").val());
//                    fl_alert('info',$("#page_count_str").val()) 
                    page_swip_no++; 
                    swipe_for = 0;  
                    $('#pagination_'+page_swip_no).trigger('click');  
                    $('#exampleModalCenter').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    return false;
                }
                if(swipe_for==1 && direction=='right'){ 
                    var page_swip_no = parseFloat($("#page_count_str").val());
//                    fl_alert('info',$("#page_count_str").val()) 
                    page_swip_no--; 
                    swipe_for = 2;  
                    $('#pagination_'+page_swip_no).trigger('click');  
                    $('#exampleModalCenter').modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    return false;
                }
                    if(direction=='left'){
//                        $('#thumb-right-click').trigger('click'); 
                        swipe_for++;
                        $('.swipeitm_'+swipe_for).trigger('click');
                    }
                    if(direction=='right'){
//                        $('#thumb-left-click').trigger('click');
                        swipe_for--;
                        $('.swipeitm_'+swipe_for).trigger('click');
                    }
                }
              });
              $('.itm-thmb').click(function(){
              var tmbimg_id = (this.id).split('_')[1]; 
              var active_mg = $('.carousel-inner .active').attr('id').split('_')[1];
                var dif = parseFloat(tmbimg_id)-parseFloat(active_mg);
                $('#img_'+active_mg).removeClass('active');
                $('#img_'+tmbimg_id).addClass('active'); 
              });
              
    });
    
//        $('#item_contents_swipe').swipe( {
//            
//                //Generic swipe handler for all directions
//                swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
////                    fl_alert('info',)
////                fl_alert('info',$(this).closest('div').attr('name'));
//                var page_swip_no = parseFloat($("#page_count_str").val());
////                fl_alert('info',$("#page_count_str").val())
//                    if(direction=='left'){ 
//                            page_swip_no++; 
//                        }
//                    if(direction=='right'){ 
//                        page_swip_no--; 
//                    }
//                $('#pagination_'+page_swip_no).trigger('click');
//                }
//            });
    
});
 
 
    function add_item_to_order(){ 
        $("#res1_fl").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Retrieving Data..');    
        set_list_cookies()
        return false;
        var itm_data_jsn = $('[name="itm_data_'+$('[name="modal_itm_id"]').val()+'"]').val();  
        var itm_data = JSON.parse(itm_data_jsn);
        
            $.ajax({
                url: "<?php echo site_url('Sales_order_items/fl_ajax');?>",
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
			url: "<?php echo site_url('Sales_order_items/fl_ajax?function_name=item_list_set_cookies');?>",
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