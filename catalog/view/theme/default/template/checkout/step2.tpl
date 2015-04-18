	<div class="popup-form">
      <div class="popup-form-title">
	<?php echo $text_total_and_shipping_method; ?>
      </div>
      <div class="popup-form-content">	
	<div class="payment-info">
	  <div class="payment-info-title" id="payment-type">
	    <?php echo $text_payment_method; ?>
	  </div>
	  <div class="payment-info-main" id="payment-getway-list">
	    <div class="payment-method">
	      <div class="payment-method-name">
		<input type="radio" name="payment-method" id="payment-method-1" value="<?php echo $text_payment_method_1; ?>" />
		<label for="payment-method-1" class="payment-label"><?php echo $text_payment_method_1; ?></label>
	      </div>
	      <div class="payment-method-description">
		<?php echo $text_payment_method_1_description; ?>
	      </div>
	    </div>
	    <div class="payment-method">
	      <div class="payment-method-name">
		<input type="radio" name="payment-method" id="payment-method-2" value="<?php echo $text_payment_method_2; ?>" />
		<label for="payment-method-2" class="payment-label"><?php echo $text_payment_method_2; ?></label>
	      </div>
	      <div class="payment-method-description">
		<?php echo $text_payment_method_2_description; ?>
	      </div>
	    </div>
	  </div>
	</div>
	<div class="payment-info">
	  <div class="payment-info-title" id="shipping-type">
	    <?php echo $text_shipping_method; ?>
	  </div>
	  <div class="payment-info-main" id="shipping-getway-list">
	  	<?php foreach ($shipping_methods as $code => $shipping_method) { ?>
	  	<div class="shipping-method">
	  		<div class="shipping-method-name">
		<input type="radio" name="shipping-method" id="shipping-method-<?php echo $code; ?>" value="<?php echo $code; ?>" />
		<label for="shipping-method-<?php echo $code; ?>" class="payment-label"><?php echo $shipping_method['title']; ?></label>
	      </div>
	      <div class="shipping-method-description">
		<?php echo $shipping_method['quote']['title']; ?>
	      </div>
	  	</div>
	  	<?php } ?>
	  </div>
	</div>
      </div>	
      <div class="popup-form-control">
	<a class="btn btn-primary fl btn-checkout" name="step1" id="btn-back-step1" >
	  <?php echo $text_back; ?>
	</a>
	<a class="btn btn-primary fr btn-checkout" name="step3" id="btn-go-step3" >
	  <?php echo $text_continue; ?>
	</a>
      </div>
    </div>
  </div> 