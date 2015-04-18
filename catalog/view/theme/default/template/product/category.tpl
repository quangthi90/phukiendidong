<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
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
  <?php if ($products) { ?>
  <div class="row-fluid box">
	<div class="box-hl"></div>
	<div class="box-hr"></div>
	<div class="box-heading"><?php echo $heading_title; ?></div>
	<div class="box-content">
  		<div class="box-product">
  			<?php foreach ($products as $i => $product) { ?>
      <?php if ( $i % 3 == 0 ) {?>
      <div class="row-fluid">
      <?php } ?>
      <div class="span4">
		<?php if ( $product['label_image'] != null && $product['label_title'] ){ ?>
		<div class="prd-label">
			<img src="<?php echo $product['label_image']; ?>" title="<?php echo $product['label_title']; ?>" />
		</div>
		<?php } ?>
        <?php if ($product['thumb']) { ?>
        <div class="image"><a href="<?php echo $product['href']; ?>" rel="popover" data-title="<?php echo $product['name'] . ' [' . $product['price'] . ']'; ?>" data-content="<?php if (isset($product['meta_description']) && $product['meta_description']) {?> <span>Tính năng nổi bật</span><ul><?php foreach (unserialize(str_replace('\\', '', $product['meta_description'])) as $meta_description) { echo '<li>' . $meta_description . "</li>"; } ?></ul><?php } ?>" data-trigger="hover" data-placement="<?php echo (($i + 1) % 3 == 0) ? 'left' : 'right' ?>" html><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
        <?php } ?>
	<div class="info-container">
	  <div class="name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
	  <?php if ($product['price']) { ?>
	    <?php if (!$product['special']) { ?>
	      <div class="price"> 
		<?php echo $product['price']; ?>
	      </div>
	    <?php } else { ?>
	      <div class="price-old">
	       <?php echo $product['price']; ?>
	      </div>
	      <div class="price">
		<?php echo $product['special']; ?>
	      </div>
	    <?php } ?>
	  <?php } ?>
	</div>                
      </div>
      <?php if ( ($i + 1) % 3 == 0 || $i == (count($products) - 1) ){?>
      </div>
      <?php } ?>
      <?php } ?>
		</div>
		<div class="pagination"><?php echo $pagination; ?></div>
	</div>	
  </div>
  <?php } ?>
  <?php if (!$categories && !$products) { ?>
  <div class="content"><?php echo $text_empty; ?></div>
  <div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
  </div>
  <?php } ?>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript">
    $(function () {
      $('[rel=\'popover\']').popover();
    });
  </script>
<script type="text/javascript"><!--
function display(view) {
	if (view == 'list') {
		$('.product-grid').attr('class', 'product-list');
		
		$('.product-list > div').each(function(index, element) {
			html  = '<div class="right">';
			html += '  <div class="cart">' + $(element).find('.cart').html() + '</div>';
			html += '  <div class="wishlist">' + $(element).find('.wishlist').html() + '</div>';
			html += '  <div class="compare">' + $(element).find('.compare').html() + '</div>';
			html += '</div>';			
			
			html += '<div class="left">';
			
			var image = $(element).find('.image').html();
			
			if (image != null) { 
				html += '<div class="image">' + image + '</div>';
			}
			
			var price = $(element).find('.price').html();
			
			if (price != null) {
				html += '<div class="price">' + price  + '</div>';
			}
					
			html += '  <div class="name">' + $(element).find('.name').html() + '</div>';
			html += '  <div class="description">' + $(element).find('.description').html() + '</div>';
			
			var rating = $(element).find('.rating').html();
			
			if (rating != null) {
				html += '<div class="rating">' + rating + '</div>';
			}
				
			html += '</div>';

						
			$(element).html(html);
		});		
		
		$('.display').html('<b><?php echo $text_display; ?></b> <?php echo $text_list; ?> <b>/</b> <a onclick="display(\'grid\');"><?php echo $text_grid; ?></a>');
		
		$.cookie('display', 'list'); 
	} else {
		$('.product-list').attr('class', 'product-grid');
		
		$('.product-grid > div').each(function(index, element) {
			html = '';
			
			var image = $(element).find('.image').html();
			
			if (image != null) {
				html += '<div class="image">' + image + '</div>';
			}
			
			html += '<div class="name">' + $(element).find('.name').html() + '</div>';
			html += '<div class="description">' + $(element).find('.description').html() + '</div>';
			
			var price = $(element).find('.price').html();
			
			if (price != null) {
				html += '<div class="price">' + price  + '</div>';
			}
			
			var rating = $(element).find('.rating').html();
			
			if (rating != null) {
				html += '<div class="rating">' + rating + '</div>';
			}
						
			html += '<div class="cart">' + $(element).find('.cart').html() + '</div>';
			html += '<div class="wishlist">' + $(element).find('.wishlist').html() + '</div>';
			html += '<div class="compare">' + $(element).find('.compare').html() + '</div>';
			
			$(element).html(html);
		});	
					
		$('.display').html('<b><?php echo $text_display; ?></b> <a onclick="display(\'list\');"><?php echo $text_list; ?></a> <b>/</b> <?php echo $text_grid; ?>');
		
		$.cookie('display', 'grid');
	}
}

view = $.cookie('display');

if (view) {
	display(view);
} else {
	display('list');
}
//--></script> 
<?php echo $footer; ?>