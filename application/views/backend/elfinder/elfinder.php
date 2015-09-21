<script type="text/javascript" charset="utf-8">
    $().ready(function() {
        var id = getURLParameter('id');

        var $f = $('.elfinder').elfinder({
            url : '<?php echo site_url("elfinder/init/".$mode); ?>',
            getFileCallback: function(file) {
                window.opener.setValue(file.url, id);
                window.close();
            }
        });


        var $window = $(window);
        $window.resize(function(){
            var $win_height = $window.height();
            if( $f.height() != $win_height ){
                $f.height($win_height).resize();
            }
        });
    });

    function getURLParameter(name) {
        return decodeURIComponent((new RegExp('[?|&]' + name + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null
    }
</script>
<div class="elfinder"></div>