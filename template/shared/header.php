<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="robots" content="noindex, nofollow">
        <title><?= "$page_title" ?></title>
        <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/style.css?bust=<?= $cache_version ?>" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script type="text/javascript">
            <?
                echo "global_data = {};\n";
                foreach ($js_data as $key => $value) {
                    echo "global_data.$key = $value;\n";
                }
            ?>
        </script>
    </head>

    <body>
        <div id="content">
