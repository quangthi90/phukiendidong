
<div class="samenews-top userlabel1">Tin tương tự</div>
<div class="samenews-main">
    <?php foreach ($newses as $news) { ?>
    <div class="samenews-item">
        <div class="span3">
            <a title="<?php echo $news['title']; ?>" href="<?php echo $news['href']; ?>"><img alt="<?php echo $news['title']; ?>" src="<?php echo $news['image']; ?>" class="testimage2" /></a>
        </div>
        <div class="span9">
            <div class="userlabel2"><a href="<?php echo $news['href']; ?>"><?php echo $news['title']; ?></a></div>
            <div class="createdate"><?php echo $news['created']; ?></div>
        </div>
        <div class="cleaner"></div>
    </div>
     <?php } ?>
</div>