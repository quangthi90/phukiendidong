<?php echo $header; ?>
<?php echo $content_top; ?>
<div id="content">
    <div class="row-fluid">
        <!--<div class="testslider row-fluid"></div>//-->        
        <div class="my-breadcrumb row-fluid">
            <div class="span9">
                <?php foreach ($breadcrumbs as $breadcrumb) { ?>
                <?php if ($breadcrumb['separator']) { ?>
                    <div class="breadcrumb-arrow"></div>
                <?php } ?>
                <div class="breadcrumb-box">
                    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
                </div>
                <?php } ?>
            </div>
            <div class="span3" style="float: right; text-align: right; padding-right: 10px;">
            <form class="form-search" action="<?php echo HTTP_SERVER . 'tim-kiem-tin-tuc'; ?>" method="GET">
                <div class="input-append" style="padding-top: 2px;">
                    <input name="keyword" type="text" class="span2 search-query" style="width: 150px;" />
                    <button id="search-keyword" type="submit" class="btn button-search" style="  margin-left: -4px;"><i class="icon-search" style="font-size: 18px;"></i></button>
                </div>
            </form>
            </div>
        </div>
        <div class="newsdetail-main row-fluid">
            <div class="span8">
            <?php if (isset($news)) { ?>
                <div class="newsdetail-top row-fluid"><?php echo $news['title']; ?></div>
                <div class="row-fluid">
                    <div class="newsdetail-content">
                    <?php echo html_entity_decode($news['description']) ?>
                    </div>
                </div>
                                
                <div class="cleaner"></div>
                <div class="row-fluid">
                    <div id="review-title" class="commentform-top">
                    <div class="span11"><?php echo $text_comment; ?> (<span id="total"><?php echo $totalcomment; ?></span>)</div>
                    <div class="span1">
                        <span title="hide" class="collapsed-icon"></span>
                    </div>
                    </div>
                </div>
                <?php if (isset($customer_inf)) { ?>
                <div class="commentform-main row-fluid">
                    <form method="POST">
                        <textarea class="commentform-content span9" name="content"></textarea>
                        <input id="button-comment" class="btn btn-primary span3" type="button" value="<?php echo $text_send; ?>" style="margin-top: 15px;" />
                    </form>
                </div>
                <?php } ?>
                <div id="comment" class="commentuser-main row-fluid">
                </div>    
            <?php } ?>
                <?php echo $content_bottom; ?> 
            </div>	
            <div class="span4">
                <?php echo $column_right; ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript"><!--
    $(function () {
        $('#comment').load('index.php?route=news/news_detail/showcomment&news_id=<?php echo (isset($news['news_id'])) ? $news['news_id'] : ''; ?>');

        $('#button-comment').bind('click', function() {
            $.ajax({
                url: 'index.php?route=news/news_detail/writecomment&news_id=<?php echo (isset($news['news_id'])) ? $news['news_id'] : ''; ?>',
                type: 'post',
                dataType: 'json',
                data: 'content=' + encodeURIComponent($('textarea[name=\'content\']').val()),
                beforeSend: function() {
                    $('.success, .warning').remove();
                    $('#button-comment').attr('disabled', true);
                    $('#review-title').after('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
                },
                complete: function() {
                    $('#button-comment').attr('disabled', false);
                    $('.attention').remove();
                },
                success: function(data) {
                    if (data['error']) {
                        $('#review-title').after('<div class="warning">' + data['error'] + '</div>');
                    }
            
                    if (data['success']) {
                        $('#comment').load('index.php?route=news/news_detail/showcomment&news_id=<?php echo (isset($news['news_id'])) ? $news['news_id'] : ''; ?>');
                        $('#review-title').after('<div class="success">' + data['success'] + '</div>');
                        $('#total').html(data['totalcomment']);
                                
                        $('textarea[name=\'content\']').val('');
                    }
                }
            });
        });
    });
//--></script>

<script type="text/javascript">
    $(document).ready(function(){
        $('.collapsed-icon').bind('click', function() {
            var action = $(this).attr("title");  
            if(action == "hide"){
                $("#review").slideUp('slow');
                $(this).attr("title", "show");
                $(this).css("background","transparent url(catalog/view/theme/default/image/arr-up.png) no-repeat center 50%");
            }
            else{
                $("#review").slideDown('slow');
                $(this).attr("title", "hide");
                $(this).css("background","transparent url(catalog/view/theme/default/image/arr-down.png) no-repeat center 50%");
            }
        });
    });	
</script>	
<?php echo $footer; ?>
