<?php
// error_reporting(E_ALL);
// ini_set('display_errors', '1');

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

function uploadtoS3($path) {
	// echo "<Br>".$path."<Br>";
	include_once 'global/connect.php';
	// AWS Info
	// Already defined in connect.php
    $IAM_KEY = $_SERVER['IAM_ACCESS_KEY'];
	$IAM_SECRET = $_SERVER['IAM_ACCESS_SECRET'];
	$REGION = $_SERVER['S3_REGION'];
	$BUCKET = $_SERVER['BUCKET'];
	// Connect to AWS
	try {
		// You may need to change the region. It will say in the URL when the bucket is open
		// and on creation. us-east-2 is Ohio, us-east-1 is North Virgina
		$s3 = S3Client::factory(
			array(
				'credentials' => array(
					'key' => $IAM_KEY,
					'secret' => $IAM_SECRET
				),
				'version' => 'latest',
				'region'  => $REGION
			)
		);
        // echo "Checkpoint A";
	} catch (Exception $e) {
		// We use a die, so if this fails. It stops here. Typically this is a REST call so this would
		// return a json object.
        // echo "Checkpoint B";
		die("Error: " . $e->getMessage());
	}
    // echo "Checkpoint 2";
	
	$fileURL = $path; // Change this

	// For this, I would generate a unqiue random string for the key name. But you can do whatever.
	$keyName = 'assets/uploads/' . basename($fileURL);
	
	$pathInS3 = 'https://'.$BUCKET.'.s3.'.$REGION.'.amazonaws.com/' . $keyName;
	// Add it to S3
	try {
		// You need a local copy of the image to upload.
		// My solution: http://stackoverflow.com/questions/21004691/downloading-a-file-and-saving-it-locally-with-php
		if (!file_exists('test/uploads')) {
			mkdir('test/uploads');
		}
				
		$tempFilePath = basename($fileURL);
        // $tempFilePath = $path;
		$tempFile = fopen($tempFilePath, "w") or die("Error: Unable to open file.");
		$fileContents = file_get_contents($fileURL);
		$tempFile = file_put_contents($tempFilePath, $fileContents);

		$s3->putObject(
			array(
				'Bucket'=>$BUCKET,
				'Key' =>  $keyName,
				'SourceFile' => $tempFilePath,
				'StorageClass' => 'REDUCED_REDUNDANCY',
				'ACL' => 'public-read'
			)
		);

		// WARNING: You are downloading a file to your local server then uploading
		// it to the S3 Bucket. You should delete it from this server.
		// $tempFilePath - This is the local file path.

	} catch (S3Exception $e) {
		die('Error:' . $e->getMessage());
	} catch (Exception $e) {
		die('Error:' . $e->getMessage());
	}


	return $pathInS3;

	// Now that you have it working, I recommend adding some checks on the files.
	// Example: Max size, allowed file types, etc.
}

function uploadtoLocal($myfile, $imageOnly){
	
    $filename = basename($myfile["name"]);
    $filename = explode(".", $filename);
    $filename = substr(md5(microtime()), 0, 24).".".$filename[count($filename)-1];
    // echo $filename;
    $target_dir = "test/uploads/";
    $target_file = $target_dir . $filename;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if ($imageOnly == 1){
		$check = getimagesize($myfile["tmp_name"]);
		if($check !== false) {
			// echo "File is an image - " . $check["mime"] . ".";
			$uploadOk = 1;
		} else {
			echo "File is not an image.";
			$uploadOk = 0;
		}
	}

    // Check if file already exists
    if (file_exists($target_file)) {
    	return makeJSON(203, "Sorry, file already exists.");
    	$uploadOk = 0;
    }

    // Check file size
    if ($myfile["size"] > 80000000) {
		return makeJSON(203, "Sorry, your file is too large.");
    	$uploadOk = 0;
    }
	
	if ($imageOnly == 1) {
    // Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			return makeJSON(203, "Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
			$uploadOk = 0;
		}
	}

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    	return makeJSON(203, "Sorry, your file was not uploaded.");
    // if everything is ok, try to upload file
    } else {
		if (move_uploaded_file($myfile["tmp_name"], $target_file)) {
			// echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
			// echo $target_file;
			return makeJSON(200, uploadtoS3($target_file));
		} else {
			return makeJSON(203, "Sorry, there was an error uploading your file.");
		}
    }
}

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
	
	// $path = echo uploadtoLocal($_FILES["fileToUpload"]);
    // print_r($path);
	$imageOnly = $_POST['imageOnly'];
	
    $return = uploadtoLocal($_FILES["fileToUpload"], $imageOnly);
    $return = json_decode($return);
    if ($return->status == 200) {
		
		if ($_POST['page'] == "create") {
        	header('location: '.$_SERVER['SCRIPT_NAME']."?imgpath=".$return->msg);
		}
		if ($_POST['page'] == "edit") {
			mysqli_query($con, "UPDATE assets SET attachment='".$return->msg."' WHERE assetid='".$_POST['id']."'");
			header('location: edit?id='.$_POST['id']);
		}
    }
} 
?>