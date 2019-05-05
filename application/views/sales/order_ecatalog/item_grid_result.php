
<link rel="stylesheet" href="<?php echo base_url('templates/plugins/item_grid/grid_style.css');?>">
<link rel="stylesheet" href="<?php // echo base_url('templates/plugins/infinite_scroll/infinite-scroll-docs.css?5');?>">  
<style>
    
.container--wide {
  max-width: 1370px;
  padding-left: 10px;
}

/* loader-ellips
------------------------- */

.loader-ellips {
  font-size: 20px;
  position: relative;
  width: 4em;
  height: 1em;
  margin: 10px auto;
}

.loader-ellips__dot {
  display: block;
  width: 1em;
  height: 1em;
  border-radius: 0.5em;
  background: #555;
  position: absolute;
  animation-duration: 0.5s;
  animation-timing-function: ease;
  animation-iteration-count: infinite;
}

.loader-ellips__dot:nth-child(1),
.loader-ellips__dot:nth-child(2) {
  left: 0;
}
.loader-ellips__dot:nth-child(3) { left: 1.5em; }
.loader-ellips__dot:nth-child(4) { left: 3em; }

@keyframes reveal {
  from { transform: scale(0.001); }
  to { transform: scale(1); }
}

@keyframes slide {
  to { transform: translateX(1.5em) }
}

.loader-ellips__dot:nth-child(1) {
  animation-name: reveal;
}

.loader-ellips__dot:nth-child(2),
.loader-ellips__dot:nth-child(3) {
  animation-name: slide;
}

.loader-ellips__dot:nth-child(4) {
  animation-name: reveal;
  animation-direction: reverse;
}

/* scroller
------------------------- */

.scroller {
  height: 400px;
  padding: 10px 10px 100px;
  overflow-y: scroll;
  border: 1px solid #DDD;
  border-radius: 5px;
}

.scroller__content {
}

/* ---- scroller-item ---- */

.scroller-item {
  height: 200px;
  margin-bottom: 10px;
  padding: 20px;
  background: #19F;
  border-radius: 5px;
  color: white;
  font-size: 3.0rem;
  line-height: 1;
}

.scroller-item--height2 { height: 250px; }
.scroller-item--height3 { height: 300px; }

.scroller-item--magenta { background: #C25; }
.scroller-item--red { background: #E21; }
.scroller-item--gold { background: #EA0; }
.scroller-item--green { background: #6C6; }

/* ---- prefill ---- */

.scroller--prefill { height: 500px; }

.scroller--prefill .scroller-item,
.scroller--prefill .scroller-item--height2,
.scroller--prefill .scroller-item--height3 { height: 80px; }

/* scroller-status
------------------------- */


.scroller-status {
  display: none;
  padding: 20px 0;
}

.scroller-status__message {
  text-align: center;
  color: #777;
}


/* image-grid
------------------------- */

.image-grid {
  max-width: 1370px;;
}

.image-grid__item,
.image-grid__col-sizer {
  width: 26.5%;
}

.image-grid__gutter-sizer { width: 2%; }

/* hide by default */
.image-grid.are-images-unloaded .image-grid__item {
  opacity: 0;
}

.image-grid__item {
/*  margin-bottom: 20px;
  margin-left: 20px;*/
  float: left;
}

.image-grid__image {
  /*display: block;*/
  max-width: 100%;
}
@media only screen and (max-width: 600px) {
    .thumbnail h2, .thumbnail h4, .thumbnail span , .thumbnail p{
    font-size: 10px;
}
}
@media only screen and (min-width: 800px) {
    .image-grid__item,
    .image-grid__col-sizer {
      width: 30.5%;
    }
}
</style>

<div class="main no-padding">
  <div class=" container--wide">
 

    <div class="image-grid are-images-unloaded" data-js="image-grid">
      <div class="image-grid__col-sizer col-md-12"></div>
      <div class="image-grid__gutter-sizer col-md-12"></div> 
      <div class="row no-padding">
      <?php
      
                                    if(!empty($item_res) && isset($item_res)){
                                        foreach ($item_res as $item){
//                                            echo '<pre>';print_r($item); die;
                                            echo '
                                                    <div class="item image-grid__item no-padding">
                                                        <div class="thumbnail">
                                                            <img class="group list-group-image img-bordered-sm" style="width:400px;" src="'.base_url(ITEM_IMAGES.(($item['image']!='')?$item['item_id'].'/'.$item['image']:'../default/default.jpg')).'" alt="" />
                                                            <div class="caption" >
                                                                <h4 class="group inner list-group-item-heading" style="text-align:center;"> '.$item['item_code'].' |  '.$item['item_name'].'</h4>
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-md-12">
                                                                        <p class=""  style="text-align:center;">Price '.((!empty($item['price_info']))?$item['price_info']['currency_code'].' '.$item['price_info']['price_amount']:'-').'</p>
                                                                    </div>
                                                                    <div class="col-xs-12 col-md-12 ">
                                                                        <a id="'.$item['item_id'].'_btn_view" target="_blank" href="'.base_url($this->router->fetch_class().'/view_item/'.$item['item_id'].'/'.(($category_id1!='')?$category_id1:0).'_'.$order_id.'_'.$price_type_id1.'/'.$cur_page1).'" class="itm_btn_view btn btn-default center-block "  >View</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>';
                                        }
                                    }else{
                                        echo '<div class="item image-grid__item no-padding"> 
                                                            <h4>No Results Found.</h4> 
                                                </div>';
                                    }
                                ?> 

    </div>
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
          <a class="pagination__next" href="<?php echo base_url($this->router->fetch_class().'/image_loader/'.$category_id1.'_'.$order_id.'_'.$price_type_id1.'/'.($cur_page1+1));?>">Next page</a>
      </p>
 

  </div> 
</div> 
 

<script src="<?php echo base_url('templates/plugins/infinite_scroll/infinite-scroll-docs.min.js?3');?>"></script>

<?php // $this->load->view('sales/order_ecatalog/e-catelog-modals/item_pop'); ?>