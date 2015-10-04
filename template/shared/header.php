<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= "$page_title" ?></title>
        <link rel="stylesheet" type="text/css" media="screen" href="/assets/css/style.css?bust=<?= $cache_version ?>" />
        <script type="text/javascript">
            <?
                echo "global_data = {};\n";
                foreach ($js_data as $key => $value) {
                    echo "global_data.$key = $value;\n";
                }
            ?>
        </script>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <link href='https://fonts.googleapis.com/css?family=Inconsolata:400,700' rel='stylesheet' type='text/css'>
    </head>

    <body>
        <div id="header">
            <a href="/" title="home"><img src="/assets/img/penny-logo.gif" alt="¯\_(ツ)_/¯"></a>
            <?
                if (isset($is_compact_header) && $is_compact_header) {
                    echo "<h3 class='compact-header'>$compact_header_title</h3>";
                } else {
                    echo '&nbsp;&nbsp;&nbsp;<a href="https://github.com/dasl-/penny-pinchers/">social component</a>';
                }
            ?>
        </div>

        <div id="content">
