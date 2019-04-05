<div class="row">        
    <?php
    
//    echo form_hidden('page_count', $res_page_count); 
    if(!empty($search_list_cats)){
        foreach ($search_list_cats as $search){
    //        echo '<pre>';        print_r($search); die;
            echo '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
          <div  id="'.$search['cat_id'].'" class="thumbnail cat_click">

              <div class="caption">
                  <div class="mailbox-attachment-info">
                  <a class="mailbox-attachment-name">'.$search['category_name'].'</a> 
                </div>
              </div>
                <a> <img src="'. base_url(CAT_IMAGES.$search['cat_id'].'/'.$search['cat_image']).'" alt="'.$search['category_name'].'" style="width:100%;overflow: hidden"></a>
          </div>
        </div>';
        }
    }else{
        echo '<p><span class="fa fa-warning"></span> No results found for this Category!</p>';
    }
    ?>
    
</div>

<script>
 
$(document).ready(function() {
    $('.cat_click').click(function(){
        get_results_item2(this.id);
    });
});
function get_results_item2(cat_id=''){ 
            var cat = (cat_id!='')?cat_id:$('#category_id').val();
            var pages = 1;
//                return false;
            
            
            $("#result_search_items").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Retrieving Data..');    
           
            $.ajax({
                    url: "<?php echo site_url('Sales_orders/fl_ajax');?>",
                    type: 'post',
                    data : {function_name:'pagination_dets',category_id:cat,item_code:$('#item_code').val(),order_id:$('[name="order_id"]').val()},
                    success: function(result){
                        pages=result;  
//                        fl_alert('info',pages)
                        var opts = {
                            onPageClick: function (event, page) {
                                $.ajax({
                                    url: "<?php echo site_url('Sales_orders/fl_ajax');?>",
                                    type: 'post',
                                    data : {function_name:'search_items',category_id:cat,item_code:$('#item_code').val(),order_id:$('[name="order_id"]').val(),page_no:page},
                                    success: function(result){
            //                            console.log(result);
                                         $('ul.setup-panel li:eq(1)').removeClass('disabled');
                                        $('ul.setup-panel li a[href="#step-2"]').trigger('click'); 
                                         $("#result_search_items").html(result); 

            //                             $(".dataTable").DataTable();
                                    }
                                });
                            },
                            totalPages: pages,
                            visiblePages: 5,
                        };

                            $('#pagination').twbsPagination('destroy');
                            $('#pagination').twbsPagination(opts); 
                    }
                });
            
            
            
           
            
	}
    </script>