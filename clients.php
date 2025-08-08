<?php 
include "connect.php";
$title = "client list";

include 'includes/header-new.php';
?>

<?php 
 $sql = "SELECT * FROM clients";

 // echo $sql; 
 $result = mysqli_query($conn, $sql);

 if (mysqli_error($conn)) {
     $message = "<p>There was a problem searching</p>";
 } else {
     if (mysqli_num_rows($result) > 0) {
         $display = "<div class=\"bg-dark text-light justify-content-center\" >";
         while ($row = mysqli_fetch_assoc($result)) {
             $client_id = $row['client_id'];
             $client_name = $row['client_name'];



             $display .= "<h3>Id: $client_id</h3>";
             $display .= "<p>$client_name</p>";

         }
         $display .= "</div>";
         echo $display;
     } else {
         $message = "<p>Sorry no records to show</p>";
     }
 }

?>