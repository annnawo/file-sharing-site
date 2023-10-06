<?php 
session_start();

// Check the filename
$filename = basename($_FILES['uploadedfile']['name']);
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

// If the user adds a file through file_mgmt.php, this statement will execute
if (isset($_POST["submit_upload"])) {
    if (move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $uploadPath)){
        header("Location: file_mgmt.php");
        exit;
    } else {
        echo "Sorry, the upload failed.";
        sleep(3);
        header("Location: file_mgmt.php");
        exit;
}}
?>