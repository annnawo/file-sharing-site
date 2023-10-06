<?php
session_start();
$username = $_SESSION["username"];
if( !preg_match('/^[\w_\-]+$/', $username) ){
    echo "Invalid username";
    exit;
}
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
  <title>File Sharing Home</title>
</head>
<body class="mgmt_main">
    <div class='mgmt_title'>
    <?php 
    printf("<h1 class='mgmt_h1'>%s's Files</h1>", $username);
    ?>
        <div class="logout_btn"><form action="logout.php" method="POST">
            <input type="submit" name="logout" value="Log Out" class="submit_mgmt submit_logout"/>
        </form></div>
    </div>
    <section class="view_open">
    <div class="mgmt_container view_open">
        <h2 class="mgmt_h2">Manage and View Your Files</h2>
        <div class="sort">
            <form action="" method="POST">
                <input type="submit" name="sort" value="Sort" class="sort_b"/>
                <input type="radio" name="sort_btn" id="alpha_asc" value="alpha_asc"><label for="alpha_asc">a-z</label>
                <input type="radio" name="sort_btn" id="alpha_des" value="alpha_des"><label for="alpha_des">z-a</label>
                <input type="radio" name="sort_btn" id="first_last" value="first_last"><label for="first_last">added (newest first)</label>
                <input type="radio" name="sort_btn" id="last_first" value="last_first"><label for="last_first">added (oldest first)</label>
        </form>
    </div>
        <form enctype="multipart/form-data" action="open_file.php" method="POST" target="_blank">
        <?php // Use scandir() to scan the user's directory and return the contents
        $path = sprintf("/srv/module2group/%s", $username);
        $files = scandir($path);
        $files = array_diff(scandir($path), array('.', '..')); // Remove the . and .. at the beginning of the scandir() array

        if (isset($_POST["sort"])) {
            if (isset($_POST["sort_btn"])) {
                $datesarr = array();
                $radioVal = $_POST["sort_btn"];
                switch ($radioVal) {
                    case "alpha_asc":
                        for ($i=0;$i<sizeof($files);$i++) {
                            $file = $files[$i+2];
                            $datesarr[] = $file;
                        }
                        natcasesort($datesarr); // Case-insensitive alphabetical sorting
                        foreach ($datesarr as $filename) {
                            printf("<input type='radio' class='radio_select' id='option_%s' name='open_file' value='%s'><label for='option_%s'> %s</label><br>", $filename, $filename, $filename, $filename, $filename);
                        }
                        break;
                    case "alpha_des":
                        for ($i=0;$i<sizeof($files);$i++) {
                            $file = $files[$i+2];
                            $datesarr[] = $file;
                        }
                        natcasesort($datesarr);
                        $datesarr = array_reverse($datesarr);
                        foreach ($datesarr as $filename) {
                            printf("<input type='radio' class='radio_select' id='option_%s' name='open_file' value='%s'><label for='option_%s'> %s</label><br>", $filename, $filename, $filename, $filename, $filename);
                        }
                        break;
                    case "first_last":
                        for ($i=0;$i<sizeof($files);$i++) {
                                $file = $files[$i+2];
                                $file_creation_date = filectime(sprintf("%s/%s", $path, $file));
                                $datesarr[$file] = $file_creation_date;
                            }
                        arsort($datesarr); // Sorts values in descending order
                        foreach ($datesarr as $filename => $file_creation_date) {
                            printf("<input type='radio' class='radio_select' id='option_%s' name='open_file' value='%s'><label for='option_%s'> %s</label><br>", $filename, $filename, $filename, $filename, $filename);
                        }
                        break;
                    case "last_first":
                        for ($i=0;$i<sizeof($files);$i++) {
                            $file = $files[$i+2];
                            $file_creation_date = filectime(sprintf("%s/%s", $path, $file));
                            $datesarr[$file] = $file_creation_date;
                        }
                        asort($datesarr); // Sorts values in ascending order
                        foreach ($datesarr as $filename => $file_creation_date) {
                            printf("<input type='radio' class='radio_select' id='option_%s' name='open_file' value='%s'><label for='option_%s'> %s</label><br>", $filename, $filename, $filename, $filename, $filename);
                        }
                        break;
                }
            }
        } else {
            for ($i=0;$i<sizeof($files);$i++) {
                $file = $files[$i+2];
                printf("<input type='radio' class='radio_select' id='option_%s' name='open_file' value='%s'><label for='option_%s'> %s</label><br>", $file, $file, $file, $file, $file);
            }
        }

        ?>
        <input type="submit" name="submit_open" value="View" class="submit_mgmt sm1"/>
        <input type="submit" name="submit_delete" value="Delete" class="submit_mgmt sm2"/>
        <input type="submit" name="submit_rename" value="Rename" class="submit_mgmt sm3"/>
        <input type="text" class="new_name" id="new_name" name="new_name" placeholder="new filename"> 
        </form>
    </div>
    </section>
    <section class="add">
        <div class="mgmt_container">
        <!-- UPLOAD FILE CODE -->
        <h2 class="mgmt_h2">Add a File</h2>
        <form enctype="multipart/form-data" action="path_gen.php" method="POST">
            <input type="hidden" name="MAX_FILE_SIZE" value="20000000" />
            <label for="uploadfile_input">Choose a file to upload:</label> <input name="uploadedfile" type="file" id="uploadfile_input"/><br>
            <input type="submit" name="submit_upload" value="Upload File" class="submit_mgmt"/>
        </form>
    </div>
    </section>
</body>
</html>
