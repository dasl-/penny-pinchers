<?

setupIncludePath();

require_once "Loader.php";

date_default_timezone_set("America/New_York");
disableMagicQuotes();

require_once "secrets.php";

/**
 * Add root "/" and "/phplib" to the include path.
 */
function setupIncludePath() {
    $old_include_paths = get_include_path();
    $root = __DIR__ . "/../";
    $phplib = __DIR__;
    $new_paths = $phplib . PATH_SEPARATOR . $root;
    if ($old_include_paths) {
        $include_path = $new_paths . PATH_SEPARATOR . $old_include_paths;
    } else {
        $include_path = $new_paths;
    }
    set_include_path($include_path);
}

function disableMagicQuotes() {
    if (get_magic_quotes_gpc()) {
        $process = array(&$_GET, &$_POST, &$_COOKIE, &$_REQUEST);
        while (list($key, $val) = each($process)) {
            foreach ($val as $k => $v) {
                unset($process[$key][$k]);
                if (is_array($v)) {
                    $process[$key][stripslashes($k)] = $v;
                    $process[] = &$process[$key][stripslashes($k)];
                } else {
                    $process[$key][stripslashes($k)] = stripslashes($v);
                }
            }
        }
        unset($process);
    }
}