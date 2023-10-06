<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="styles.css">
  <link href="https://fonts.googleapis.com/css2?family=Schibsted+Grotesk:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
  <title>File Sharing Sign-In</title>
</head>
<body>
    <div class="login_layout">
        <div class="header_div"><h1 class="index_h1">Login to access your files.</h1></div>
          <form method="POST">
            <div class="form">
                <input type="text" class="username" id="username" name="username" placeholder="username" required> 
                <input type="submit" name="Submit" value="Submit" class="user_submit">
            </div>
          </form>
    </div>
    <?php
      if (isset($_POST['username'])) {
        $username = $_POST['username'];
        if(!preg_match('/^[\w_\-]+$/', $username) ){
          printf("<div class='error_msg'><p class='password_fail'>Invalid username; the username may only contain alphanumeric characters, underscores, and hyphens.</p></div>");
          exit;
        } else {
          $_SESSION["username"] = $username;
          header("Location: file_mgmt.php");
          exit;
        }
      }
    ?>
</body>
</html>