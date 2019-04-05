 
<!-- Modal -->
<div class="modal fade" id="item_view_modal" tabindex="-1" role="dialog" aria-labelledby="item_view_modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="item_view_modalLabel">Item Info</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body"> 
            <div id="item_res1"></div>
           <div class="container-fliud">
               <input hidden type="text" name="pop_item_id" id="pop_item_id" value="">
                   <div id="itm_modal_content"  class=" row">
                           
                   </div>
                
           </div> 
         </div> 
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<script>
    $(document).ready(function(){
        $('.itm_btn_view').click(function(){ 
            alert(this.id)
            var item_id = (this.id).split('_')[0];
            load_item_info(item_id);
            $('#item_view_modal').modal({backdrop: 'static', keyboard: false });   
        });
        
        
        
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
        
        
    }); 
    
function load_item_info(item_id){
//    $("#result_search_itm").html('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i> Retrieving Data..');    
    var post_data = jQuery('#form_search').serializeArray(); 
    post_data.push({name:"function_name",value:'get_single_item_info'}); 
    post_data.push({name:"item_id",value:item_id}); 
    $.ajax({
                    url: "<?php echo site_url($this->router->directory.$this->router->fetch_class().'/fl_ajax');?>", 
                    type: 'post',
                    data : post_data,
                    success: function(result){  
//                         $("#item_res1").html(result);
                        var img_dir = '<?php echo base_url().ITEM_IMAGES;?>';
                        var item_obj = JSON.parse(result);  
                        var otr_images = JSON.parse(item_obj.images);  
//                        alert(otr_images.length)
                        console.log(item_obj);
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
 