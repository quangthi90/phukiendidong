	<div class="popup-form">
      <div class="popup-form-title">
	<?php echo $text_confirm; ?>
      </div>
      <div class="popup-form-content">	
	<div class="payment-info">
	  <div class="payment-info-title" id="guest-info" >
	    <?php echo $text_user_infor; ?>
	  </div>
	  <div class="payment-info-main">
	    <table class="table-grid">
	      <tr>
		<td class="bold checkout-label" width="150"><?php echo $text_fullname; ?> </td>
		<td class="checkout-label" id="label_fullname"><?php echo $fullname; ?></td>
	      </tr>
	      <tr>
		<td class="bold checkout-label"><?php echo $text_email; ?> </td>
		<td class="checkout-label" id="label_email"><?php echo $email; ?></td>
	      </tr>
	      <tr>
		<td class="bold checkout-label"><?php echo $text_mobilephone; ?></td>
		<td class="checkout-label" id="label_tel"><?php echo $tel; ?></td>
	      </tr>
	      <tr>
		<td class="bold checkout-label"><?php echo $text_shipping_addr; ?> </td>
		<td class="checkout-label" id="label_address"><?php echo $address; ?></td>
	      </tr>
	    </table>
	  </div>
	</div>
	<div class="payment-info">
	  <div class="payment-info-title" id="payment-type2">
	    <?php echo $text_payment_method; ?>
	  </div>
	  <div class="payment-info-main" id="label_payment" style="font-size: 12px; font-weight: bold; padding-left: 20px;"><?php echo $payment_method; ?></div>
	</div>
	<div class="payment-info">
	  <div class="payment-info-title" id="shipping-type2">
	    <?php echo $text_shipping_method; ?>
	  </div>
	  <div class="payment-info-main" id="label_shipping" style="font-size: 12px; font-weight: bold; padding-left: 20px;"><?php echo $shipping_method['title']; ?></div>
	</div>
	<div class="payment-info">
	  <div class="payment-info-title" id="cart-info" style="overflow: hidden;">
	    <?php echo $text_cart_infor; ?>
	    <a class="open-dialog right" href="#cart-edit"><?php echo $text_cart_edit; ?></a>
	  </div>
	  <div class="payment-info-main">
	    <table class="cart-finish" width="100%">
	      <thead>
		<tr>
		  <th class="head" width="40">STT</th>
		  <th class="head"><?php echo $text_product; ?></th>		  
		  <th class="head" width="120"><?php echo $text_price; ?></th>
		  <th class="head" width="120"><?php echo $text_quantity; ?></th>
		  <th class="head" width="160"><?php echo $text_total; ?></th>
		</tr>
	      </thead>
	      <tbody>
	    <?php $i = 1; ?>
	    <?php foreach ($products as $product) { ?>
	    <tr>
	      <td valign="top" align="center" class="item"><?php echo $i++; ?></td>
		  <td valign="top" class="item"><?php echo $product['name']; ?></td>		  
		  <td valign="top" align="right" class="item"><?php echo $product['price']; ?></td>
		  <td valign="top" align="center" class="item"><?php echo $product['quantity']; ?></td>
		  <td valign="top" align="right" class="item"><?php echo $product['subtotal'] ?></td>
	    </tr>
	    <?php } ?>
		<tr>
		  <td align="right" class="item total-all" colspan="6"><?php echo $text_total_all; ?> = <span id="total-all"><?php echo $total; ?></span></td>
		</tr>
	      </tbody>
	    </table>
	  </div>
	</div>
      </div>      
      <div class="popup-form-control">
	<a class="btn btn-primary fl btn-checkout" name="step2" id="btn-back-step2" >
	  <?php echo $text_back;?>
	</a>
	<a class="btn btn-primary fr btn-checkout" id="btn-confirm" >
	  <?php echo $text_done; ?>
	</a>
      </div>
    </div>

    <div style="display: none">
    <div id="cart-edit">  
      <h3 class="heading-title"><?php echo $text_cart_edit; ?> </h3>
	<div class="cart-info">
	  <table>
	    <thead>
	      <tr>
		<td class="image"><?php echo $text_image; ?></td>
		<td class="name"><?php echo $text_product; ?></td>
		<td class="model"><?php echo $text_model; ?></td>
		<td class="quantity"><?php echo $text_quantity; ?></td>
		<td class="price"><?php echo $text_price; ?></td>
		<td class="total"><?php echo $text_total; ?></td>
	      </tr>
	    </thead>
	    <tbody>
	      <?php foreach ($products as $product) { ?>
	      <tr>
	      	<td class="image"><img src="<?php echo $product['image']; ?>" /></td>
	      	<td class="name"><a href="<?php echo $link_product; ?>&amp;product_id=<?php echo $product['product_id']; ?>"><?php echo $product['name']; ?></a></td>
	      	<td class="model"><?php echo $product['model']; ?></td>
	      	<td class="quantity"><input type="text" name="<?php echo $product['product_id']; ?>" value="<?php echo $product['quantity']; ?>" size="1" class="input-qty" />&nbsp;<a id="update-cart"><img src="catalog/view/theme/default/image/update.png" alt="Cập nhật" title="Cập nhật" /></a>&nbsp;<a href="<?php echo $link_cart; ?>&amp;remove=<?php echo $product['product_id']; ?>"><img src="catalog/view/theme/default/image/remove.png" alt="Loại bỏ" title="Loại bỏ"></a></td>
	      	<td class="price"><?php echo $product['price']; ?></td>
	      	<td class="total"><?php echo $product['subtotal'] ?></td>
	      </tr>
	      <?php } ?>   
	    </tbody>
	  </table>
	</div>
      <div class="cart-total">
	<table id="total">
	  <tbody>
	    <tr>
	      <td class="total_label"><?php echo $text_total; ?> ::</td>
	      <td class="total_value"><?php echo $total; ?></td>
	    </tr>
	  </tbody>
	</table>
      </div>
      <div class="buttons">
	<div class="right">
	    <button onclick="$.colorbox.close()" class="btn btn-primary" style="padding: 1px 14px;" type="button">
		<?php echo $text_continue_checkout; ?>
	    </button>
	</div>      
      </div>
    </div>
  </div>