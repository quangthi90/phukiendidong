                    <!-- List reviews -->
                    <?php foreach ( $comments as $comment ){ ?>
                    <div class="review-item">
                        <div class="review-heading">
                            <strong><?php echo $comment['customer']['firstname'] . ' ' . $comment['customer']['lastname']; ?></strong> - <span class="review-time"><?php echo $comment['date']; ?></span>
                        </div>
                        <div class="review-main">
                            <div class="row-fluid">
                                <div class="span1">
                                    <img class="review-avatar fl span12" src="<?php echo $comment['customer']['thumb_url']; ?>" />
                                </div>
                                <div class="span11 review-content">
                                    <div style="word-wrap: break-word;">
                                        <p><?php echo $comment['content']; ?></p>
                                    </div>
                                    <div class="review-arrow"><div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>