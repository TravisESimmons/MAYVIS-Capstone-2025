<?php
include('connect.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mayvis</title>

    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
<?php 
        include 'includes/header.php';

        ?>
<?php 
    $sql = "SELECT * FROM deliverables";

    // echo $sql; 
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_error($conn)) {
        $message = "<p>There was a problem searching</p>";
    } else {
        if (mysqli_num_rows($result) > 0) {
            $display = "<div class=\"row g-3\" >";
    
            while ($row = mysqli_fetch_assoc($result)) {
                $title = $row['title'];
                $description = $row['description'];
                $deliverable_id = $row['deliverable_id'];
                $price = $row['price'];
                $category = $row['category'];
    
    
               
    
                $display .= "<div class=\"col-6\">";
                $display .= "<div class=\"card\"><p>$title</p>";
                $display .= "<p>$description</p>";
    
                $display .= "<p>Price: $price</p>";
                $display .= "<p>Category: $category</p>";
    
    
                $display .= "</div></div>";
    
        
            }
            $display .= "</div>";
            echo $display;
        } else {
            $message = "<p>Sorry no records to show</p>";
        }
    }
    

?>
</body>
</html>