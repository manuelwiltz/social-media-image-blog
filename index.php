<?php
include './header.php';
include './menu.php';
include './db_connection.php';
?>

<div class="container">

    <div class="row">
        <h2>Top images: </h2>
        <hr class="medium">
    </div>

</div>

<div class="container">
    <?php
    $statement = "Select * from posts;";

    if ($res = $conn->query($statement)) {
        if ($res->num_rows > 0) {

            while ($row = $res->fetch_assoc()) {
                $path = $row['image_url'];
                $title = $row['title'];
                $description = $row['description'];
                $username = $row['username'];
                $post_date = $row['post_date'];

                echo '<div class="row">';
                echo '<h3><b>' . $title . '</b></h3>';
                echo '<img src="' . $path . '" alt="Image" class="main-image">';
                echo '<h4><b>' . $username . '</b> posted this at ' . $post_date . '</h4>';
                echo '<p>' . $description . '</p>';
                echo '</div>';
                echo '<hr class="medium">';
            }
        } else {
            echo "<h2>No images available, sorry :(</h2>";
        }
    }
    ?>
</div>



<?php
include './footer.php';
?>