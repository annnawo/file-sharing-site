<?php 
session_start();
if (isset($_POST["sort"])) {
    if (isset($_POST["sort_btn"])) {
        $username = $_SESSION["username"];
        $path = sprintf("/srv/module2group/%s", $username);
        $files = scandir($path);
        $files = array_diff(scandir($path), array('.', '..')); // Remove the . and .. at the beginning of the scandir() array
        $datesarr = array();
        $radioVal = $_POST["sort_btn"];
        switch ($radioVal) {
            case "alpha_asc":
                echo "ascend works";
                for ($i=0;$i<sizeof($files);$i++) {
                    $file = $files[$i+2];
                    $file_creation_date = filectime(sprintf("%s/%s", $path, $file));
                    $datesarr[] =  [$file => $file_creation_date];
                }
            krsort($datesarr);
            break;
            case "alpha_des":
                echo "descend works";
                for ($i=0;$i<sizeof($files);$i++) {
                    $file = $files[$i+2];
                    $file_creation_date = filectime(sprintf("%s/%s", $path, $file));
                    $datesarr[] =  [$file => $file_creation_date];
                }
                ksort($datesarr);
                break;
            case "first_last":
                echo "date newest works";
                for ($i=0;$i<sizeof($files);$i++) {
                        $file = $files[$i+2];
                        $file_creation_date = filectime(sprintf("%s/%s", $path, $file));
                        $datesarr[] =  [$file_creation_date => $file];
                    }
                ksort($datesarr);
                print_r($datesarr);
                break;
            case "last_first":
                echo "date oldest works";
                for ($i=0;$i<sizeof($files);$i++) {
                    $file = $files[$i+2];
                    $file_creation_date = filectime(sprintf("%s/%s", $path, $file));
                    $datesarr[] =  [$file_creation_date => $file];
                }
                krsort($datesarr);
                print_r($datesarr);
                break;
        }
    }
}
?>