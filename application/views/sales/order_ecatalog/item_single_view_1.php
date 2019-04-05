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
 
<link rel="stylesheet" href="<?php echo base_url('templates/plugins/item_grid/grid_style.css');?>">
  <link rel="stylesheet" href="https://idangero.us/swiper/dist/css/swiper.min.css">

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
      <input type="text" name="item_id_clicked" id="item_id_clicked" value="<?php echo $item_id;?>">
      <input type="text" name="item_category_id" id="item_category_id" value="<?php echo $item_cat_id;?>">
      <input type="text" name="curr_page_no" id="curr_page_no" value="<?php echo $item_list_page_no;?>">
      <input type="text" name="price_type_id" id="price_type_id" value="16">
    <div id="item_info_contents" class="swiper-wrapper">
        
    </div>
 
  </div>
  </form>

    
  <!-- Swiper JS -->
  <script src="https://idangero.us/swiper/dist/js/swiper.min.js"></script>

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

  <!-- Initialize Swiper -->
  <script>
    
    $(document).ready(function(){
       load_item_info(); 
    });
    
function load_item_info(){
    
//    $("#result_search_itm").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Retrieving Data..');    
    var post_data = jQuery('#form_item_view').serializeArray(); 
    post_data.push({name:"function_name",value:'get_items_for_view'}); 
    $.ajax({
                    url: "<?php echo site_url($this->router->directory.$this->router->fetch_class().'/fl_ajax');?>", 
                    type: 'post',
                    data : post_data,
                    success: function(result){  
                        var content = '';
//                         $("#item_res1").html(result); return  false;
                        var img_dir = '<?php echo base_url().ITEM_IMAGES;?>';
                        var item_list_obj = JSON.parse(result);  
                        var item_list = item_list_obj.item_res; 
                        $.each(item_list, function (key, item_obj) {
                            content += '<div class="swiper-slide">'+
                                            '<div class="box-body bg-gray-light">'+
                                                  '<div class="container-fliud">'+
                                                                 '<div class=" row">'+
                                                                  '<div class="col-md-12 bg-gray " style="padding: 20px 0 20px;">';
                                                          
                                                          content += '<div class="preview col-md-6">'+

                                                                                     '<div class="preview-pic tab-content">'+
                                                                                        '<div class="tab-pane active" id="pic-1"><img src="https://www.thainativegems.com/wp-content/uploads/2017/06/GRS-2.02ct-Ruby-v3.jpg" /></div>'+
                                                                                        '<div class="tab-pane" id="pic3-2"><img src="https://www.thainativegems.com/wp-content/uploads/2017/02/1.25-carats-Burmese-Ruby-Diamond-Ring.jpg" /></div>'+
                                                                                        '<div class="tab-pane" id="pic3-3"><img src="https://www.thainativegems.com/wp-content/uploads/2017/06/GRS-2.02ct-Ruby.jpg" /></div>'+
                                                                                        '<div class="tab-pane" id="pic3-4"><img src="https://www.thainativegems.com/wp-content/uploads/2017/06/GRS-2.02ct-Ruby-v3.jpg" /></div>'+
                                                                                        '<div class="tab-pane" id="pic3-5"><img src="https://p.globalsources.com/IMAGES/PDT/B0690866284/Stud-earrings.jpg" /></div>'+
                                                                                     '</div>'+
                                                                                     '<ul class="preview-thumbnail nav nav-tabs">'+
                                                                                        '<li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="http://placekitten.com/200/126" /></a></li>'+
                                                                                        '<li><a data-target="#pic3-2" data-toggle="tab"><img src="https://www.thainativegems.com/wp-content/uploads/2017/02/1.25-carats-Burmese-Ruby-Diamond-Ring.jpg" /></a></li>'+
                                                                                        '<li><a data-target="#pic3-3" data-toggle="tab"><img src="https://www.thainativegems.com/wp-content/uploads/2017/06/GRS-2.02ct-Ruby.jpg" /></a></li>'+
                                                                                        '<li><a data-target="#pic3-4" data-toggle="tab"><img src="https://p.globalsources.com/IMAGES/PDT/B0690866284/Stud-earrings.jpg" /></a></li>'+
                                                                                        '<li><a data-target="#pic3-5" data-toggle="tab"><img src="https://p.globalsources.com/IMAGES/PDT/B0690866284/Stud-earrings.jpg" /></a></li>'+
                                                                                     '</ul>'+

                                                                             '</div>'+
                                                                             '<div class="details col-md-6">'+
                                                                                     '<h2 class="product-title">A0101asasa0</h2> '+
                                                                                     '<h3 class="product-title">Blue Sapphires</h3> '+
                                                                                     '<p class="product-description">CDC: No Heat</p>'+
                                                                                     '<p class="product-description">Color: Bluue</p>'+
                                                                                     '<p class="product-description">Shape: Oval</p>'+
                                                                                     '<h3 class="price">Price: <span>LKR 1800</span></h3>'+
                                                                                     '<input type="number" min="0" value="1800" class="form-group input-lg col-sm-8 col-xs-8">'+
                                                                                     '<h4 class="price">Available: <span> 2.817 cts | 1 pcs </span></h4>'+

                                                                                     '<div class="quantity buttons_added row pad" >'+
                                                                                              '<input type="button" value="-" class="minus btn btn-lg bg-red-gradient col-sm-2 col-xs-2">'+
                                                                                              '<input type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="col-xs-4 col-sm-4 input-text qty text form-group input-lg" size="6" pattern="" inputmode="">'+
                                                                                              '<input type="button" value="+" class="plus btn btn-lg bg-green-gradient col-sm-2 col-xs-2">'+
                                                                                      '</div>'+
                                                                                     '<div class="action">'+
                                                                                             '<button class="like btn btn-default" type="button"><span class="fa fa-backward"></span> Back</button>'+
                                                                                             '<button class="add-to-cart btn btn-default" type="button"><span class="fa fa-plus"></span> add to order</button>'+
                                                                                     '</div>'+
                                                                             '</div>'+
                                                                          '</div>'+
                                                                     '</div>'+
                                                             '</div>'+ 
                                                      '</div>'+ 
                                        '</div>';

                        }); 
                        
                             $("#item_info_contents").html(content);
                             
                    var swiper = new Swiper('.swiper-container');
                        return false;
                        
                        var otr_images = JSON.parse(item_obj.images);  
//                        alert(otr_images.length)
                         var content = '<div class="preview col-md-6">'+
                                                    '<div class="preview-pic tab-content">'+
                                                      '<div class="tab-pane active" id="pic-1"><img src="'+img_dir+item_obj.id+'/'+((item_obj.image!="")?item_obj.image:'../../default/default.jpg')+'" /></div>';
                                    
                                    var i=2;
                                    if(otr_images.length>0){
                                        $.each(otr_images, function (key, otr_img_name) { 
                                            content +=   '<div class="tab-pane" id="pic-'+i+'"><img src="'+img_dir+item_obj.id+'/other/'+otr_img_name+'" /></div>';
                                            i++;
                                        });
                                    }
                                    content +=   '</div>'+
                                                    '<ul class="preview-thumbnail nav nav-tabs">'+
                                                      '<li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="'+img_dir+item_obj.id+'/'+((item_obj.image!="")?item_obj.image:'../../default/default.jpg')+'" /></a></li>';
                                    var j=2;
                                    if(otr_images.length > 0){
                                        $.each(otr_images, function (key, otr_img_name_tmb) {
                                            content +=   '<li><a data-target="#pic-'+j+'" data-toggle="tab"><img src="'+img_dir+item_obj.id+'/other/'+otr_img_name_tmb+'" /></a></li>';
                                            j++;
                                        });
                                        }
                                        
                                    content += '</ul>'+

                                            '</div>'+
                                            '<div class="details col-md-6">'+
                                                    '<h3 class="product-title">Code: '+item_obj.item_code+'</h3> '+
                                                    '<h4 class="product-title">Name: '+item_obj.item_name+'</h4> ';
                                        if(item_obj.is_gem == 1){
                                            content += (item_obj.treatment_name != null)?'<text> CDC: '+item_obj.treatment_name+' </text>':'';
                                            content += (item_obj.color_name != null)?'<text> Color: '+item_obj.color_name+' </text>':'';
                                            content += (item_obj.shape_name != null)?'<text> Shape: '+item_obj.shape_name+' </text>':'';
                                            content += (item_obj.certification_name != null)?'<text> Certification: '+item_obj.certification_name+' </text>':'';
                                            content += (item_obj.certification_no != "")?'<text> Certification ID/No: '+item_obj.certification_no+' </text>':'';
                                            content += (item_obj.origin_name != "")?'<text> Origin: '+item_obj.origin_name+' </text>':'';
                                        }
                                        content += '<h4 class="price">Price: <span>'+((typeof(item_obj.item_price_info.currency_code) != 'undefined')?item_obj.item_price_info.currency_code:'')+' '+ ((typeof(item_obj.item_price_info.price_amount) != 'undefined')?item_obj.item_price_info.price_amount:'--')+'</span></h4>';
                                       
            
                                        content += '<h5 class="price">Available: <span>'+item_obj.item_stock_info.tot_units_1+' '+item_obj.unit_abbreviation+((parseFloat(item_obj.item_stock_info.tot_units_2)>0)?'  |  '+item_obj.item_stock_info.tot_units_2+' '+item_obj.unit_abbreviation_2:'')+'</span></h5>';
                                        content += '<div class="quantity buttons_added">'+
                                                            '<input type="button" value="-" class="minus">'+
                                                            '<input type="number" step="1" min="1" max="" name="quantity" value="1" title="Qty" class="input-text qty text form-group" size="6" pattern="" inputmode="">'+
                                                            '<input type="button" value="+" class="plus">'+
                                                    '</div>';
                                     
                                        content +=    '<div class="action">'+
                                                            '<button class="add-to-cart btn btn-default" type="button">add to cart</button>'+
                                                            '<button class="like btn btn-default" type="button"><span class="fa fa-heart"></span></button>'+
                                                    '</div>'+
                                            '</div>';
                                            
                                        
                             $("#itm_modal_content").html(content);
                             
                        
                }
            });
}
  </script>