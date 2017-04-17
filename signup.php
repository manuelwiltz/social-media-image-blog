<?php
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
    if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password1']) && isset($_POST['password2'])) {
        $errors = [];

        $firstname = $conn->real_escape_string(htmlspecialchars(stripcslashes(trim($_POST['firstname']))));
        $lastname = $conn->real_escape_string(htmlspecialchars(stripcslashes(trim($_POST['lastname']))));

        $username = $conn->real_escape_string(htmlspecialchars(stripcslashes(trim($_POST['username']))));
        $email = $conn->real_escape_string(htmlspecialchars(stripcslashes(trim($_POST['email']))));

        $password1 = md5($conn->real_escape_string(htmlspecialchars(stripcslashes(trim($_POST['password1'])))));
        $password2 = md5($conn->real_escape_string(htmlspecialchars(stripcslashes(trim($_POST['password2'])))));

        $statement = "SELECT * FROM users where username = " . $username . ";";
        if ($res = $conn->query($statement)) {
            if ($res->num_rows > 0) {
                array_push($errors, "<p>Username is allready taken!</p>");
            }
        }

        if (!($password1 === $password2)) {
            array_push($errors, "<p>Passwords do not match!</p>");
        }

        if (count($errors) == 0) {

            $statement = "INSERT INTO users (id, username, firstname, lastname, email, password, create_date, points) VALUES (NULL, '" . $username . "', '" . $firstname . "', '" . $lastname . "', '" . $email . "', '" . $password1 . "', CURRENT_TIMESTAMP," .  0 . ");";
        
            if ($res = $conn->query($statement)) {
                header("Location: login.php");
            }
            
        } else {
            foreach ($errors as $error) {
                echo '<div class="row">';
                echo $error;
                echo '</div>';
            }
        }
    }
    ?>

    <div class="row">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
                <label for="text">Firstname:</label>
                <input type="text" class="form-control" name="firstname" placeholder="Enter firstname">
            </div>
            <div class="form-group">
                <label for="text">Lastname:</label>
                <input type="text" class="form-control" name="lastname" placeholder="Enter lastname">
            </div>
            <div class="form-group">
                <label for="text">Username:</label>
                <input type="text" class="form-control" name="username" placeholder="Enter username">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" name="password1" placeholder="Enter password">
            </div>
            <div class="form-group">
                <label for="pwd">Repeat password:</label>
                <input type="password" class="form-control" name="password2" placeholder="Enter password again">
            </div>
            <button type="submit" class="btn btn-default">Signup</button>
        </form>
        <p class="padding-md">Allready have an account? <a href="login.php">Login yet!</a></p>
    </div>

</div>

<?php
include './footer.php';
?>