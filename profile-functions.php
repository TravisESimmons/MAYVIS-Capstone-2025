<?php 

function delete_picture($user_id, $conn) {
	$sql = $conn->prepare("DELETE from profile_pictures WHERE user_id = ?");
	$sql->bind_param("i", $user_id);
	$sql->execute();
}

function is_user_in_contacts($user_id, $conn) {
    $sql = $conn->prepare("SELECT * from contacts WHERE user_id = ?");
    $sql->bind_param("i", $user_id);
    $sql->execute();

    $result = $sql->get_result();
    return $result->num_rows > 0;
}

function already_exists_in_users($check, $value, $conn) {
    $sql = $conn->prepare("SELECT * FROM users WHERE $check = ?");
    $sql->bind_param("s", $value);
    $sql->execute();

    $result = $sql->get_result();
    return $result->num_rows > 0;
}

 function resizeImage($file, $folder, $newwidth) {
	list($width, $height) = getimagesize($file);
	if($newwidth >= $width){// hack for images smaller than our resize
		$newwidth = $width;
	}
	$imgRatio = $width/$height;
	$newheight = $newwidth / $imgRatio;
	$thumb = imagecreatetruecolor($newwidth, $newheight);
	$source = imagecreatefromjpeg($file);
	imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

   


	$newFileName = $folder .  basename($file);// get original filename for dest filename

	imagejpeg($thumb,$newFileName,80);
	imagedestroy($thumb); 
	imagedestroy($source); 
}

function createSquareImageCopy($file, $folder, $newWidth){
	$thumb_width = $newWidth;
	$thumb_height = $newWidth;// tweak this for ratio
	list($width, $height) = getimagesize($file);
	$original_aspect = $width / $height;
	$thumb_aspect = $thumb_width / $thumb_height;
	if($original_aspect >= $thumb_aspect) {
	   // If image is wider than thumbnail (in aspect ratio sense)
	   $new_height = $thumb_height;
	   $new_width = $width / ($height / $thumb_height);
	} else {
	   // If the thumbnail is wider than the image
	   $new_width = $thumb_width;
	   $new_height = $height / ($width / $thumb_width);
	}
	$source = imagecreatefromjpeg($file);
	$thumb = imagecreatetruecolor($thumb_width, $thumb_height);
	// Resize and crop

	imagecopyresampled($thumb,
					   $source,0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
					   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
					   0, 0,
					   $new_width, $new_height,
					   $width, $height);
	

	$newFileName = $folder. "/" .basename($file);
	imagejpeg($thumb, $newFileName, 80);
	return $newFileName;
}








 ?>