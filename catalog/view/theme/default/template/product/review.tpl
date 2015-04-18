<?php // print "hello"; print "<pre>"; var_dump($reviews); exit(); ?>
<?php if ($reviews) { ?>
                <?php foreach ( $reviews as $review ){ ?>
                <div class="review-item">
                    <p class="review-info">
                        <strong><?php echo $review['customer']['firstname'] . ' ' . $review['customer']['lastname']; ?></strong> - <span class="review-time"><?php echo $review['date_added']; ?></span>
                    </p>
                    <div class="review-main">
                        <img class="review-avatar fl" src="<?php echo $review['customer']['thumb_url']; ?>" width="45px" height="45px" />
                        <div class="review-content">
                            <span class="stuff-review"></span>
                            <p><?php echo $review['text']; ?></p>
                        </div>
                    </div>
                </div>
                <?php } ?>
<?php // foreach ($reviews as $review) { ?>
<!--div class="review-list">
  <div class="author"><b><?php echo $review['author']; ?></b> <?php echo $text_on; ?> <?php echo $review['date_added']; ?></div>
  <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $review['rating'] . '.png'; ?>" alt="<?php echo $review['reviews']; ?>" /></div>
  <div class="text"><?php echo $review['text']; ?></div>
</div-->
<?php // } ?>
<div class="pagination"><?php echo $pagination; ?></div>
<?php } else { ?>
<div class="content"><?php echo $text_no_reviews; ?></div>
<?php } ?>
