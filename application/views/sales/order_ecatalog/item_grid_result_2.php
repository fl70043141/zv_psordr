
<link rel="stylesheet" href="<?php echo base_url('templates/plugins/item_grid/grid_style.css');?>">
<?php // echo '<pre>'; print_r($item_res); die;?>
<style>
    .glyphicon { margin-right:5px; }
    .thumbnail
    {
        margin-bottom: 20px;
        padding: 0px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }

    .item.list-group-item
    {
        float: none;
        width: 100%;
        background-color: #fff;
        margin-bottom: 10px;
    }
    .item.list-group-item:nth-of-type(odd):hover,.item.list-group-item:hover
    {
        background: #428bca;
    }

    .item.list-group-item .list-group-image
    {
        margin-right: 10px;
    }
    .item.list-group-item .thumbnail
    {
        margin-bottom: 0px;
    }
    .item.list-group-item .caption
    {
        padding: 9px 9px 0px 9px;
    }
    .item.list-group-item:nth-of-type(odd)
    {
        background: #eeeeee;
    }

    .item.list-group-item:before, .item.list-group-item:after
    {
        display: table;
        content: " ";
    }

    .item.list-group-item img
    {
        float: left;
    }
    .item.list-group-item:after
    {
        clear: both;
    }
    .list-group-item-text
    {
        margin: 0 0 11px;
    }

</style>

<div class="row">
<div class="col-md-12"> 
<!-- <br><hr>-->
    <section  class="content">  
         
            <div class="box-body row">
                <div id="result_search"> 
                        <div class="container1">
                            <div class="well well-sm">
                                <strong>Category Title</strong>
                                <div class="btn-group">
                                    <a href="#" id="list" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-th-list">
                                    </span>List</a> <a href="#" id="grid" class="btn btn-default btn-sm"><span
                                        class="glyphicon glyphicon-th"></span>Grid</a>
                                </div>
                            </div>
                            <div id="products" class="row list-group container--wide">
                                
                            <div class="image-grid are-images-unloaded" data-js="image-grid">
                              <div class="image-grid__col-sizer"></div>
                              <div class="image-grid__gutter-sizer"></div>
                                
                                <?php
                                    if(!empty($item_res)){
                                        foreach ($item_res as $item){
//                                            echo '<pre>';print_r($item); die;
                                            echo '
                                                    <div class="item  col-xs-4 col-lg-4 image-grid__item">
                                                        <div class="thumbnail">
                                                            <img class="group list-group-image img-bordered-sm" style="width:400px;" src="'.base_url(ITEM_IMAGES.(($item['image']!='')?$item['id'].'/'.$item['image']:'../default/default.jpg')).'" alt="" />
                                                            <div class="caption" >
                                                                <h4 class="group inner list-group-item-heading" style="text-align:center;"> '.$item['item_code'].' |  '.$item['item_name'].'</h4>
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-md-12">
                                                                        <p class=""  style="text-align:center;">Price '.((!empty($item['price_info']))?$item['price_info']['currency_code'].' '.$item['price_info']['price_amount']:'-').'</p>
                                                                    </div>
                                                                    <div class="col-xs-12 col-md-12 ">
                                                                        <a id="'.$item['id'].'_btn_view" class="itm_btn_view btn btn-default center-block "  ><span class="fa fa-eye"></span> View</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';
                                        }
                                    }
                                ?> 
                                </div>
                                
                                
                                <div class="scroller-status">
                                  <div class="loader-ellips infinite-scroll-request">
                                    <span class="loader-ellips__dot"></span>
                                    <span class="loader-ellips__dot"></span>
                                    <span class="loader-ellips__dot"></span>
                                    <span class="loader-ellips__dot"></span>
                                  </div>
                                  <p class="scroller-status__message infinite-scroll-last">End of content</p>
                                  <p class="scroller-status__message infinite-scroll-error">No more pages to load</p>
                                </div>

                                <p class="pagination">
                                  <a class="pagination__next" href="<?php echo base_url($this->router->fetch_class().'/image_loader/1');?>">Next page</a>
                                </p>
 
                            </div>
                        </div> 
            </div>
            
          </div>
       
    </section>              
   
     </div>
</div> 

<?php $this->load->view('sales/order_ecatalog/e-catelog-modals/item_pop'); ?>

  <script src="http://localhost/infinite-scroll-docs/js/infinite-scroll-docs.min.js?3"></script>
<script>
    $(document).ready(function(){  
        $('#list').click(function(event){event.preventDefault();$('#products .item').addClass('list-group-item');});
        $('#grid').click(function(event){event.preventDefault();$('#products .item').removeClass('list-group-item');$('#products .item').addClass('grid-group-item');});
    }); 
</script>
 