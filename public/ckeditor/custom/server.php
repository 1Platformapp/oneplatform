<?php 
	// connect to database
	$db = mysqli_connect("127.0.0.1", "theaudit_joynew", "redhat123", "theaudit_joy");

	// retrieve posts from database
	$result = mysqli_query($db, "SELECT * FROM posts");


	// if 'upload image' buttton is clicked
	if (isset($_POST['uploading_file'])) {
		// Get image name
	  	$image = $_FILES['post_image']['name'];

	  	// image file directory
	  	$target = "images/" . basename($image);

	  	if (move_uploaded_file($_FILES['post_image']['tmp_name'], $target)) {
	  		echo "http://alpha.theaudition.tv/ckeditor/custom/" . $target;
	  		exit();
	  	}else{
	  		echo "Failed to upload image";
	  		exit();
	  	}
	}

	// if form save button is clicked, save post in the database
	if (isset($_POST['save-post'])) {
		$title = mysqli_real_escape_string($db, $_POST['title']);
		$body = htmlentities(mysqli_real_escape_string($db, $_POST['body']));

		$sql = "INSERT INTO posts (title, body) VALUES ('$title', '$body')";
		mysqli_query($db, $sql);
		header("location: index.php");
	}
?>