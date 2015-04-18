<?php if (isset($_SERVER['HTTP_USER_AGENT']) && !strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6'))
    echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" xml:lang="<?php echo $lang; ?>">
    <head>
        <title><?php echo $title; ?></title>
        <base href="<?php echo $base; ?>" />
        <?php if ($description) { ?>
            <meta name="description" content="<?php echo $description; ?>" />
        <?php } ?>
        <?php if ($keywords) { ?>
            <meta name="keywords" content="<?php echo $keywords; ?>" />
        <?php } ?>
        <?php if ($icon) { ?>
            <link href="<?php echo $icon; ?>" rel="icon" />
        <?php } ?>
        <?php foreach ($links as $link) { ?>
            <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
        <?php } ?>
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/stylesheet.css" />
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/fortAwesome/css/font-awesome.css" />
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/bootstrap-responsive.css" />
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/rating.css" />
        <?php foreach ($styles as $style) { ?>
            <link rel="<?php echo $style['rel']; ?>" type="text/css" href="<?php echo $style['href']; ?>" media="<?php echo $style['media']; ?>" />
        <?php } ?>
        <script type="text/javascript" src="catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="catalog/view/javascript/jquery/ui/jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript" src="catalog/view/javascript/jquery/ui/modernizr-2.6.1-respond-1.1.0.min.js"></script>
        <link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css" />
        <script type="text/javascript" src="catalog/view/javascript/jquery/ui/external/jquery.cookie.js"></script>
        <script type="text/javascript" src="catalog/view/javascript/jquery/colorbox/jquery.colorbox.js"></script>
        <link rel="stylesheet" type="text/css" href="catalog/view/javascript/jquery/colorbox/colorbox.css" media="screen" />
        <script type="text/javascript" src="catalog/view/javascript/jquery/tabs.js"></script>
        <script type="text/javascript" src="catalog/view/javascript/common.js"></script>
        <script type="text/javascript" src="catalog/view/javascript/bootstrap.js"></script>
        <?php foreach ($scripts as $script) { ?>
            <script type="text/javascript" src="<?php echo $script; ?>"></script>
        <?php } ?>
        <!--[if IE 7]>
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie7.css" />
        <![endif]-->
        <!--[if lt IE 7]>
        <link rel="stylesheet" type="text/css" href="catalog/view/theme/default/stylesheet/ie6.css" />
        <script type="text/javascript" src="catalog/view/javascript/DD_belatedPNG_0.0.8a-min.js"></script>
        <script type="text/javascript">
        DD_belatedPNG.fix('#logo img');
        </script>
        <![endif]-->
    <?php echo $google_analytics; ?>
    </head>
    <body>
        <div id="bottom_page">
	    <?php echo $language; ?>
	    <a id="fb_cn" class="fr" href="https://www.facebook.com/hpt.phukiendidong" target="_blank">
		    <img src="<?php echo HTTP_SERVER; ?>catalog/view/theme/default/image/fb.png" style="vertical-align: middle;" />
	    </a>
	    <div id="bt_contact" class="fr">		
		<ul class="contac_ways fr">		    
		    <li class="g_plus"><g:plusone size="small" href="http://phukiendidong.vn"></g:plusone></li>
		    <li class="yahoo"><a href="ymsgr:sendIM?hotro_phukiendidong" title="Yahoo Hỗ Trợ"></a></li>            
		    <li class="skye"><a href="skype:hpt?chat" title="Chat Skye"></a></li>
		    <li class="email"><a href="<?php echo HTTP_SERVER; ?>lien-he" title="Email Liên Hệ" ></a></li>
		    <li class="faq"><a href="<?php echo HTTP_SERVER; ?>#" title="FAQ"></a></li>            
		</ul>		
	    </div>	    
	    <div class="bt_welcome fr">
		<marquee behavior="scroll" direction="left" scrollamount="2">
		   CHÚNG TÔI SẴN SÀNG TƯ VẤN MIỄN PHÍ GIÚP QUÝ KHÁCH ĐƯA RA QUYẾT ĐỊNH ĐÚNG
		</marquee> 
	    </div>
	  </div>
        <div class="row-fluid header">
            <div class="header-top">
                <div class="span3 header-left">
                    <?php if ($logo) { ?>
                        <a href="<?php echo $home; ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a>
                    <?php } ?>
                </div>
                <div class="span9 header-right">
                    <div class="row-fluid">
                        <div class="span3 offset1">
                            <img src="<?php echo $image_deliver; ?>" alt="" />
                        </div>
                        <div class="span7 offset1">
                            <div class="row-fluid header-top-box">
                                <?php if ($logged == false){ ?>                                
                                    <div class="span4 top-box">  
                                        <a href="<?php echo HTTP_SERVER . 'dang-nhap'; ?>">
                                            <span class="icon-lock"></span><?php echo $text_login; ?>
                                        </a>
                                    </div>
                                    <div class="span3 top-box">
                                        <a href="<?php echo HTTP_SERVER . 'dang-ky'; ?>">
                                            <span class="icon-user"></span><?php echo $text_reg; ?>
                                        </a>
                                    </div>
                                <?php }else{?>
                                    <div class="span4 top-box">
                                        <a href="<?php echo HTTP_SERVER . 'thong-tin-tai-khoan'; ?>">
                                            <span class="icon-lock"></span>
                                            <?php echo $text_account; ?>
                                        </a>
                                    </div>
                                    <div class="span3 top-box">
                                        <a href="<?php echo HTTP_SERVER . 'dang-xuat'; ?>">
                                            <span class="icon-user"></span>
                                            <?php echo $text_logout; ?>
                                        </a>
                                    </div>
                                <?php }?>
                                <div class="span4 offset1 top-box" id="quick-view-cart">
                                    <a href="<?php echo $checkout; ?>">
                                        <span class="icon-shopping-cart" style="float: left;"></span>
                                        <div id="text_cart" style="float: left; margin-left: 5px;"><?php echo $text_cart; ?></div>
                                        <div id="text_checkout" style="display: none; float: left; margin-left: 5px;"><?php echo $text_checkout; ?></div>
                                    </a>                                
                                    <?php echo $cart;  ?>
                                </div>
                                <input type="hidden" id="logged" value="<?php if ($logged == false) echo '0'; else echo '1'; ?>" />
                            </div>
                            <script type="text/javascript">
                                $('#quick-view-cart a').hover(function () {
                                    $('#text_cart').toggle(); 
                                    $('#text_checkout').toggle();
                                });
                            </script>
                            <div class="row-fluid header-bottom-box">
                                <form class="input-append" id="newsletter-register" method="POST">
                                    <input class="span8" id="appendedInputButton" style="background-color: #f2fafd;" type="text" value="<?php echo $text_email_input; ?>" onfocus="$(this).val('')" name="email" />
                                    <button class='btn btn-primary' type="button" onclick="$('#newsletter-register').attr('action', '<?php echo $newsletter_register; ?>'); $('#newsletter-register').submit();"><?php echo $text_subprice; ?></button>
                                </form>
                            </div>
                        </div>
                    </div>
					<div style="position: absolute; top: 65px; left: 240px; width: 245px; text-align: center;">
						<p style="font-weight: bold;font-size: 12px;margin: 0px;">384 đường 3/2 - F.12 - Q.10 - TP HCM</p>
						<p style="font-size: 12px;margin: 0px;line-height: 18px;">
							Tel: <strong style="font-size: 13px;color: red;">08 38 634 935</strong>
						</p>
					</div>
                </div>
            </div>
        </div>
        <div class="row-fluid menu">
            <div class="header-top">
                <div class="left-menu">
                    <ul>
                        <li><a href="<?php echo $home; ?>"><?php echo $text_home; ?></a></li>
                        <li><a href="#"><?php echo $text_product; ?></a>
                        <?php if ($categories) { ?>
                            <ul>
                            <?php foreach ($categories as $category) { ?>
                                <li>
                                    <a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a>
                                    <?php if ($category['children']) { ?>
                                    <ul>
                                    <?php foreach ($category['children'] as $value) { ?>                            
                                        <li><a href="<?php echo $value['href']; ?>"><?php echo $value['name']; ?></a></li>                   
                                    <?php } ?>
                                    </ul>
                                    <?php } ?>
                                </li>
                            <?php } ?>
                            </ul>
                        <?php } ?>
                        </li>
                        <li><a href="#"><?php echo $text_decoration; ?></a></li>
                    </ul>
                </div>
                <div class="right-menu">
                    <ul>
                        <li>
                            <a href="#"><?php echo $text_news; ?></a>
                            <?php if ($news_categories) echo $news_categories; ?>
                        </li>
                        <li>
			    <a href="<?php echo HTTP_SERVER . 'khuyen-mai-22'; ?>"><?php echo $text_promotion; ?></a>			    
			</li>
                        <li><a href="http://www.youtube.com/user/vienthonghoangphat/videos"><?php echo $text_video; ?></a></li>
                    </ul>
                </div>
                <div id="support">
                    <div class="support-box">
                        <!--div class="hotline"><?php echo $text_hotline; ?></div-->
                        <div class="phone-hotline">0908 322 767<br />0917 56 46 56</div>
                        <div class="yahoo-support">
                            <div class="yahoo"><a href="ymsgr:sendIM?phuc013010" title="Bán Hàng"></a></div>
                            <div class="yahoo"><a href="ymsgr:sendIM?hotro_phukiendidong" title="Hỗ Trợ"></a></div>
                            <div class="yahoo"><a href="ymsgr:sendIM?tkmi7" title="Quản Lý"></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="container">
            <div class="line-shadown"></div>            
<div id="notification" style="clear:both;"></div>

