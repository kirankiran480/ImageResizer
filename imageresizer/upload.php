<?php
require 'PHPMailerAutoload.php';
$target_dir = "uploads/";
  $num_files = count($_FILES["fileToUpload"]["name"]);
  if($num_files > 6)
  {
  	echo "Please Upload only 6 files";
  	exit();
  }
   $email = $_POST["email"];
			  $resolution = $_POST["resolution"];
for($i=0; $i < $num_files;$i++)
        {
            // check if there is a file in the array

             $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
			

			$uploadOk = 1;
			$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
			    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"][$i]);

			 
			 
			    if($check !== false) {
			        echo "File is an image - " . $check["mime"] . ".";
			        $uploadOk = 1;
			    } else {
			        echo "File is not an image.";
			        $uploadOk = 0;
			    }
			}
			// Check if file already exists
			if (file_exists($target_file)) {
			    echo "Sorry, file already exists.";
			    $uploadOk = 0;
			}
		
			// Allow certain file formats
			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			    $uploadOk = 0;
			}
			// Check if $uploadOk is set to 0 by an error
			if ($uploadOk == 0) {
			    echo "Sorry, your file was not uploaded.";
			// if everything is ok, try to upload file
			} else {
				
			    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file)) {
			       
			         
			          if($resolution == 1)
			          {
			          	$width =  700;
			          	$height = 300;
			          }
			          elseif ($resolution == 2) {
			          		$width =  500;
			          	$height = 200;
			          }
			          elseif ($resolution == 3) {
			         	$width =  100;
			          	$height = 100;
			          }
			        $img = resize_image($target_file, $width, $height);
			        sendmail($target_file,$email);
 echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been resized and sent to $email.";
			     
			    } else {
			        echo "Sorry, there was an error uploading your file.";
			    }
			}
           
        }



function sendmail($file,$emailid)
{

$email = new PHPMailer();
$email->SetFrom('kirankiran480@gmail.com', "Picxel");
$email->FromName  = 'Picxel';
$email->AddReplyTo('no-reply@picxel.com','no-reply');
$email->Subject   = 'your resized images';
$email->MsgHTML("test");
$email->AddAddress($emailid);
$email->CharSet = 'UTF-8';
$email->IsSMTP();
$email->Host = 'smtp.gmail.com';
$email->SMTPSecure = 'tls';
$email->Port       = 587;
$email->SMTPDebug  = 1;
$email->SMTPAuth   = false; //set it to true to work
$email->Username   = 'example@gmail.com';//changeit to mail id 
$email->Password   = 'Qfrererer'; // give exact password of mailid
$email->SMTPDebug   = 0;
$file_to_attach = $file;

$email->AddAttachment($file_to_attach);

$email->Send();


}


function resize_image($file, $w, $h, $crop=FALSE) {
    list($width, $height,$image_type) = getimagesize($file);

    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    switch ($image_type)
    {
        case 1: $src = imagecreatefromgif($file); break;
        case 2: $src = imagecreatefromjpeg($file);  break;
        case 3: $src = imagecreatefrompng($file); break;
        default: return '';  break;
    }

   $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    switch ($image_type)
    {
        case 1: imagegif($dst,$file); break;
        case 2: imagejpeg($dst,$file);  break; // best quality
        case 3: imagepng($dst,$file); break; // no compression
        default: echo ''; break;
    }
     

    return $dst;
}


?>