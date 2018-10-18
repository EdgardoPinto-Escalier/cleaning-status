<?php
/////////////////////////////////////////////
/// Edgardo Pinto-Escalier
/// Project name - Cleaning Status
/// File name: pictureUploads.class.php
/////////////////////////////////////////////

// This class has to main methods one that takes care of the user avatar picture upload
// and the other one that takes care of the blog post picture upload.

class pictureUploads {
	private $_db;

	public function __construct() {
		$this->_db = dbConnection::getInstance();

	}

	// Here what we do is to take care of the user avatar upload.
	public function uploadAvatar() {

		// First we specify all the extension formats allowed.
		$allowedExtensions = array("gif", "jpeg", "jpg", "png");
		//for registration
		if(isset($_FILES["avatar"]["name"])){
			// Here we use the end function to grab the extension format and putted into a variable $extension.
			$temp =  explode(".", $_FILES["avatar"]["name"]);
										$extension = end($temp);

				if ((($_FILES["avatar"]["type"] == "image/gif")
				|| ($_FILES["avatar"]["type"] == "image/jpeg")
				|| ($_FILES["avatar"]["type"] == "image/jpg")
				|| ($_FILES["avatar"]["type"] == "image/pjpeg")
				|| ($_FILES["avatar"]["type"] == "image/x-png")
				|| ($_FILES["avatar"]["type"] == "image/png"))
				// Here we check that the images are less then 4mb.
				&& ($_FILES["avatar"]["size"] < 40000000)
				&& in_array($extension, $allowedExtensions)
				) {

			// Another if statement to check in case of error redirect to register.php along with the error message.
			if ($_FILES["avatar"]["error"] > 0) {
				echo 'Error'. $_FILES["avatar"]["error"] . '<br/>';
			} else {
				if (file_exists("images/userAvatars/" . $_FILES["avatar"]["name"])) {
					echo 'File already exists';
				} else {
					// Here we use the move_uploaded_file function to move all uploaded avatars to the right folder.
					move_uploaded_file($_FILES["avatar"]["tmp_name"],
					"images/userAvatars/" . $_FILES["avatar"]["name"]);

					
					
					
					// If everything goes ok we return true.
					return true;
				}
			}
			
			} else {
				// If there is any problems we show an invalid message.
				echo '<p>Invalid file type...</p>';

			}
		}elseif(isset($_FILES["edit_avatar"]["name"])){ 	//for edit profile
			// Here we use the end function to grab the extension format and putted into a variable $extension.
			$temp =  explode(".", $_FILES["edit_avatar"]["name"]);
			$extension = end($temp);

				if ((($_FILES["edit_avatar"]["type"] == "image/gif")
				|| ($_FILES["edit_avatar"]["type"] == "image/jpeg")
				|| ($_FILES["edit_avatar"]["type"] == "image/jpg")
				|| ($_FILES["edit_avatar"]["type"] == "image/pjpeg")
				|| ($_FILES["edit_avatar"]["type"] == "image/x-png")
				|| ($_FILES["edit_avatar"]["type"] == "image/png"))
				// Here we check that the images are less then 1mb.
				&& ($_FILES["edit_avatar"]["size"] < 40000000)
				&& in_array($extension, $allowedExtensions)
				) {


			// Another if statement to check in case of error redirect to register.php along with the error message.
			if ($_FILES["edit_avatar"]["error"] > 0) {
				echo 'Error'. $_FILES["edit_avatar"]["error"] . '<br/>';
			} else {
				if (file_exists("images/userAvatars/" . $_FILES["edit_avatar"]["name"])) {
					echo 'File already exists';
				} else {
					// Here we use the move_uploaded_file function to move all uploaded avatars to the right folder.
					move_uploaded_file($_FILES["edit_avatar"]["tmp_name"],
					"images/userAvatars/" . $_FILES["edit_avatar"]["name"]);				
					
					// If everything goes ok we return true.
					return true;
				}
			}
			
		} else {
			// If there is any problems we show an invalid message.
			echo '<p>Invalid file type...</p>';
		}
		}

		if(empty($temp))
			return false;

		// Next with this if statement we check if all the extension formats are valid.
	} 


	// With this public method uploadPostPicture what we do is to take care of the blog post upload procedure.
	public function uploadPostPicture() {

		// First we specify all the extension formats allowed.
		if(isset($_FILES["post_image"])){
			$allowedExtensions = array("gif", "jpeg", "jpg", "png");
			$temp = explode(".", $_FILES["post_image"]["name"]);
			// Here we use the end function to grab the extension format and putted into a variable $extension.
			$extension = strtolower(end($temp));
			// Next with this if statement we check if all the extension formats are valid.
			// echo $extension;die();
			if ((($_FILES["post_image"]["type"] == "image/gif")
					|| ($_FILES["post_image"]["type"] == "image/jpeg")
					|| ($_FILES["post_image"]["type"] == "image/jpg")
					|| ($_FILES["post_image"]["type"] == "image/pjpeg")
					|| ($_FILES["post_image"]["type"] == "image/x-png")
					|| ($_FILES["post_image"]["type"] == "image/png"))
					// Here we check that the images are less then 3mb.
					&& ($_FILES["post_image"]["size"] < 3000000)
					&& in_array($extension, $allowedExtensions)
					) {
				// Another if statement to check in case of error redirect to register.php along with the error message.
				if ($_FILES["post_image"]["error"] > 0) {
					echo 'Error'. $_FILES["post_image"]["error"] . '<br/>';
				} else {
					if (file_exists("images/" . $_FILES["post_image"]["name"])) {
						echo 'File already exists';
					} else {
						// Here we use the move_uploaded_file function to move all uploaded avatars to the right folder.
						move_uploaded_file($_FILES["post_image"]["tmp_name"],
						"images/" . $_FILES["post_image"]["name"]);

						
						
						
						// If everything goes ok we return true.
						return true;
					}
				}
				
			} else {
				// If there is any problems we show an invalid message.
				echo '<p>Invalid file type...</p>';
			}
		}
	}
}
