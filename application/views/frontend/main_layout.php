<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="fb:admins" content="522507520"/>
    <meta name="twitter:title" content="दैनिक प्रार्थना र बाईबल पदको लागि NIM Pray"/>
    <meta property="og:url" content="http://pray.nim.org.np/"/>
    <meta name="twitter:url" content="http://pray.nim.org.np/"/>
    <meta property="og:type" content="website"/>
    <meta name="author" content="NIM Pray"/>

    <meta property="og:title" content="दैनिक प्रार्थना र बाईबल पदको लागि NIM Pray"/>

    <meta name="title" content="दैनिक प्रार्थना र बाईबल पदको लागि NIM Pray"/>
    <meta property="og:description" content="<?php echo $prayer? $prayer->getVerseMessage()." - ".$prayer->getVerse() : '';  ?>"/>
    <meta name="description" content="<?php echo $prayer? $prayer->getVerseMessage()." - ".$prayer->getVerse() : '';  ?>"/>
    <meta itemprop="description" content="<?php echo $prayer? $prayer->getVerseMessage()." - ".$prayer->getVerse() : '';  ?>"/>
    <meta name="twitter:description" content="<?php echo $prayer? $prayer->getVerseMessage()." - ".$prayer->getVerse() : '';  ?>"/>
    <meta property="og:image" content="<?php echo $prayer? $prayer->getImageURL() : '';  ?>"/>
    <meta itemprop="image" content="<?php echo $prayer? $prayer->getImageURL() : '';  ?>"/>
    <meta name="twitter:image:src" content="<?php echo $prayer? $prayer->getImageURL() : '';  ?>"/>

    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>NIM Pray : <?php echo $pageTitle?:''; ?></title>
    

    <!-- Bootstrap -->
    <link href="<?php echo base_url()?>/bower_components/admin-lte/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url()?>/assets/templates/frontend/css/prayer.css" rel="stylesheet" type="text/css" />
   
    <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
    <script type="text/javascript">stLight.options({publisher: "0e4f355c-1efb-46e7-bdcf-0dd4393f82d4", doNotHash: false, doNotCopy: true, hashAddressBar: false});</script>
</head>
<body>
<div id="fb-root"></div>
    <script>(function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=719930771404078";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

    <div class="container-fluid">
        <?php $this->load->theme($content); ?>
    </div>
     
</body>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo base_url()?>/bower_components/jquery/dist/jquery.min.js" type="text/javascript"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url()?>/bower_components/admin-lte/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    
</html>