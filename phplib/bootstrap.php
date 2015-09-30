<?

error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set("America/New_York");

setupIncludePath();

require_once "Loader.php";
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
