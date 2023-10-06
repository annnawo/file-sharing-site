<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out</title>
</head>
<body>
    <p>Logging out.</p>
    <p>Redirecting back to sign-in page.</p>
</body>
</html>
<?php
if (isset($_POST["logout"])) {
    sleep(2);
    session_unset();
    session_destroy();
    header("Location: index.php");
}
?>