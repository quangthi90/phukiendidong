<?php echo $header; ?>
<div id="content">
    <?php echo $content_top; ?>
   <div class="my-breadcrumb">
        <div class="span7">
            <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <div class="breadcrumb-box">
                    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                </div>
                <div class="breadcrumb-arrow"></div>
            <?php } ?>
        </div>
  </div>
  <h3 class="heading-title"><?php echo $heading_title; ?></h3>
    <?php if ($error_warning) { ?>
        <div class="warning"><?php echo $error_warning; ?></div>
    <?php } ?>
  <p class="loginwithpass"><?php echo $text_account_already; ?></p>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
    <h4 class="heading-title-l2"><?php echo $text_your_password; ?></h4>
    <div class="content">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_email; ?></td>
          <td><input type="text" name="email" value="<?php echo $email; ?>" onblur="validateEmail(this);" />
            <?php if ($error_email) { ?>
            <span class="error"><?php echo $error_email; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_password; ?></td>
          <td><input type="password" name="password" value="<?php echo $password; ?>" />
            <?php if ($error_password) { ?>
            <span class="error"><?php echo $error_password; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_confirm; ?></td>
          <td><input type="password" name="confirm" value="<?php echo $confirm; ?>" />
            <?php if ($error_confirm) { ?>
            <span class="error"><?php echo $error_confirm; ?></span>
            <?php } ?></td>
        </tr>
      </table>
    </div>
    <h4 class="heading-title-l2"><?php echo $text_your_details; ?></h4>
    <div class="content">
      <table class="form">      
        <tr>
          <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
          <td><input type="text" name="firstname" value="<?php echo $firstname; ?>" />
            <?php if ($error_firstname) { ?>
            <span class="error"><?php echo $error_firstname; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
          <td><input type="text" name="lastname" value="<?php echo $lastname; ?>" />
            <?php if ($error_lastname) { ?>
            <span class="error"><?php echo $error_lastname; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_sex; ?></td>
          <td>
            <select name="sex">
              <?php if ($sex == 1) { ?>
                <option value="0"><?php echo $text_male; ?></option>
                <option value="1" selected="selected"><?php echo $text_female; ?></option>
                <option value="2"><?php echo $text_other; ?></option>
              <?php }elseif($sex == 2) { ?>
                <option value="0"><?php echo $text_male; ?></option>
                <option value="1"><?php echo $text_female; ?></option>
                <option value="2" selected="selected"><?php echo $text_other; ?></option>
              <?php }else { ?>
                <option value="0" selected="selected"><?php echo $text_male; ?></option>
                <option value="1"><?php echo $text_female; ?></option>
                <option value="2"><?php echo $text_other; ?></option>
              <?php } ?>
            </select>
          </td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_birthday; ?></td>
          <td><input type="text" name="birthday" class="calendarFocus" id="birthday" value="<?php echo $birthday; ?>" /></td>
        </tr>
      </table>
    </div>
    <h4 class="heading-title-l2"><?php echo $text_your_address; ?></h4>
    <div class="content">
      <table class="form">
         <tr>
          <td><?php echo $entry_telephone; ?></td>
          <td><input type="text" name="telephone" value="<?php echo $telephone; ?>" /></td>
        </tr>
        <tr>
          <td><?php echo $entry_address; ?></td>
          <td><input type="text" name="address" value="<?php echo $address; ?>" /></td>
        </tr>
      </table>
    </div>    
    <h4 class="heading-title-l2"><?php echo $text_newsletter; ?></h4>
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_newsletter; ?></td>
          <td>
          <?php if ($newsletter) { ?>
                <span class="radio_field">
                    <input id="newsletter_yes" type="radio" name="newsletter" value="1" checked="checked" />
                    <label for="newsletter_yes" class=="label_newsletter"><?php echo $text_yes; ?></label>
                </span>
                <span class="radio_field">
                    <input id="newsletter_no" type="radio" name="newsletter" value="0" />
                    <label for="newsletter_no" class=="label_newsletter"><?php echo $text_no; ?></label>
                </span>            
            <?php } else { ?>
                <span class="radio_field">
                    <input id="newsletter_yes" type="radio" name="newsletter" value="1" />
                    <label for="newsletter_yes" class=="label_newsletter"><?php echo $text_yes; ?></label>
                </span>
                <span class="radio_field">
                    <input id="newsletter_no" type="radio" name="newsletter" value="0" checked="checked" />
                    <label for="newsletter_no" class=="label_newsletter"><?php echo $text_no; ?></label>
                </span>  
            <?php } ?>
            </td>
        </tr>
      </table>
    </div>
    <?php if ($text_agree) { ?>
    <div class="buttons">
      <div class="right"><?php echo $text_agree; ?>
        <?php if ($agree) { ?>
        <input type="checkbox" name="agree" value="1" checked="checked" />
        <?php } else { ?>
        <input type="checkbox" name="agree" value="1" />
        <?php } ?>
        <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" style="height: 30px; padding: 1px 14px;" />
      </div>
    </div>
    <?php } else { ?>
    <div class="buttons">
      <div class="right">
        <input type="submit" value="<?php echo $button_continue; ?>" class="btn btn-primary" style="height: 30px; padding: 1px 14px;" />
      </div>
    </div>
    <?php } ?>
  </form>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript">
  function validateEmail(element) {
    $.ajax({
      url: 'index.php?route=account/register/validateemail&email=' +  $(element).val(),
      dataType: 'json',
      success: function(json) {
        $.map(json, function(item) {
          if (item.status) {
            $('#validateemail').remove();
            if (item.status == 'error') {
              $(element).after('<div id="validateemail" class="alert alert-error">' + item.message + '</div>');
            }else {
              $(element).after('<div id="validateemail" class="alert alert-success">' + item.message + '</div>');
            }
          }
        });
      }
    });
    
  }
</script>
<script type="text/javascript" src="catalog/view/javascript/jquery/jcalendar/jcalendar.min.js"></script> 
<script type="text/javascript"><!--
$(function () {
$("#birthday").calendar();
});
//--></script> 
<script type="text/javascript"><!--
$('select[name=\'customer_group_id\']').live('change', function() {
	var customer_group = [];
	
<?php foreach ($customer_groups as $customer_group) { ?>
	customer_group[<?php echo $customer_group['customer_group_id']; ?>] = [];
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_display'] = '<?php echo $customer_group['company_id_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['company_id_required'] = '<?php echo $customer_group['company_id_required']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_display'] = '<?php echo $customer_group['tax_id_display']; ?>';
	customer_group[<?php echo $customer_group['customer_group_id']; ?>]['tax_id_required'] = '<?php echo $customer_group['tax_id_required']; ?>';
<?php } ?>	

	if (customer_group[this.value]) {
		if (customer_group[this.value]['company_id_display'] == '1') {
			$('#company-id-display').show();
		} else {
			$('#company-id-display').hide();
		}
		
		if (customer_group[this.value]['company_id_required'] == '1') {
			$('#company-id-required').show();
		} else {
			$('#company-id-required').hide();
		}
		
		if (customer_group[this.value]['tax_id_display'] == '1') {
			$('#tax-id-display').show();
		} else {
			$('#tax-id-display').hide();
		}
		
		if (customer_group[this.value]['tax_id_required'] == '1') {
			$('#tax-id-required').show();
		} else {
			$('#tax-id-required').hide();
		}	
	}
});

$('select[name=\'customer_group_id\']').trigger('change');
//--></script>   
<script type="text/javascript"><!--
$('select[name=\'country_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=account/register/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#postcode-required').show();
			} else {
				$('#postcode-required').hide();
			}
			
			html = '<option value=""><?php echo $text_select; ?></option>';
			
			if (json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';
	    			
					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
	      				html += ' selected="selected"';
	    			}
	
	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}
			
			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');
//--></script>
<script type="text/javascript"><!--
$('.colorbox').colorbox({
	width: 640,
	height: 480
});
//--></script> 
<?php echo $footer; ?>