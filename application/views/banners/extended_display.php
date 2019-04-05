 
<script>
$(document).ready(function(){
     
      get_temp_invoice()
  setInterval(function () {
      get_temp_invoice();
}, 200);

function get_temp_invoice(){
     $.ajax({
                url: "<?php echo site_url('Extended_display/get_temp_invoice_data');?>",
                type: 'post',
                data : {function_name:"get_temp_invoice_data"},
                success: function(result){
                    
                            var obj1 = JSON.parse(result); 
                            var gross_amount = 0;
                            var discount_total = 0;
                            var balance_amount = 0;
                            var last_item = '';
                            var item_count = 0;
//                                console.log(obj1); return false; 
                            var body2 = '';
                            $.each(obj1.items,function(index,item){
                                gross_amount += parseFloat(item.item_unit_cost) * parseFloat(item.item_quantity); 
                                discount_total +=  parseFloat(item.item_line_discount);
                                last_item = item.item_desc; 
                                item_count++;
                            });
                            if(discount_total>0){ 
                                body2 += '<tr>'+
                                            '<td style="line-height: 35px;" align="left">Discount Total</td>'+
                                            '<td style="line-height: 35px;"  align="right">-'+parseFloat(discount_total).toFixed(2)+'</td>'+
                                        '</tr> ';
                            }
                            
                            balance_amount = gross_amount - discount_total;
                            $.each(obj1.payments,function(p_index,payment){
                                var paymethod = '';
                                switch(p_index){
                                    case 'cash': paymethod = 'Cash'; break;
                                    case 'card': paymethod = 'Card'; break;
                                    case 'return_refund': paymethod = 'Return Refund'; break;
                                    case 'voucher': paymethod = 'Voucher'; break;
                                }
                                $.each(payment,function(pay_index,pay_amount){
                                    balance_amount -= parseFloat(pay_amount); 
                                    body2 += '<tr>'+
                                                '<td style="line-height: 35px;" align="left">'+paymethod+'</td>'+
                                                '<td style="line-height: 35px;"  align="right">'+parseFloat(pay_amount).toFixed(2)+'</td>'+
                                            '</tr> ';
                                });
                                 
                            });
                             
                            $('#gross_amount').text(parseFloat(gross_amount).toFixed(2));
                            $('#ext_display_body').html(body2);
                            $('#balace_footer').html('<tr>'+
                                                        '<td style="line-height: 40px;"  align="left"><b>To Pay </b></td>'+
                                                        '<td style="line-height: 40px;"  align="right"><b>'+parseFloat(balance_amount).toFixed(2)+'</b></td>'+
                                                    '</tr>');
                            $('#last_item_name').html(last_item);     
                            $('#total_items').text(item_count);  
                }
        }); 
}
});
</script>  

<div class="row" style="background: white;">
    <div class="box-header with-border">
        <div class="col-md-8">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
              <!-- Indicators -->
              <ol class="carousel-indicators">
                <?php
                    $j=0;
                    $banner_info = json_decode($banners[0]['data_json'],true);
//                        echo '<pre>';                        print_r($banner_info);
                    foreach ($banner_info as $banner){
                        $active1 = ($j==0)?'active':'';
                        echo '<li data-target="#myCarousel" data-slide-to="'.$j.'" class="'.$active1.'"></li>';
                    
                        $j++;
                    }
                ?> 
              </ol>

              <!-- Wrapper for slides -->
              <div class="carousel-inner">
                  <?php
                        $i=0;  
                        foreach ($banner_info as $key => $banner){
                            $active = ($i==0)?'active':'';
                            echo '<div class="item '.$active.'">
                                    <img style="height: 740px;"src="'. base_url(BANNERS_PIC.'1/'.$banner['image_name']).'" alt="">
                                        <div class="carousel-caption">
                                          <h3>'.$banner['title'].'</h3>
                                          <p>'.$banner['desc'].'</p>
                                        </div>
                                  </div>';
                            $i++;
                        }
                  ?>
                  
                </div>
              </div>

              <!-- Left and right controls -->
              <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
              <div class="col-md-4 ">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                          <i class="fa fa-money"></i>

                          <h3 class="box-title">Your Invoice Summary</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row"> 
                                <div class="col-md-3" style="font-size: 18px; text-align: right;font-family: sans-serif">ADDED: </div>
                                <div id="last_item_name" class="col-md-9" style="font-family: sans-serif;font-size: 18px; text-align: left;"> </div>
                                <div class="col-md-12"><br> </div>
                            </div>
                            <blockquote style="background-color: #3c8dbcf2;">
                              <!--<div style="font-size: 20px; text-align: center;">GROSS TOTAL</div>-->
                              <p id="gross_amount" style="color: white;font-size: 70px;text-align: center">0.00</p>
                            </blockquote>
                            <div  class="col-md-12" style="font-size: 20px; text-align: center;">Item(s): <span id="total_items">0</span><br><br> </div>
                           
                                <table class="table table-line">
                                    <thead>
                                    </thead>
                                    <tbody id="ext_display_body">

                                    </tbody>
                                    <tfoot id="balace_footer">

                                    </tfoot>
                                </table>
                                                            
                        </div>
                        <!-- /.box-body -->
                      </div>
              </div>
    </div>
</div>
                  <!--</div>--> 