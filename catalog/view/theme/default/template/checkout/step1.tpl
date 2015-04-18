<div class="popup-form">
      <div class="popup-form-title">
	<?php echo $text_order_detail; ?>
      </div>
      <div class="popup-form-content">
	<div class="payment-info">
	  <div class="payment-info-title" id="billing-info1">
	    <?php echo $text_billing_infor; ?>
	  </div>
	  <div class="payment-info-main">
	    <table cellpadding="3" cellspacing="0" border="0">
	      <tbody>
		<tr>
		  <td width="100" class="bold"><?php echo $text_firstname; ?></td>
		  <td><input type="text" id="cart_firstname" name="firstname" value="<?php echo $firstname; ?>" /></td>
		</tr>
		<tr>
		  <td width="100" class="bold"><?php echo $text_lastname; ?></td>
		  <td><input type="text" id="cart_lastname" name="lastname" value="<?php echo $lastname; ?>" /></td>
		</tr>
		<tr>
		  <td class="bold"><?php echo $text_mobilephone; ?></td>
		  <td><input type="text" id="cart_tel" name="tel" value="<?php echo $tel; ?>" maxlength="20" /></td>
		</tr>
		<tr>
		  <td class="bold"><?php echo $text_email; ?></td>
		  <td><input type="text" id="cart_email" name="email" value="<?php echo $email; ?>" /></td>
		</tr></tbody>
	    </table>
	  </div>
	</div>
	<div class="payment-info">	
	  <div class="payment-info-title" id="billing-info2">
	    <?php echo $text_billing_infor2; ?>
	  </div>
	  <div class="payment-info-main">
	    <table cellpadding="3" cellspacing="0" border="0">
	      <tbody>
		<tr>
		  <td width="100" class="bold"><?php echo $text_address; ?></td>
		  <td><input type="text" id="cart_address" name="address" value="<?php echo $address; ?>">
		  </td>
		</tr>
		<tr>
		  <td class="bold"><?php echo $text_province; ?></td>
		  <td>
		    <select name="city" id="cart_city">
		    <option value="0"><?php echo $text_choose_province; ?></option>		      
			<?php foreach ($zones as $zone) { ?>
			<option value="<?php echo $zone['zone_id']; ?>" <?php if ($zone['zone_id'] == $city) echo 'selected="selected"'; ?> ><?php echo $zone['name']; ?></option>
			<?php } ?>	
			</select>	      
		  </td>
		</tr>
	      </tbody>
	    </table>
	  </div>
	</div>
	<div class="payment-info">	
	  <div class="payment-info-title" id="billing-note">
	    <?php echo $text_note; ?>
	  </div>
	  <div class="payment-info-main">
	    <textarea class="checkout-note" name="checkout_note" value="<?php echo $checkout_note; ?>"></textarea>
	  </div>
	</div>
      </div>
      <div class="popup-form-control">
	<a class="btn btn-primary fr btn-checkout" id="btn-go-step2">
	  <?php echo $text_continue; ?>
	</a>
      </div>
    </div>