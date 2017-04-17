<?php
session_start();

include './header.php';
include './menu.php';
include './db_connection.php';
?>

<div class="container">
    <div class="row padding-md">
        <h2>Register to PicBlog</h2>
        <p>Hi, create an account to upload, share and view great images.</p>
        <hr class="medium">
    </div>

    <?php
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $errors = [];

        $username = $conn->real_escape_string(htmlspecialchars(stripcslashes(trim($_POST['username']))));
        $password = md5($conn->real_escape_string(htmlspecialchars(stripcslashes(trim($_POST['password'])))));

        $statement = "select * from users where username = '" . $username . "';";
        if ($res = $conn->query($statement)) {

            if ($res->num_rows == 1) {

                $row = $res->fetch_assoc();

                if (($row['username'] == $username) && ($row['password'] == $password)) {
                    $_SESSION['userid'] = $row['id'];
                    header("Location: profile.php");
                } else {
                    array_push($errors, "<p>Incorrec username or passwordt!</p>");
                }
            } else {
                array_push($errors, "<p>Incorrect username or password!</p>");
            }
        } else {
            array_push($errors, "<p>An error occured!</p>");
        }

        if (count($errors) > 0) {
            foreach ($errors as $value) {
                echo '<h2 class="text-center" style="color: red;">' . $value . '</h2>';
            }
        }
    }
    ?>

    <div class="row">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label for="text">Username:</label>
                <input type="text" class="form-control" name="username" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" name="password" placeholder="Enter password">
            </div>

            <button type="submit" class="btn btn-default">Login</button>
        </form>
        <p class="padding-md">Have no account? <a href="signup.php">Register yet!</a></p>
    </div>

</div>

<?php
include './footer.php';
?>