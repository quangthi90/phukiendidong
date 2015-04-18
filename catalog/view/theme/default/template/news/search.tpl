<?php echo $header; ?>
<?php // echo $container_top; ?>
    <?php echo $column_left; ?> 
<div id="content">
    <div class="my-breadcrumb row-fluid">
        <div class="span7">
          <?php foreach ($breadcrumbs as $breadcrumb) { ?>
          <?php if ($breadcrumb['separator']) { ?>
          <div class="breadcrumb-arrow"></div>
          <?php } ?>
            <div class="breadcrumb-box">
              <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            </div>
          <?php } ?>
        </div>
        <div class="span5" style="float: right; text-align: right; padding-right: 10px;">
          <form class="form-search" action="<?php echo HTTP_SERVER . "tim-kiem-tin-tuc"; ?>" method="GET">
            <div class="input-append" style="padding-top: 2px;">
              <input name="keyword" type="text" class="span2 search-query" style="width: 150px;" value="<?php echo $keyword; ?>" />
              <button id="search-keyword" type="submit" class="btn" style="  margin-left: -4px;"><i class="icon-search" style="font-size: 18px;"></i></button>
            </div>
          </form>
        </div>
    </div>
   <div class="newsdetail-main row-fluid">
        <div class="span8">
            <div class="newscategory-top"><?php echo $result; ?></div>
            <div id="list_news_of_category">
            <?php if (count($newses) > 0){ ?>
                <?php foreach ($newses as $news) { ?>
                    <div class="news_of_category_item">
                        <a class="img_news_of_category" href="<?php echo $news['href']; ?>">
                            <img alt="<?php echo $news['title']; ?>" src="<?php echo $news['image']; ?>" />
                        </a>
                        <div class="info_news_of_category">
                            <h3  class="title_news_of_category">
                                <a href="<?php echo $news['href']; ?>"><?php echo $news['title']; ?></a>
                            </h3>
                            <p class="datepost_news_of_category">
                                <?php echo $news['created']; ?>
                            </p>
                            <p class="des_news_of_category">
                                <?php echo $news['description']; ?>
                            </p>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
            </div>  	
            <div class="pagination"><?php echo $pagination; ?></div>
        </div>
        <div class="span4">
            <?php echo $column_right; ?>
        </div>
    </div>
</div>

<?php echo $footer; ?>
