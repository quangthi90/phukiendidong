<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div class="advertisement"></div>
<div id="content"><?php echo $content_top; ?>
    <div class="my-breadcrumb">
        <div class="span7">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <div class="breadcrumb-box">
                    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                </div>
                <div class="breadcrumb-arrow"></div>
            <?php } ?>
        </div>
        <div class="span4" style="float: right; text-align: right; padding-right: 10px;">
            <form class="form-search" method="GET">
                <div class="input-append" style="padding-top: 2px;">
                    <input type="hidden" name="route" value="product/search"/>
                    <input name="filter_name" type="text" class="span2 search-query" style="width: 150px;" />
                    <button type="submit" class="btn button-search" style=" border-radius: 0 14px 14px 0; margin-left: -4px;"><i class="icon-search" style="font-size: 18px;"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!--div class="my-breadcrumb category-quicklink">
        <div class="list-product-category fl">
            <span class="header-list-product-category">Danh mục sản phẩm</span>
            <ul>
                <li>
                    <a href="#">Máy tính</a>
                </li>
                <li>
                    <a href="#">Điện thoại</a>
                </li>
                <li>
                    <a href="#">Dụng cụ thể thao</a>
                </li>
            </ul>
        </div>
        <div class="product-links fr">
            <a href="#">Sản phẩm đang bán</a>
            <span class="separator-links">|</span> 
            <a href="#"> Sản phẩm đã bán </a>
        </div>
    </div-->
    <div class="row-fluid product-info">
        <?php if ($thumb || $images) { ?>
            <div class="span6">
                <?php if ($thumb) { ?>
                    <div class="image">
                        <a href="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" class="colorbox" rel="colorbox">
                            <img src="<?php echo $thumb; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" id="image" />
                        </a>
                        <div class="box-product-line-image"></div>
                        <?php if ($images) { ?>
                            <div class="image-additional">
                                <?php foreach ($images as $image) { ?>
                                    <a href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" class="colorbox" rel="colorbox"><img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="span6">
            <h1 class="product-heading"><?php echo $heading_title; ?></h1>
            <?php if ($review_status) { ?>
                <div class="review clearfix">
                    <div class="span3">
                        <img src="catalog/view/theme/default/image/stars-<?php echo $rating; ?>.png" alt="<?php echo $reviews; ?>" />
                    </div>
                    <div class="share span5 offset4"><!-- AddThis Button BEGIN -->
                        <div class="addthis_default_style"><a class="addthis_button_compact"><?php echo $text_share; ?></a> <a class="addthis_button_email"></a><a class="addthis_button_print"></a> <a class="addthis_button_facebook"></a> <a class="addthis_button_twitter"></a></div>
                        <script type="text/javascript" src="//s7.addthis.com/js/250/addthis_widget.js"></script> 
                        <!-- AddThis Button END --> 
                    </div>
                </div>
            <?php } ?>      
            <div class="price"> 
                <?php if ($special) { ?>      
                <div class="price-old-product">
                    <span><?php echo $text_real_price; ?>: </span>
                    <span class="pr-value"><?php if ($price) echo $price; ?></span>
                </div>
                <?php } ?>
                <div class="best-price-product">
                    <span class="pr-value"><?php if ($special) echo $special; else echo $price; ?></span>
                    <!--<span class="price-spelling">(một triệu đồng)</span>//-->
                </div>
            </div>
            <?php if ($product_info['meta_description']){ ?>
            <div class="description">
                <ul>
                <?php foreach (unserialize(str_replace('\\', '', $product_info['meta_description'])) as $meta_description) { ?>
                    <li><?php echo $meta_description; ?></li>
                <?php } ?>
                </ul>
            </div>
            <?php } ?>
            <div class="cart">
                <input type="hidden" class="product_info" name="product_id" size="2" value="<?php echo $product_id; ?>" />
                <?php if(isset($error_empty)) { ?>
                <div class="warning" style="width: 400px;"><?php echo $error_empty; ?></div>
                <?php }else { ?>
                <span><?php echo $text_quality; ?>:</span>
                <input type="text" class="product_info" id="quantity" name="quantity" size="2" value="<?php echo $minimum; ?>" />                    
                <input type="button" id="button-cart" value="<?php echo $button_cart; ?>" class="btn btn-primary" style="margin-top: -10px;" />  
                <?php } ?>     
            </div>
        </div>
    </div>
    <div id="tabs" class="htabs"><a href="#tab-description"><?php echo $tab_description; ?></a>
        <?php if ($attribute_groups) { ?>
            <a href="#tab-attribute"><?php echo $tab_attribute; ?></a>
        <?php } ?>        
        <?php if ($products) { ?>
            <a href="#tab-related"><?php echo $tab_related; ?> (<?php echo count($products); ?>)</a>
        <?php } ?>
    </div>
    <div id="tab-description" class="tab-content"><?php echo $description; ?></div>
    <?php if ($attribute_groups) { ?>
        <div id="tab-attribute" class="tab-content">
            <table class="attribute">
                <?php foreach ($attribute_groups as $attribute_group) { ?>
                    <thead>
                        <tr>
                            <td colspan="2"><?php echo $attribute_group['name']; ?></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                            <tr>
                                <td><?php echo $attribute['name']; ?></td>
                                <td><?php echo nl2br($attribute['text']); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                <?php } ?>
            </table>
        </div>
    <?php } ?>    
    <?php if ($products) { ?>
        <div id="tab-related" class="tab-content">
            <div class="box-product">
                <?php foreach ($products as $product) { ?>
                    <div class="product_rel fl">
                        <?php if ($product['thumb']) { ?>
                            <p class="image_rel"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></p>
                        <?php } ?>
                        <p class="name_rel"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></p>
                        <?php if ($product['price']) { ?>
                            <div class="price_rel">
                                <?php if (!$product['special']) { ?>
                                    <?php echo $product['price']; ?>
                                <?php } else { ?>
                                    <span class="price-old-rel"><?php echo $product['price']; ?></span> - <span class="price-new-rel"><?php echo $product['special']; ?></span>
                                <?php } ?>
                            </div>
                        <?php } ?>        
                        <p style="text-align: center;">
                            <a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="btn btn-primary"><?php echo $button_cart; ?> </a>
                        </p>
                    </div>
                <?php } ?>		
            </div>
        </div>
    <?php } ?>
    <?php if ($review_status) { ?>
        <h2 id="review-title"><?php echo $text_write; ?></h2>
        <div id="tab-review" class="tab-content">            
            <div id="review">
                <!-- List reviews -->
            </div>            
            <br />
            <b><?php echo $entry_review; ?></b>
            <textarea name="text" cols="40" rows="8" style="width: 98%;"></textarea>
            <span style="font-size: 11px;"><?php echo $text_note; ?></span><br />
            <br />
            <!--
            <b><?php echo $entry_rating; ?></b> <span><?php echo $entry_bad; ?></span>&nbsp;
            <input type="radio" name="rating" value="1" />
            &nbsp;
            <input type="radio" name="rating" value="2" />
            &nbsp;
            <input type="radio" name="rating" value="3" />
            &nbsp;
            <input type="radio" name="rating" value="4" />
            &nbsp;
            <input type="radio" name="rating" value="5" />
            &nbsp;<span><?php echo $entry_good; ?></span><br />
            <br />
            //-->
            <input type="hidden" name="rating" value="5" />
            <div class="row-fluid">
                <div class="span6">
                    <div class="row-fluid">
                        <div class="span3">
                        <b><?php echo $entry_rating; ?></b> <span><?php echo $entry_bad; ?></span>
                        </div>
                        <div class="span3"><div id="rate" class="rating"></div></div>
                        <div class="span2"><span><?php echo $entry_good; ?></span></div>
                    </div>
                </div>
            </div>          
            <b><?php echo $entry_captcha; ?></b><br />
            <input type="text" name="captcha" value="" />
            <br />
            <img src="index.php?route=product/product/captcha" alt="" id="captcha" /><br />
            <br />
            <div class="buttons">
                <div class="right">
                    <a id="button-review" class="btn btn-primary" style="padding: 2px 12px;"><?php echo $button_continue; ?></a>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($tags) { ?>
        <div class="tags"><b><?php echo $text_tags; ?></b>
            <?php for ($i = 0; $i < count($tags); $i++) { ?>
                <?php if ($i < (count($tags) - 1)) { ?>
                    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>,
                <?php } else { ?>
                    <a href="<?php echo $tags[$i]['href']; ?>"><?php echo $tags[$i]['tag']; ?></a>
                <?php } ?>
            <?php } ?>
        </div>
    <?php } ?>
    <?php echo $content_bottom; ?></div>
<script type="text/javascript"><!--
    $('.colorbox').colorbox({
        overlayClose: true,
        opacity: 0.5
    });
    //--></script> 
<script type="text/javascript"><!--
    $('#button-cart').bind('click', function() {
        $.ajax({
            url: 'index.php?route=checkout/cart/add',
            type: 'post',
            data: $('.product-info input[type=\'text\'], .product-info input[type=\'hidden\'], .product-info input[type=\'radio\']:checked, .product-info input[type=\'checkbox\']:checked, .product-info select, .product-info textarea'),
            dataType: 'json',
            success: function(json) {
                $('.success, .warning, .attention, information, .error').remove();
			
                if (json['error']) {
                    if (json['error']['option']) {
                        for (i in json['error']['option']) {
                            $('#option-' + i).after('<span class="error">' + json['error']['option'][i] + '</span>');
                        }
                    }
                } 
			
                if (json['success']) {
                    $('#notification').html('<div class="success" style="display: none;">' + json['success'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
					
                    $('.success').fadeIn('slow');
					
                    $('#cart-total').html(json['total']);
				
                    $('html, body').animate({ scrollTop: 0 }, 'slow'); 
                }	
            }
        });
    });

    $('#quick-view-cart').live('mouseover', function() {
        $('#cart').addClass('active');
        
        $('#cart').load('index.php?route=module/cart #cart > *');
        
        $('#cart').live('mouseleave', function() {
            $(this).removeClass('active');
        });
    });
//-></script>
<?php if ($options) { ?>
    <script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script>
    <?php foreach ($options as $option) { ?>
        <?php if ($option['type'] == 'file') { ?>
            <script type="text/javascript"><!--
            	if ($.('input#logged').val() == 1){
	                new AjaxUpload('#button-option-<?php echo $option['product_option_id']; ?>', {
	                    action: 'index.php?route=product/product/upload',
	                    name: 'file',
	                    autoSubmit: true,
	                    responseType: 'json',
	                    onSubmit: function(file, extension) {
	                        $('#button-option-<?php echo $option['product_option_id']; ?>').after('<img src="catalog/view/theme/default/image/loading.gif" class="loading" style="padding-left: 5px;" />');
	                        $('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', true);
	                    },
	                    onComplete: function(file, json) {
	                        $('#button-option-<?php echo $option['product_option_id']; ?>').attr('disabled', false);
	            		
	                        $('.error').remove();
	            		
	                        if (json['success']) {
	                            alert(json['success']);
	            			
	                            $('input[name=\'option[<?php echo $option['product_option_id']; ?>]\']').attr('value', json['file']);
	                        }
	            		
	                        if (json['error']) {
	                            $('#option-<?php echo $option['product_option_id']; ?>').after('<span class="error">' + json['error'] + '</span>');
	                        }
	            		
	                        $('.loading').remove();	
	                    }
	                });
            	}else{
                	alert("Bạn phải đăng nhập trước khi đăng nhận xét");
            	}
                //--></script>
        <?php } ?>
    <?php } ?>
<?php } ?>
<script type="text/javascript">
    var count = 0;
    $(document).ready(function (){
        setActiveImage();
    });
    
    function setActiveImage(){
        var listImages = $('.image-additional a.colorbox');        
        if(listImages != null && listImages.length > 1){            
            for(var index = 0; index < listImages.length ; index ++){
                $(listImages[index]).children('img:first').css('border-color','#ddd');
            }
            $(listImages[count]).children('img:first').css('border-color','#29547F');
            $('#image').fadeOut().attr('src',listImages[count]).fadeIn('slow');
            count ++;
            if(count == listImages.length){
                count = 0;
            }            
            setTimeout('setActiveImage()',5000);
        }        
    }
    
    $('#tabs a').tabs();    
    $('#review .pagination a').live('click', function() {
        $('#review').fadeOut('slow');
		
        $('#review').load(this.href);
	
        $('#review').fadeIn('slow');
	
        return false;
    });			

    $('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');
    $('#button-review').bind('click', function() {
        $.ajax({
            url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
            type: 'post',
            dataType: 'json',
            data: 'name=' + encodeURIComponent($('input[name=\'name\']').val()) + '&text=' + encodeURIComponent($('textarea[name=\'text\']').val()) + '&rating=' + encodeURIComponent($('input[name=\'rating\']').val() ? $('input[name=\'rating\']').val() : '') + '&captcha=' + encodeURIComponent($('input[name=\'captcha\']').val()),
            beforeSend: function() {
                $('.success, .warning').remove();
                $('#button-review').attr('disabled', true);
                $('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
            },
            complete: function() {
                $('#button-review').attr('disabled', false);
                $('.attention').remove();
            },
            success: function(data) {
                if (data['error']) {
                    $('#review-title').after('<div class="warning">' + data['error'] + '</div>');
                }
			
                if (data['success']) {
                	$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');
                    $('#review-title').after('<div class="success">' + data['success'] + '</div>');
								
                    $('input[name=\'name\']').val('');
                    $('textarea[name=\'text\']').val('');
                    $('input[name=\'rating\']').val('');
                    $('input[name=\'captcha\']').val('');
                }
            }
        });
    });
</script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-timepicker-addon.js"></script> 
<script type="text/javascript" src="catalog/view/javascript/jquery/jquery.rating.js"></script>
            <script type="text/javascript"><!--
                $("#rate").rating("index.php?route=product/product/write&product_id=<?php echo $product_id; ?>", {maxvalue:5, curvalue:5});
                /**$(".star").each(
                    html('<img src="catalog/view/theme/default/image/stars-' + $(this).html() + '.png" />');
                    );**/
            //--></script> 
<script type="text/javascript">
    if ($.browser.msie && $.browser.version == 6) {
        $('.date, .datetime, .time').bgIframe();
    }

    $('.date').datepicker({dateFormat: 'yy-mm-dd'});
    $('.datetime').datetimepicker({
        dateFormat: 'yy-mm-dd',
        timeFormat: 'h:m'
    });
    $('.time').timepicker({timeFormat: 'h:m'});
</script> 
<?php echo $footer; ?>