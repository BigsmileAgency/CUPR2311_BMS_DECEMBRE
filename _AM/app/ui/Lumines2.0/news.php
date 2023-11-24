<?php

     require_once "../../features/Feature.php";

?><!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>à propos</title>
    <script>
        var fonts_loaded = false;
        WebFontConfig = {
            google: {
                families: ['Roboto:400,500,700,900:latin']
            },
            loading: function() {
                fonts_loaded = true
            }
        };
        (function() {
            var wf = document.createElement('script');
            wf.src = 'https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s)
        })();
    </script>
    <style>
        html,
        body,
        div,
        span,
        applet,
        object,
        iframe,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        blockquote,
        pre,
        a,
        abbr,
        acronym,
        address,
        big,
        cite,
        code,
        del,
        dfn,
        em,
        img,
        ins,
        kbd,
        q,
        s,
        samp,
        small,
        strike,
        strong,
        sub,
        sup,
        tt,
        var,
        b,
        u,
        i,
        center,
        dl,
        dt,
        dd,
        ol,
        ul,
        li,
        fieldset,
        form,
        label,
        legend,
        table,
        caption,
        tbody,
        tfoot,
        thead,
        tr,
        th,
        td,
        article,
        aside,
        canvas,
        details,
        embed,
        figure,
        figcaption,
        footer,
        header,
        hgroup,
        menu,
        nav,
        output,
        ruby,
        section,
        summary,
        time,
        mark,
        audio,
        video {
            margin: 0;
            padding: 0;
            border: 0;
            font-size: 100%;
            font: inherit;
            vertical-align: baseline
        }
        
        article,
        aside,
        details,
        figcaption,
        figure,
        footer,
        header,
        hgroup,
        menu,
        nav,
        section {
            display: block
        }
        
        body {
            line-height: 1;
            background-color: #000;
            color: #fff;
            font-family: Roboto, Arial, sans-serif
        }
        
        ol,
        ul {
            list-style: none
        }
        
        blockquote,
        q {
            quotes: none
        }
        
        blockquote:before,
        blockquote:after,
        q:before,
        q:after {
            content: '';
            content: none
        }
        
        table {
            border-collapse: collapse;
            border-spacing: 0
        }
        
        a {
            text-decoration: none
        }
        
        a:active,
        a:focus,
        a:hover {
            text-decoration: none
        }

        ul{margin-left: 15px; margin-bottom: 15px;}
        h2{font-weight: 700; font-size: 30px}
        h3{font-size: 26px}
        .n {
        	padding-top: 20px

        }

        .important{
            color: #ff99cc;
            font-weight: 500;
        }

        .ultra{
            color: #ff3355;
            font-weight: 900;
        }
       
    </style>
</head>
<body>
   <?php Feature::read(); ?>
</body>
</html>