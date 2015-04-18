<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div id="login"></div>
  <div id="checkout">
  <ul class="checkout-list-steps">
    <li class="active" id="checkout-step1">
      <?php echo $text_step_1; ?>
      <span><?php echo $text_order_infor; ?></span>
    </li>
    <li id="checkout-step2">
      <?php echo $text_step_2; ?>
      <span><?php echo $text_total_and_shipping; ?></span>
    </li>
    <li id="checkout-step3">
      <?php echo $text_step_3; ?>
      <span><?php echo $text_order_confirm; ?></span>
    </li>
  </ul>

  <div class="checkout-step" id="checkout-detail-step1">
  </div>
  <div class="checkout-step" id="checkout-detail-step2">
  </div>
  <div class="checkout-step" id="checkout-detail-step3">
  </div>

  </div>
  <?php echo $content_bottom; ?></div>
  <script type="text/javascript"><!--//

  	// select step
  	function setSelectedStep(step){
      $('ul.checkout-list-steps li').removeClass('active');
      var stepSelected = '#checkout-' + step;
      $(stepSelected).addClass('active');        
    }

    // deploy step 1
  	$(document).ready(function() {
		$.ajax({
			url: 'index.php?route=checkout/step1',
			dataType: 'html',
			success: function(html) {
				$('#checkout-detail-step1').html(html);
				setSelectedStep("step1");
				$('#checkout-detail-step1').slideDown('slow');
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});	
	});	

	// go step2
	$('#btn-go-step2').live('click', function() {
		$.ajax({
			url: 'index.php?route=checkout/step1/validate',
			type: 'post',
			data: 'firstname=' + encodeURIComponent($('input[name=\'firstname\']').val()) + '&lastname=' + encodeURIComponent($('input[name=\'lastname\']').val()) + '&tel=' + encodeURIComponent($('input[name=\'tel\']').val()) + '&email=' + encodeURIComponent($('#checkout-detail-step1 input[name=\'email\']').val()) + '&address=' + encodeURIComponent($('input[name=\'address\']').val()) + '&city=' + encodeURIComponent($('select[name=\'city\']').val()) + '&street=' + encodeURIComponent($('input[name=\'street\']').val()) + '&checkout_note=' + encodeURIComponent($('textarea[name=\'checkout_note\']').val()) + '&district=' + encodeURIComponent($('input[name=\'district\']').val()) + '&ward=' + encodeURIComponent($('input[name=\'ward\']').val()),
			dataType: 'json',
			beforeSend: function() {
				$('#btn-go-step2').attr('disabled', true);
				$('#btn-go-step2').after('<span class="wait fr">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
			},	
			complete: function() {
				$('#btn-go-step2').attr('disabled', false);
				$('.wait').remove();
			},			
			success: function(json) {
				$('.warning, .error').remove();
			
				if (json['redirect']) {
					location = json['redirect'];
				} else if (json['error']) {
					if (json['error']['warning']) {
						$('#checkout-detail-step1').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
					
						$('.warning').fadeIn('slow');
					}

					if (json['error']['firstname']) {
						$('input[name=\'firstname\']').after('<span class="error">' + json['error']['firstname'] + '</span>');
					}	
					
					if (json['error']['lastname']) {
						$('input[name=\'lastname\']').after('<span class="error">' + json['error']['lastname'] + '</span>');
					}	
				
					if (json['error']['tel']) {
						$('input[name=\'tel\']').after('<span class="error">' + json['error']['tel'] + '</span>');
					}	

					if (json['error']['email']) {
						$('input[name=\'email\']').after('<span class="error">' + json['error']['email'] + '</span>');
					}		
														
					if (json['error']['address']) {
						$('input[name=\'address\']').after('<span class="error">' + json['error']['address'] + '</span>');
					}	
				
					if (json['error']['city']) {
						$('select[name=\'city\']').after('<span class="error">' + json['error']['city'] + '</span>');
					}	
				} else {
					$.ajax({
						url: 'index.php?route=checkout/step2',
						dataType: 'html',
						success: function(html) {
							$('#checkout-detail-step2').html(html);
							$('#checkout-detail-step1').hide('slow');
							setSelectedStep("step2");
							$('#checkout-detail-step2').slideDown('slow');	
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});				
				}	  
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});	
	});

	// back step1
	$('#btn-back-step1').live('click', function() {
		$('#checkout-detail-step2').hide('slow');
		setSelectedStep("step1");
		$('#checkout-detail-step1').slideDown('slow');
	});

	// go step3
	$('#btn-go-step3').live('click', function() {
		$.ajax({
			url: 'index.php?route=checkout/step2/validate',
			type: 'post',
			data: $('input[type=\'radio\']:checked'),
			dataType: 'json',
			beforeSend: function() {
				$('#btn-go-step3').attr('disabled', true);
				$('#btn-go-step3').after('<span class="wait fr">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
			},	
			complete: function() {
				$('#btn-go-step3').attr('disabled', false);
				$('.wait').remove();
			},			
			success: function(json) {
				$('.warning, .error').remove();
			
				if (json['redirect']) {
					location = json['redirect'];
				} else if (json['error']) {
					if (json['error']['warning']) {
						$('#checkout-detail-step2').prepend('<div class="warning" style="display: none;">' + json['error']['warning'] + '<img src="catalog/view/theme/default/image/close.png" alt="" class="close" /></div>');
					
						$('.warning').fadeIn('slow');
					}

					if (json['error']['shipping-method']) {
						$('#shipping-type').after('<span class="error">' + json['error']['shipping-method'] + '</span>');
					}	

					if (json['error']['payment-method']) {
						$('#payment-type').after('<span class="error">' + json['error']['payment-method'] + '</span>');
					}
				} else {
					$.ajax({
						url: 'index.php?route=checkout/step3',
						data: $('#checkout input[type=\'text\'], #checkout input[type=\'password\'], #checkout input[type=\'checkbox\']:checked, #checkout input[type=\'radio\']:checked, #checkout select'),
						dataType: 'html',
						success: function(html) {
							$('#checkout-detail-step3').html(html);
							$('#checkout-detail-step2').hide('slow');
							setSelectedStep("step3");
							$('#checkout-detail-step3').slideDown('slow');

  							$('a.open-dialog').colorbox({inline:true, width:"80%"});	
						},
						error: function(xhr, ajaxOptions, thrownError) {
							alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
						}
					});				
				}	  
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});	
	});

	// back step2
	$('#btn-back-step2').live('click', function() {
		$('#checkout-detail-step3').hide('slow');
		setSelectedStep("step2");
		$('#checkout-detail-step2').slideDown('slow');
	});

	// confirm
	$('#btn-confirm').live('click', function() {
		$.ajax({
			url: 'index.php?route=checkout/step3/confirm',
			type: 'post',
			dataType: 'json',
			beforeSend: function() {
				$('#btn-confirm').attr('disabled', true);
				$('#btn-confirm').after('<span class="wait fr">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
			},	
			complete: function() {
				$('#btn-confirm').attr('disabled', false);
				$('.wait').remove();
			},			
			success: function(json) {
				$('.warning, .error').remove();
			
				if (json['redirect']) {
					location = json['redirect'];
				}else {
					location = 'index.php?route=account/order';
				}  
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			}
		});	
	});
	
	// update cart
	$('#update-cart').live('click', function() {
		var element = $(this);
		$.ajax({
	      url: '<?php echo $updateCart; ?>&quantity=' +  encodeURIComponent($(this).parent().find('input').val()) + '&product_id=' + encodeURIComponent($(this).parent().find('input').attr('name')),
	      dataType: 'json',
	      success: function(json) {   
	        if ( json.redirect ) {
	        	this.location = json.redirect;
	        }else if ( json.status == 'success' ) {
	        	element.parent().find('input').val( json.quantity );
				element.parent().parent().find('td.total').html( json.subtotal );
	        	$('#total td.total_value').html( json.total );
	        	$('.cart-finish tbody').load('<?php echo $reloadCart; ?>');
	        	alert('<?php echo $text_update_success; ?>');
	        }
	      }
	    });
	});

  //--></script>
<?php echo $footer; ?>