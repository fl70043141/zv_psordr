<div class="row"> 
    <div class="col-md-2"> 
        <input readonly id="barcode_input" type="text" class="form-control input-lg " style="width: 180px;;height: 59px;">
    </div>
    <div style="text-align: right" class="col-md-10">
        <a id="top_item_search" class="btn btn-app">
            <i class="fa fa-search"></i> Item Search
        </a>
        <a id="price_check" class="btn btn-app">
            <i class="fa fa-calculator"></i> Price Check
        </a>
        <a id="show_stock_btn"  class="btn btn-app">
            <i class="fa fa-info-circle"></i> Show Stock
        </a>
        <a id="sales_return" class="btn btn-app">
            <i class="fa fa-share"></i> Sales Return
        </a>
        <a id="return_refund_btn" class="btn btn-app">
            <i class="fa fa-retweet"></i> Return Refund
        </a>
        <a id="old_gold_add_btn" class="btn btn-app">
            <i class="fa fa-chain"></i> Old Gold
        </a>
        <a id="reserve_item" class="btn btn-app">
            <i class="fa fa-tags"></i> Reserve
        </a> 
        <a id="reserve_item_recall_btn" class="btn btn-app">
            <i class="fa fa-repeat"></i> Recall Reserve
        </a> 
        <a id="top_customer_search" class="btn btn-app" data-toggle="tooltip" data-placement="top" title="">
            <i class="fa fa-user"></i> <span id="cust_refname">Customer</span>
        </a> 
    </div>
</div>
<script>
$(document).scannerDetection({
    
  //https://github.com/kabachello/jQuery-Scanner-Detection

    timeBeforeScanTest: 200, // wait for the next character for upto 200ms
    avgTimeByChar: 40, // it's not a barcode if a character takes longer than 100ms
    endChar: [4],
  //preventDefault: true, //this would prevent text appearing in the current input field as typed 
    onComplete: function(barcode, qty){
        $('#barcode_input').focus(); 
        $('#barcode_input').val('');
        $('#barcode_input').val(barcode); 
        $('#item_code').val(barcode)
        get_item_dets_2('item_code');
//        $('#item_code').val(barcode).trigger('keyup');  
        $('#add_item_btn').trigger('click');
    }  
});  
    

</script>