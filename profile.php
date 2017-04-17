<?php
session_start();

if (!isset($_SESSION['userid'])) {
    header("Location: login.php");
}
include './header.php';
include './menu.php';
include './db_connection.php';
?>

<div class="container"> 
    <div class="row">

        <?php
        $name = "unknown";

        $statement = "select * from users where id = " . $_SESSION['userid'];
        if ($res = $conn->query($statement)) {
            if ($res->num_rows == 1) {
                $row = $res->fetch_assoc();

                $name = $row['username'];
            }
        }

        echo '<h2><b>Welcome</b>, ' . $name . '</h2>';
        ?>

        <hr class="medium">

    </div>

    <div class="row">

        <h3>Upload new image</h3>

        <div id="imgUpload">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title" class="imgLabelText">Title <span>Use title case to get a better result</span></label>
                    <input type="text" name="title" id="title" class="form-controll"/>
                </div>
                <div class="form-group">
                    <label for="caption" class="imgLabelText">Description <span>This caption should be descriptiv</span></label>
                    <input type="text" name="description" id="description" class="form-controll"/>
                </div>

                <div class="form-group file-area">
                    <label for="images" class="imgLabelText">Image <span>Should be at least 800px wide and smaller than 9MB</span></label>
                    <input type="file" name="fileToUpload" id="images" required="required"/>
                    <div class="file-dummy">
                        <div class="success">Great, your image is selected. :)</div>
                        <div class="default">Click to select an image.</div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" name="submitImage">Upload images</button>
                </div>
            </form> 
        </div>

        <?php
        if (isset($_POST['submitImage'])) {
            uploadImage();
        }

        function uploadImage() {

            global $conn;
            global $name;

            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
            // Check if image file is a actual image or fake image
            if (isset($_POST["submitImage"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if ($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }

            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            if ($_FILES["fileToUpload"]["size"] > 900000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            if (strcasecmp($imageFileType, "jpg") != 0 && strcasecmp($imageFileType, "png") != 0 && strcasecmp($imageFileType, "jpeg") != 0 &&  strcasecmp($imageFileType, "gif") != 0) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "<p>The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.</p>";

                    $description = "";
                    if (isset($_POST['description'])) {
                        $description = $conn->real_escape_string(htmlspecialchars(stripcslashes(trim($_POST['description']))));
                    }

                    $title = "";
                    if (isset($_POST['title'])) {
                        $title = $conn->real_escape_string(htmlspecialchars(stripcslashes(trim($_POST['title']))));
                    }

                    $statement = "INSERT INTO `posts` (id, image_url, title, description, post_date, username, likes, dislikes) VALUES (NULL, '" . $target_file . "', '" . $title . "', '" . $description . "', CURRENT_TIMESTAMP, '" . $name . "', '" . 0 . "', '" . 0 . "')";

                    if ($res = $conn->query($statement)) {
                        echo 'Image inserted';
                    } else {
                        echo "<p>" . $conn->error . "</p>";
                    }
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        }
        ?>

    </div>

</div>

<?php
include './footer.php';
?>