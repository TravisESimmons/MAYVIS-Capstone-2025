<?php 

// Check if GD extension is loaded
if (!extension_loaded('gd')) {
    die('Error: GD extension is not loaded. Please enable GD extension in php.ini and restart Apache.');
}

// Check if required GD functions exist
if (!function_exists('imagecreatefromjpeg')) {
    die('Error: imagecreatefromjpeg() function is not available. Please check GD installation.');
}

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

function getImageResource($file) {
    $imageType = exif_imagetype($file);
    
    switch ($imageType) {
        case IMAGETYPE_JPEG:
            return imagecreatefromjpeg($file);
        case IMAGETYPE_PNG:
            return imagecreatefrompng($file);
        case IMAGETYPE_GIF:
            return imagecreatefromgif($file);
        default:
            throw new Exception("Unsupported image type. Please use JPEG, PNG, or GIF.");
    }
}

function saveImageResource($image, $file, $quality = 80) {
    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    
    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            return imagejpeg($image, $file, $quality);
        case 'png':
            return imagepng($image, $file);
        case 'gif':
            return imagegif($image, $file);
        default:
            return imagejpeg($image, $file, $quality); // Default to JPEG
    }
}

 function resizeImage($file, $folder, $newwidth) {
    try {
        if (!file_exists($file)) {
            throw new Exception("Source file does not exist: $file");
        }
        
        list($width, $height) = getimagesize($file);
        if($newwidth >= $width){// hack for images smaller than our resize
            $newwidth = $width;
        }
        $imgRatio = $width/$height;
        $newheight = $newwidth / $imgRatio;
        $thumb = imagecreatetruecolor($newwidth, $newheight);
        $source = getImageResource($file);
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        $newFileName = $folder .  basename($file);// get original filename for dest filename
        
        if (!is_dir(dirname($newFileName))) {
            mkdir(dirname($newFileName), 0755, true);
        }

        saveImageResource($thumb, $newFileName, 80);
        imagedestroy($thumb); 
        imagedestroy($source);
        
        return $newFileName;
    } catch (Exception $e) {
        error_log("Image resize error: " . $e->getMessage());
        return false;
    }
}

function createSquareImageCopy($file, $folder, $newWidth){
    try {
        if (!file_exists($file)) {
            throw new Exception("Source file does not exist: $file");
        }
        
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
        $source = getImageResource($file);
        $thumb = imagecreatetruecolor($thumb_width, $thumb_height);
        // Resize and crop

        imagecopyresampled($thumb,
                           $source,0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                           0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                           0, 0,
                           $new_width, $new_height,
                           $width, $height);
        
        if (!is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $newFileName = $folder. "/" .basename($file);
        saveImageResource($thumb, $newFileName, 80);
        imagedestroy($thumb);
        imagedestroy($source);
        
        return $newFileName;
    } catch (Exception $e) {
        error_log("Square image creation error: " . $e->getMessage());
        return false;
    }
}