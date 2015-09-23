<script type="text/javascript" charset="utf-8">
    $().ready(function() {
        var id = getURLParameter('id');
        var selectMultiple = getURLParameter('multiple')? true : false;

        var $f = $('.elfinder').elfinder({
            url : '<?php echo site_url("admin/media/elfinder/init/".$mode); ?>',
            commandsOptions : {
                // configure value for "getFileCallback" used for editor integration
                getfile : {
                    // allow to return multiple files info
                    multiple : selectMultiple,
                }
            },
            getFileCallback: function(file) {

                if(selectMultiple)
                {
                    var urlArray = [];
                    file.forEach(function(f) {
                        urlArray.push(f.url);
                    });
                    var fileUrl = urlArray.join();
                }else{
                    var fileUrl = file.url;
                }
                window.opener.setValue(fileUrl, id);
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