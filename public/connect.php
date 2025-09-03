<?php 

// $conn = mysqli_connect("localhost", "emah10", "MfyowmbyZXRFLvp", "emah10_dmit2590");

$conn = mysqli_connect('localhost', 'root', '', 'mayvis');


if (mysqli_connect_errno()) {
    echo "failed to connect to MySQL" . mysqli_connect_error();
} else {
   // echo "Yay we are connected";
}

?>