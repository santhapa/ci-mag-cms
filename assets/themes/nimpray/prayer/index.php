<div class="row">
    <div class="col-xs-12 prayer-header">
        <img src="<?php echo base_url()?>/assets/templates/frontend/images/nimpray_logo.png" class="img-responsive" alt="nim pray logo">
    </div>
    <div class="col-xs-12 prayer-todays">
        <h2>आजको प्रार्थना</h2>
        <span><?php echo $prayer? $prayer->getDate()->format('l, F d, Y') : date('l, F d, Y'); ?></span>
    </div> 
</div>

<div class="row">
    <div class="prayer-message">
        <?php echo $prayer? $prayer->getPrayerRequest() : "Sorry! No content found for today."; ?>
    </div>   

    <?php if($prayer): ?>
        <div class="prayer-image">
            <?php /* <img src="<?php echo base_url()?>/assets/templates/frontend/images/img1.jpg" class="img-responsive" alt="<?php echo $prayer->getVerseMessage(). " - " . $prayer->getVerse(); ?>"> */ ?>
            <img src="<?php echo $prayer->getImageURL();?>" class="img-responsive" alt="<?php echo $prayer->getVerseMessage(). " - " . $prayer->getVerse(); ?>">
        </div>

        <div class="prayer-verse">
            <span class="verse-message"><?php echo $prayer->getVerseMessage(); ?></span>    
            <span class="verse">(<?php echo $prayer->getVerse(); ?>)</span>
        </div>

        <div class="social-share nonborderbox">
            <span class='st_fblike_hcount' displayText='Facebook Like'></span>
            <span class='st_facebook_hcount' displayText='Facebook'></span>
            <span class='st_twitter_hcount' displayText='Tweet' st_via=''></span>
            <span class='st_googleplus_hcount' displayText='Google +'></span>  
            
        </div>
        <div class="comment-box">
            <div class="fb-comments" data-href="http://pray.nim.org.np" data-numposts="10"></div>
        </div>
    <?php endif; ?>

</div>