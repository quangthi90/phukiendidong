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
		<div class="prd-label">
			<img src="http://longthu999.com/assets/images/icon_hot.gif" alt="hot" title="Nóng" />
		</div>
        <?php if ($product['thumb']) { ?>
        <div class="image"><a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
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
  </div>  
</div>
