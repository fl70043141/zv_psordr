 <!-- Error Msg-->
 <div id="msgs"> 
        
 </div>  
<link rel="stylesheet" href="<?php echo base_url('templates/plugins/item_grid/grid_style.css');?>">
<link rel="stylesheet" href="<?php echo base_url('templates/plugins/swiper/swiper.min.css');?>">
<!--  <link rel="stylesheet" href="https://idangero.us/swiper/dist/css/swiper.min.css">-->

 <!-- Demo styles -->
  <style> 
    .swiper-container {
      width: 100%;
      height: 100%;
    }
    .swiper-slide { 
      /* Center slide text vertically */
      display: -webkit-box;
      display: -ms-flexbox;
      display: -webkit-flex;
      display: flex;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      -webkit-justify-content: center;
      justify-content: center;
      -webkit-box-align: center;
      -ms-flex-align: center;
      -webkit-align-items: center;
      align-items: center;
    }
  </style>
  <div id="item_res1"> </div>
  
  <form id="form_item_view" method="post">
  <div class="swiper-container">
      <input hidden type="text" name="item_id_clicked" id="item_id_clicked" value="<?php echo $item_id;?>">
      <input hidden  type="text" name="item_category_id" id="item_category_id" value="<?php echo $item_cat_id;?>">
      <input hidden  type="text" name="curr_page_no" id="curr_page_no" value="<?php echo $item_list_page_no;?>">
      <input hidden  type="text" name="order_id" id="order_id" value="<?php echo $order_id;?>">
      <input hidden  type="text" name="price_type_id" id="price_type_id" value="<?php echo $price_type_id;?>"> 
    <div id="item_info_contents" class="swiper-wrapper">
      
    </div>
 
  </div>
  </form>

    

    <script>
        
        //scripe for plus minus btn
        function wcqib_refresh_quantity_increments() {
                    jQuery("div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)").each(function(a, b) {
                        var c = jQuery(b);
                        c.addClass("buttons_added"), c.children().first().before('<input type="button" value="-" class="minus" />'), c.children().last().after('<input type="button" value="+" class="plus" />')
                    })
                }
                String.prototype.getDecimals || (String.prototype.getDecimals = function() {
                    var a = this,
                        b = ("" + a).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                    return b ? Math.max(0, (b[1] ? b[1].length : 0) - (b[2] ? +b[2] : 0)) : 0
                }), jQuery(document).ready(function() {
                    wcqib_refresh_quantity_increments()
                }), jQuery(document).on("updated_wc_div", function() {
                    wcqib_refresh_quantity_increments()
                }), jQuery(document).on("click", ".plus, .minus", function() {
                    var a = jQuery(this).closest(".quantity").find(".qty"),
                        b = parseFloat(a.val()),
                        c = parseFloat(a.attr("max")),
                        d = parseFloat(a.attr("min")),
                        e = a.attr("step");
                    b && "" !== b && "NaN" !== b || (b = 0), "" !== c && "NaN" !== c || (c = ""), "" !== d && "NaN" !== d || (d = 0), "any" !== e && "" !== e && void 0 !== e && "NaN" !== parseFloat(e) || (e = 1), jQuery(this).is(".plus") ? c && b >= c ? a.val(c) : a.val((b + parseFloat(e)).toFixed(e.getDecimals())) : d && b <= d ? a.val(d) : b > 0 && a.val((b - parseFloat(e)).toFixed(e.getDecimals())), a.trigger("change")
                });
    </script>
  <!-- Swiper JS -->
  <script src="<?php echo base_url('templates/plugins/swiper/swiper.min.js');?>"></script>

  <!-- Initialize Swiper -->
  <script>
    
        var swiper = new Swiper('.swiper-container');
        swiper.on('reachEnd', function () {  
            var next_page = parseFloat($('#curr_page_no').val()) + 1;
            $('#curr_page_no').val(next_page); 
            load_item_info(0,(swiper.activeIndex+1),'A',false); 
        });
        swiper.on('reachBeginning', function () { 
            var prev_page = parseFloat($('#curr_page_no').val()) - 1; 
            if(prev_page>0){
                $('#curr_page_no').val(prev_page); 
                load_item_info(0,(swiper.activeIndex-1),'P',true); 
            }
        });
    $(document).ready(function(){
        var item_id = parseFloat("<?php echo $item_id;?>"); 
        load_item_info(item_id); 
        
    });
    
function load_item_info(item_id,init_id = 0,type='A',slideTo=true){ // A: append, P:prepend
    
//    $("#result_search_itm").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Retrieving Data..');    
    var post_data = jQuery('#form_item_view').serializeArray(); 
    post_data.push({name:"function_name",value:'get_items_for_view'},{name:"itm_id",value:item_id}); 
    $.ajax({
                    url: "<?php echo site_url($this->router->directory.$this->router->fetch_class().'/fl_ajax');?>", 
                    type: 'post',
                    data : post_data,
                    success: function(result){  
                        var content = ''; var count = 0;  
//                         $("#item_res1").html(result); return  false;
                        var img_dir = '<?php echo base_url().ITEM_IMAGES;?>';
                        var item_list_obj = JSON.parse(result);  
                        var item_list = item_list_obj.item_res; 
//                        console.log(item_list);
                        if(typeof(item_list) != 'undefined'){
                            $.each(item_list, function (key, item_obj) {
                                if(item_id == item_obj.item_id){
                                    init_id = count;
                                }
                                if(item_obj.images=="") item_obj.images='[]';
                                var otr_images = JSON.parse(item_obj.images); 
                                var cur_page = $('#curr_page_no').val();
                                content += '<div id="'+item_obj.item_id+'_itemdiv" class="page_'+cur_page+' swiper-slide '+((item_obj.item_id == item_id)?'swiper-slide-active':'')+'">'+
                                                '<div class="box-body bg-gray-light">'+
                                                      '<div class="container-fliud">'+
                                                                     '<div class=" row">'+
                                                                      '<div class="col-md-12 bg-gray " style="padding: 20px 0 20px; ">';

                                                                        content += '<div class="preview col-md-6">'+
                                                                                                  '<div class="preview-pic tab-content">'+
                                                                                                    '<div class="tab-pane active" id="'+item_obj.item_id+'-pic-1"><img style="width:'+(window.innerWidth)+'px;"  src="'+img_dir+item_obj.item_id+'/'+((item_obj.image!="")?item_obj.image:'../../default/default.jpg')+'" /></div>';
                                                                                var i=2;
                                                                                if(otr_images.length>0){
                                                                                    $.each(otr_images, function (key, otr_img_name) {
                                                                                        content +=   '<div class="tab-pane" id="'+item_obj.item_id+'-pic-'+i+'"><img style="width:'+(window.innerWidth)+'px;" src="'+img_dir+item_obj.item_id+'/other/'+otr_img_name+'" /></div>';
                                                                                        i++;
                                                                                    });
                                                                                } 
                                                                            content +=   '</div>'+
                                                                                            '<ul class="preview-thumbnail nav nav-tabs">'+
                                                                                              '<li class="active"><a data-target="#'+item_obj.item_id+'-pic-1" data-toggle="tab"><img id="'+item_obj.item_id+'-img-1"  src="'+img_dir+item_obj.item_id+'/'+((item_obj.image!="")?item_obj.image:'../../default/default.jpg')+'"  class="tmb-img"/></a></li>';
                                                                            var j=2;
                                                                            if(otr_images.length > 0){
                                                                                $.each(otr_images, function (key, otr_img_name_tmb) {
                                                                                    content +=   '<li><a data-target="#'+item_obj.item_id+'-pic-'+j+'" data-toggle="tab"><img id="'+item_obj.item_id+'-img-'+j+'" src="'+img_dir+item_obj.item_id+'/other/'+otr_img_name_tmb+'" class="tmb-img"/></a></li>';
                                                                                    j++;
                                                                                });
                                                                                }


                                                                        content += '</ul>'+

                                                                                '</div>'+
                                                                                '<div class="details col-md-6">'+
                                                                                        '<h3 class="product-title">Code: '+item_obj.item_code+'</h3> '+
                                                                                        '<h4 class="product-title">Name: '+item_obj.item_name+'</h4>'+
                                                                                        ((item_obj.is_gem == 0)?'<h5 class="product-title">Category: '+item_obj.category_name+'</h5>':'')+'';
                                                                        if(item_obj.is_gem == 1){
                                                                            content += (item_obj.treatment_name != null)?'<text> CDC: '+item_obj.treatment_name+' </text>':'';
                                                                            content += (item_obj.color_name != null)?'<text> Color: '+item_obj.color_name+' </text>':'';
                                                                            content += (item_obj.shape_name != null)?'<text> Shape: '+item_obj.shape_name+' </text>':'';
                                                                            content += (item_obj.certification_name != null)?'<text> Certification: '+item_obj.certification_name+' </text>':'';
                                                                            content += (item_obj.certification_no != "")?'<text> Certification ID/No: '+item_obj.certification_no+' </text>':'';
                                                                            content += (item_obj.origin_name != "")?'<text> Origin: '+item_obj.origin_name+' </text>':'';
                                                                        }

                                                                            content +=  '<h3 class="price">Price: <span>'+((typeof(item_obj.item_price_info.currency_code) != 'undefined')?item_obj.item_price_info.currency_code:'')+' '+ ((typeof(item_obj.item_price_info.price_amount) != 'undefined')?parseFloat(item_obj.item_price_info.price_amount).toFixed(2):'--')+'</span></h3>'+
                                                                                         '<input  id="'+item_obj.item_id+'_amountinpt" name="item_tmp['+item_obj.item_id+'][unit_price]" type="number" min="0" value="'+((typeof(item_obj.item_price_info.price_amount) != 'undefined')?item_obj.item_price_info.price_amount:'0')+'" class="form-group input-lg col-sm-8 col-xs-8 amount_inpt">'+
                                                                                         '<h4 class="price">Available: <span>'+item_obj.item_stock_info.tot_units_1+' '+item_obj.unit_abbreviation+((parseFloat(item_obj.item_stock_info.tot_units_2)>0)?'  |  '+item_obj.item_stock_info.tot_units_2+' '+item_obj.unit_abbreviation_2:'')+'</span></h4>'+

                                                                                         '<div class="quantity buttons_added row pad" >'+
                                                                                                  '<input type="button" value="-" class="minus btn btn-lg bg-red-gradient col-sm-2 col-xs-2">'+
                                                                                                  '<input id="'+item_obj.item_id+'_qtyinpt" name="item_tmp['+item_obj.item_id+'][units]" type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="col-xs-4 col-sm-4 input-text qty text form-group input-lg" size="6" pattern="" inputmode="">'+
                                                                                                  '<input hidden id="'+item_obj.item_id+'_itemidinpt" type="text" name="item_tmp['+item_obj.item_id+'][item_id]" value="'+item_obj.item_id+'">'+
                                                                                                  '<input type="button" value="+" class="plus btn btn-lg bg-green-gradient col-sm-2 col-xs-2">'+
                                                                                          '</div>'+
                                                                                         '<div class="action row">'+
                                                                                                    '<div class="col-md-6 col-xs-6 col-sm-6"> <a onclick="window.close()"class="like btn btn-default  btn-block" type="button"><span class="fa fa-backward"></span> Back</a> </div>'+
                                                                                                    '<div class="col-md-6  col-xs-6 col-sm-6"> <a  id="'+item_obj.item_id+'_addcartbtn"  class="add-to-cart btn btn-default pull-right  btn-block bg-blue" type="button"><span class="fa fa-plus"></span> add to order</a> </div>'+
                                                                                         '</div>'+
                                                                                 '</div>'+
                                                                              '</div>'+
                                                                         '</div>'+
                                                                 '</div>'+ 
                                                          '</div>'+ 
                                            '</div>';
                                    count++;

                            }); 
                            if(type == 'P'){
                                swiper.prependSlide(content); 
                                if(slideTo){
                                    swiper.slideTo(9, 100, false);
//                                    alert(8)
                                }
                            }else{
                                swiper.appendSlide(content);
                                if(slideTo)
                                    swiper.slideTo(init_id, 100, false);
                            }
                        }else{
                            
                            if(type == 'A'){
                                var next_page = parseFloat($('#curr_page_no').val()) - 1;
                                $('#curr_page_no').val(next_page); 
                            }
                        }
//                        alert($('#curr_page_no').val())
//                             $("#item_info_contents").append(content); 

                             
                             //tmb pic resize
//                             $('.tmb-img').each(function(){
//                                var cw = $('#'+(this.id)).width();
//                                $('#'+this.id).css({'height':(cw*0.75)+'px'});
//                             }); 
                            if(typeof (item_list) != 'undefined'){
                             $('.add-to-cart').click(function(){
                                var add_item_id = (this.id).split("_")[0];

                                var unit_price = parseFloat($('#'+add_item_id+'_amountinpt').val());
                                var units = parseFloat($('#'+add_item_id+'_qtyinpt').val()); 

                                if(units <=0 || isNaN(units)){
                                    fl_alert('warning','Item Units invalid! Please Check bfore add.');
                                    return false;
                                }
                                if(unit_price <=0 || isNaN(unit_price)){
                                    fl_alert('warning','Item Unit Price invalid!');
                                    return false;
                                }
//                                alert($('#'+add_item_id+'_qtyinpt').val()); 
                                var post_data = jQuery('#form_item_view').serializeArray(); 
                                post_data.push({name:"function_name",value:'add_to_tmp_order'}); 
                                $.ajax({
                                            url: "<?php echo site_url($this->router->directory.$this->router->fetch_class().'/fl_ajax');?>", 
                                            type: 'post',
                                            data : {function_name:'add_to_tmp_order', item_id:add_item_id, units: $('#'+add_item_id+'_qtyinpt').val(), unit_price: $('#'+add_item_id+'_amountinpt').val(), order_id: $('#order_id').val() },
                                            success: function(result1){   
//                                                alert(result1)
                                                if(result1=='1'){
                                                    fl_alert('success','Item Successfully added to order.');
//                                                    $('#msgs').html('<div class="alert alert-success msg_err"> <a class="close" data-dismiss="alert" href="#">&times;</a>  <i class="fa fa-check-circle"></i>&nbsp; Item Successfully added to order  </div>')
                                                }else{
                                                    fl_alert('danger','Error! Something went wrong!');
                                                    
//                                                    $('#msgs').html('<div class="alert alert-danger msg_err"> <a class="close" data-dismiss="alert" href="#">&times;</a>  <i class="fa fa-warning"></i>&nbsp;Error! Something went wrong!  </div>')
                                                } 
                                                
                                                $('.msg_err').delay(1500).slideUp(1000);
                                            }
                                        });
                                
                             });
                            }
                        
                }
            });
}


</script>