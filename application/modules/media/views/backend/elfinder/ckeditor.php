<script type="text/javascript" charset="utf-8">

    // Helper function to get parameters from the query string.
    function getUrlParam(paramName) {
        var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i') ;
        var match = window.location.search.match(reParam) ;

        return (match && match.length > 1) ? match[1] : '' ;
    }

    $(document).ready(function() {
        var funcNum = getUrlParam('CKEditorFuncNum');

        var elf = $('#elfinder').elfinder({
            url : '<?php echo site_url("admin/media/elfinder/init/".$mode) ?>',
            getFileCallback : function(file) {
                window.opener.CKEDITOR.tools.callFunction(funcNum, file.url);
                window.close();
            },
            resizable: false
        }).elfinder('instance');


        var $window = $(window);
        $window.resize(function(){
            var $win_height = $window.height();
            if( $elf.height() != $win_height ){
                $elf.height($win_height).resize();
            }
        });
    });

</script>

<!-- Element where elFinder will be created (REQUIRED) -->
<div id="elfinder"></div>
