<div class="row-fluid box">
  <div class="span3 box-catalog" style="min-height: 300px;">
	  <div class="box-catalog-heading"><?php echo $heading_title; ?></div>
	  <div class="box-content" style="padding: 1px;">
	    <div class="box-category">
	      <ul>
	        <?php foreach ($categories as $category) { ?>
	        <li><i class="icon-caret-right"></i>
	          <?php if ($category['category_id'] == $category_id) { ?>
	          <a href="<?php echo $category['href']; ?>" class="active"><?php echo $category['name']; ?></a>
	          <?php } else { ?>
	          <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
	          <?php } ?>
	          <?php if ($category['children']) { ?>
	          <ul>
	            <?php foreach ($category['children'] as $child) { ?>
	            <li><i class="icon-caret-right"></i>
	              <?php if ($child['category_id'] == $child_id) { ?>
	              <a href="<?php echo $child['href']; ?>" class="active"><?php echo $child['name']; ?></a>
	              <?php } else { ?>
	              <a href="<?php echo $child['href']; ?>"><?php echo $child['name']; ?></a>
	              <?php } ?>
	            </li>
	            <?php } ?>
	          </ul>
	          <?php } ?>
	        </li>
	        <?php } ?>
	      </ul>
	    </div>
	  </div>
  </div>
  <div class="span9" id="slideshow-category">
  <?php foreach ( $products as $product ){ ?>    
    <div class="slide-item">
      <div class="slide-image fl">
		<a href="<?php echo $product['href']; ?>">
		  <img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />
		</a>
      </div>
      <div class="slide-detail fr">
		<a href="<?php echo $product['href']; ?>" class="slide-product-name">
		  <?php echo $product['name']; ?>
		</a>
        <div class="slide-product-info">
        <?php if ($product['meta_description']){ ?>
        	<ul style="list-style-type: disc; margin-left: 25px;">
            <?php foreach (unserialize(str_replace('\\', '', $product['meta_description'])) as $meta_description) { ?>
            	<li><?php echo $meta_description; ?></li>
            <?php } ?>
            </ul>
        <?php } ?>
        </div>
		<div class="slide-product-price">
		  <span>Giá bán: </span>
		  <span class="price">
		  <?php if ( isset($product['special']) && !empty($product['special']) ){ ?>
		  	<?php echo $product['special']; ?>
		  <?php }else{ ?>
		  	<?php echo $product['price']; ?>
		  <?php } ?>
		  </span>
		</div>
		<a onclick="addToCart('<?php echo $product['product_id']; ?>');" class="slide-product-addtocart">
		  Thêm vào giỏ
		</a>
      </div>
    </div>
  <?php } ?>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {  
    $('#slideshow-category').cycle({ 
      fx:     'scrollDown', 
      speed:  1000, 
      timeout: 5000
    });
  });
</script>