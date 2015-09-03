<div class="prayer-wrapper">
    <div class="prayer-header">
        <h2>
            <img src="<?php echo base_url()?>/assets/templates/frontend/images/praying-hands.png" class="img-responsive" alt="Praying Hands">
            <span>NIM</span> PRAY
        </h2>  
    </div>

    <div class="prayer-message">
        <h2>आजको प्रार्थना</h2>
        <span><?php echo $prayer->getDate()->format('l, F d, Y'); ?></span>

        <p><?php echo $prayer->getPrayerRequest(); ?></p>
    </div>

    <div class="prayer-image">
        <img src="<?php echo base_url()?>/assets/templates/frontend/images/img1.jpg" class="img-responsive" alt="Prayer Request">
        <!-- <img src="<?php echo $prayer->getImageURL();?>" class="img-responsive" alt="Prayer Request"> -->

    </div>

    <div class="prayer-verse">
        <p><?php echo $prayer->getVerseMessage(); ?></p>
        (<?php echo $prayer->getVerse(); ?>)
    </div>

</div>