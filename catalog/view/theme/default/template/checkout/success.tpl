<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="header_success">
  	<h1 id="thank_you">THANK YOU !</h1>
  	<div class="box-product-line-image"></div>
  	<p class="text_success">
  		<?php echo $text_order_success; ?>
  	</p>
  </div>
  <div class="cart_success">
  	<table width="100%">
  		<thead>
			<td><?php echo $text_order_id; ?></td>
  			<td><?php echo $text_image; ?></td>
			<td><?php echo $text_product; ?></td>
			<td><?php echo $text_model; ?></td>
			<td><?php echo $text_quantity; ?></td>
			<td><?php echo $text_price; ?></td>
			<td><?php echo $text_total; ?></td>
  		</thead>
  		<tbody>
			<?php foreach ($products as $product) { ?>
  			<tr>
  				<td class="order_id"><?php echo $order_id; ?></td>
  				<td class="product"><img src="<?php echo $product['image']; ?>" /></td>
  				<td><?php echo $product['name']; ?></td>
  				<td class="model"><?php echo $product['model']; ?></td>
  				<td class="quantity"><?php echo $product['quantity']; ?></td>
  				<td class="unit_price"><?php echo $product['price']; ?></td>
  				<td class="subtotal"><?php echo $product['subtotal'] ?></td>
  			</tr>
			<?php } ?>  
  		</tbody>
  		<tfoot>
  			<td colspan="6" style="text-align: right; padding-right: 15px;"><b><?php echo $text_total_all; ?></b></td>
  			<td><b><?php echo $total; ?></b></td>
  		</tfoot>
  	</table>
  </div>
  <div class="buttons">
      <div class="center">
      	<a href="<?php echo $home; ?>" class="button">
      		<?php echo $text_back_home; ?>
      	</a>
      </div>
    </div>
  <?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>