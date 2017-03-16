<!DOCTYPE html>
<html lang="pl-PL" class="no-js">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=yes">
        <meta name="theme-color" content="#1A3247">
        <link rel="stylesheet" id="roboto-font-css"  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700&#038;subset=latin,latin-ext" type="text/css" media="all" />
        <link rel="stylesheet"  href="<?php echo plugins_url( 'mf-poll/media/css/front.css') ; ?>" type="text/css" media="all">
        <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>
        <script>
        $.datepicker.regional['pl'] = {
            closeText: "Zamknij",
            prevText: "&#x3C;Poprzedni",
            nextText: "Następny&#x3E;",
            currentText: "Dziś",
            monthNames: [ "Styczeń","Luty","Marzec","Kwiecień","Maj","Czerwiec","Lipiec","Sierpień","Wrzesień","Październik","Listopad","Grudzień" ],
            monthNamesShort: [ "Sty","Lu","Mar","Kw","Maj","Cze","Lip","Sie","Wrz","Pa","Lis","Gru" ],
            dayNames: [ "Niedziela","Poniedziałek","Wtorek","Środa","Czwartek","Piątek","Sobota" ],
            dayNamesShort: [ "Nie","Pn","Wt","Śr","Czw","Pt","So" ],
            dayNamesMin: [ "N","Pn","Wt","Śr","Cz","Pt","So" ],
            weekHeader: "Tydz",
            dateFormat: "dd.mm.yy",
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ""
        };
        $.datepicker.setDefaults($.datepicker.regional['pl']);
        </script>
    </head>
    <body>
        <div class="container container-header" >
        <?php echo $header; ?>
        <?php if($pages > 1){ ?>
            <span class="page-for-user">
                <?php echo __('Page:', 'mfpoll'); ?> <span class="page"><?= $page ?></span>/<span class="count"><?= $pages ?></span>
            </span>
        <?php } ?>
        </div>
        <div class="container" id="content">
        <?php 
            MFPView::get('template/entry', ['poll' => $poll, 'questions' => $questions, 'pages' => $pages, 'page' => $page]);
        ?>
        </div>
        <?php echo $footer; ?>
        <?php print_r($_SESSION); ?>
        
    </body>
</html>
