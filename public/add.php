<?php

include 'connect.php';

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Movie</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="styles/styles.css">

</head>

<body>
    <?php

    $sql = "INSERT INTO test (test_name, test_description) VALUES ('$test_name', '$test_description')";

    if (mysqli_query($conn, $sql)) {
        echo "<p>Information saved. </p>";

    } else {
        echo "<p> There was a problem saving the data. </p>";
        echo die(mysqli_error($conn));
    }


    ?>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="add-movie-container">
            <div class="required">
                <div class="inner-movie">


                    <label for="movie_title">Movie Title</label>
                    <input type="text" name="movie_title" id="movie_title" value="<?php if (isset($movie_title)) {
                        echo $movie_title;
                    } ?>">

                    <label for="imdb_link">IMDB Link</label>
                    <input type="text" name="imdb_link" id="imdb_link" value="<?php if (isset($imdb_link)) {
                        echo $imdb_link;
                    } ?>">

                    <label for="runtime">Runtime(in minutes)</label>
                    <input type="text" name="runtime" id="runtime" value="<?php if (isset($runtime)) {
                        echo $runtime;
                    } ?>">

                </div>
                <div class="inner-movie">

                    <label for="description">Description</label>
                    <textarea name="description" id="description"><?php if (isset($description)) {
                        echo $description;
                    } ?></textarea>
                </div>
            </div>
            <input type="submit" value="Add Movie" name="add">
        </div>

    </form>
</body>

</html>