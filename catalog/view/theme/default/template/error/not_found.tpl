<!DOCTYPE html>
<html>
    <head>
        <title>HPT - <?php echo $heading_title; ?></title>
        <?php if ($icon) { ?>
            <link href="<?php echo $icon; ?>" rel="icon" />
        <?php } ?>
        <link rel="stylesheet" type="text/css" href="<?php echo $home; ?>catalog/view/theme/default/stylesheet/style_err.css" />
        <script type="text/javascript" src="<?php echo $home; ?>catalog/view/javascript/jquery/jquery-1.7.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("ul.navigation li").hover(function () {
                    $(this).children().stop().animate({
                        marginLeft : "10px"					 						 
                    }, 400);
                }, function () {
                    $(this).children().stop().animate({
                        marginLeft : "0px"					 						 
                    }, 400);
                });
            });
        </script>      
    </head>
    <body>
        <div id="wrapper">
            <?php if ($logo) { ?>
              <a href="<?php echo $home; ?>" id="logo"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a>
            <?php } ?>
            <div id="main">
                <div id="leftcolumn">                   
                </div>
                <div id="rightcolumn">
                    <?php echo $text_error; ?>
                    <ul class="navigation">
                        <li><a style="margin-left: 0px;" href="<?php echo $home; ?>">» Trang chủ</a></li>
                        <li><a style="margin-left: 0px;" href="#">» Danh mục sản phẩm </a></li>
                        <li><a href="#">» Tìm kiếm sản phẩm</a></li>
                        <li class="last"><a href="#">» Tin tức tổng hợp</a></li>
                    </ul>
                    <ul class="navigation">
                        <li><a href="#">» Download bảng giá</a></li>
                        <li><a href="#">» Giỏ hàng</a></li>
                        <li><a href="#">» Lịch sử mua hàng</a></li>
                        <li class="last"><a href="#">» Thanh toán</a></li>
                    </ul>
                </div>
                <br class="clear">
                <div id="footer">
                    <div id="copyright">© 2012 - INHERE.VN</div>
                    <ul id="footer_navigation">
                        <li><a href="index.php?route=information/sitemap">Bản đồ website</a>-</li>
                        <li><a href="#">Quy định</a>-</li>
                        <li><a href="index.php?route=information/contact">Liên lạc</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </body>
</html>
