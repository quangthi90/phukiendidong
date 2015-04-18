<?php echo $header; ?>
<div class="line_margin"></div>
<?php echo $column_left; ?>
<?php echo $column_right; ?>
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
    <div id="contact">
        <div class="contact_content">
            <div id="company_map">                
            </div>            
        </div>
        <div class="contact_content contact_form">
			<?php if (isset($success)){ ?>
			<div class="success"><?php echo $success; ?></div>
			<?php } ?>
			<?php if ($customer_info) { ?>
			<div id="frm-post-contact">
				<h4>Gửi thư đến chúng tôi</h4>
				<form method="post">
					<table>
						<tr>
							<td class="_label" style="width: 290px;">
								<span class="required">(*) </span><?php echo $entry_email; ?>
							</td>
							<td class="value">
								<input type="text" id="contact_email" name="email" value="<?php echo $email; ?>" /> <br />
								<span class="client_warning" id="warning_email"></span>
							</td>
						</tr>
						<tr>
							<td class="_label">
								<span class="required">(*) </span><?php echo $entry_title; ?>
							</td>
							<td class="value">
								<input type="text" id="contact_title" name="title" value="<?php echo $title; ?>" /><br />
								<span class="client_warning" id="warning_title"></span>
							</td>
						</tr>
						<tr>
							<td class="_label" style="vertical-align: top;">
								<span class="required">(*) </span><?php echo $entry_content; ?>
							</td>
							<td class="value">
								<textarea id="content_contact" name="content" ><?php echo $content; ?></textarea><br />
								<span class="client_warning" id="warning_content"></span>
							</td>
						</tr>                    
						<tr>
							<td class="_label" style="vertical-align: top;">								
								<span class="required">(*) </span><?php echo $entry_captcha; ?> 
							</td>
							<td class="value">
								<img src="<?php echo HTTP_SERVER . '/index.php?route=information/contact/captcha'; ?>" alt="" /> <br/>
								<div style="height:10px;"></div>
								<input type="text" name="captcha" value="" id="contact_captcha" /><br />
								<span id="warning_captcha" class="client_warning"></span>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td class="value">
								<input type="submit" value="<?php echo $button_submit; ?>" onclick="return checkValid()" class="btn btn-primary" style="padding: 2px 12px;" />
								<input type="reset" value="<?php echo $button_reset; ?>" class="btn btn-primary" style="padding: 2px 12px;" />
							</td>
						</tr>
					</table>
				</form>    
			</div>
			<?php }else { ?>
			<div class="row-fluid alert alert-info"><?php echo $text_login_warning; ?></div>
			<?php } ?>
			<div class="contact_content_company">
				<h2 class="company_name">HPT - www.phukiendidong.vn</h2>
				<p class="contact_content_line">
					+ <span><?php echo $text_address; ?></span> 384 đường 3 Tháng 2 – F.12 – Q.10 – TP HCM
				</p>
				<p class="contact_content_line">
					+ <span><?php echo $text_telephone; ?></span> (08) 38 645 935 (bấm 101) - 0908 322 767 (Mr. Minh) - 0917 56 46 56 (Mrs. Phúc)
				</p>
				<p class="contact_content_line">
					+ <span><?php echo $text_email; ?></span> <a href="mailto:minhtamky@gmail.com" title="Gởi mail">minhtamky@gmail.com</a>
				</p>
			</div>						
        </div>
    </div>   
    <script type="text/javascript">
        <!--
		 $(document).ready(function() {
			var rv_lat = 10.754643;
			var rv_lng = 106.665453;			 
			showMap(rv_lat,rv_lng,'HPT','company_map',true);
		 });
		 
        function checkValid(){
            if($('#contact_email').val().trim().length == 0){
                $('#warning_email').html('Email trống !');
                $('#contact_email').focus();
                return false;
            }else{
                if(!IsEmail($('#contact_email').val())){
                    $('#warning_email').html('Email không hợp lệ !');
                    $('#contact_email').focus();
                    return false;
                }else{
                    $('#warning_email').html('');
                }                
            }

            if($('#contact_title').val().trim().length == 0){
                $('#warning_title').html('Tiêu đề trống !');
                $('#contact_title').focus();
                return false;
            }else{
                $('#warning_title').html('');
            }

            if($('#content_contact').val().trim().length <= 50 ){
                $('#warning_content').html('Nội dung tối thiểu 50 ký tự !');
                $('#content_contact').focus();
                return false;
            }else{
                $('#warning_content').html('');
            }
            
            if($('#contact_captcha').val().trim().length == 0){
                $('#warning_captcha').html('Nhập mã kiểm tra !');
                $('#contact_captcha').focus();
                return false;
            }else{
                $('#warning_captcha').html('');
            }
        }
        
        function IsEmail(email) {
              var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
              return regex.test(email);
        }
        //-->
    </script>   
    <?php echo $content_bottom; ?>
</div>
<?php echo $footer; ?>