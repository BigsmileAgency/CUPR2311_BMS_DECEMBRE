<?php
    require_once 'common/utils/config/settings/functions.php';
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- GetValueProcess:beginImport -->[[GFont]]
	<script>
        var fonts_loaded = false;
        WebFontConfig = {
            google: { families: [ 'Open Sans:400,700:latin' ] },
            loading: function() {
                fonts_loaded = true;
            }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        })();
    </script>
	[[!GFont]]
    [[splitText]]<script src="<?php echo $assets -> path('splitText'); ?>"></script>
    [[!splitText]][[drawSVG]]<script src="<?php echo $assets -> path('drawSvg'); ?>"></script>
    [[!drawSVG]][[morphSVG]]<script src="<?php echo $assets -> path('morphSvg'); ?>"></script>
    [[!morphSVG]]
	<!-- GetValueProcess:endImport -->
</head>
<body>
<!-- GetValueProcess:beginContent -->
    [[exemple]]

        <?php //<div class="cta abs text">Click here</div> ?>

    [[!exemple]]
    <div class="border abs"></div>
<!-- GetValueProcess:endContent -->
</body>
</html>
