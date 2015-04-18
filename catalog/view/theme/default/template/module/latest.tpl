
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
        <?php if ($product['special']){ ?>
        <?php $price = $product['special']; ?>
        <?php }else{ ?>
        <?php $price = $product['price']; ?>
        <?php } ?>
        <div class="image"><a href="<?php echo $product['href']; ?>" rel="popover" data-title="<?php echo $product['name'] . ' [' . $price . ']'; ?>" data-content="<?php if (isset($product['meta_description']) && $product['meta_description']) {?> <span>Tính năng nổi bật</span><ul><?php foreach (unserialize(str_replace('\\', '', $product['meta_description'])) as $meta_description) { echo '<li>' . $meta_description . "</li>"; } ?></ul><?php } ?>" data-trigger="hover" data-placement="<?php echo (($i + 1) % 3 == 0) ? 'left' : 'right' ?>" html><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" /></a></div>
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
  <script type="text/javascript">
    $(function () {
      $('[rel=\'popover\']').popover();
    });
  </script>
</div>
