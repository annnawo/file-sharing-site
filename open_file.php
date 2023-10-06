<?php 
session_start();

// Check the filename
$filename = $_POST['open_file'];
if( !preg_match('/^[\w_\.\-]+$/', $filename) ){
	echo "Invalid filename";
	exit;
}

// Check the username
$username = $_SESSION["username"];
if( !preg_match('/^[\w_\-]+$/', $username) ){
    echo "Invalid username";
    exit;
}

$uploadPath = sprintf("/srv/module2group/%s/%s", $username, $filename);

// Executes if the user selects to view the radio selection
if (isset($_POST["submit_open"])) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($uploadPath);
    header("Content-Type: ".$mime);
    header('content-disposition: inline; filename="'.$filename.'";');
    readfile($uploadPath);
    exit;
}

// Executes if the user selects to delete the radio selection
if (isset($_POST["submit_delete"])) {
    if (!unlink($uploadPath)) {
        echo ("The file cannot be deleted due to an error");
    }
    else {
        echo ("$uploadPath has been successfully deleted");
        header("Location: file_mgmt.php");
    }
}

if (isset($_POST["submit_rename"])) {
    if (empty($_POST["new_name"])) {
        echo "Invalid file name";
        exit;
    } else {
        $updatedname = $_POST['new_name'];
        if( !preg_match('/^[\w_\.\-]+$/', $updatedname) ){
            echo "Invalid filename";
            exit;
        } else {
            $ext = strrchr($filename, '.'); // Get the extension by splitting the orignal file name
            $updatedname = sprintf("%s%s", $updatedname, $ext);
            $newPath = sprintf("/srv/module2group/%s/%s", $username, $updatedname);
            rename($uploadPath, $newPath);
            header("Location: file_mgmt.php");
        }
    }
}
?>