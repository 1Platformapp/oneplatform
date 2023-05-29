<?php include('server.php') ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Uploading images in CKEditor using PHP</title>
	<!-- Bootstra CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />

	<!-- Custom styling -->
	<link rel="stylesheet" href="main.css">
</head>
<body>
	
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 post-div">

			<!-- Display a list of posts from database -->
			<?php if (isset($result)): ?>
				<?php while( $row = mysqli_fetch_assoc( $result ) ){ ?>
					<div class="post">
						<h3>
							<a href="details.php?id=<?php echo $row['id'] ?>"><?php echo $row['title'] ?></a>
						</h3>
						<p><?php echo $row['body']; ?></p>
					</div>
				<?php } ?>
			<?php else: ?>
				<h2>No posts available</h2>
			<?php endif ?>

			<!-- Form to create posts -->
			<form action="index.php" method="post" enctype="multipart/form-data" class="post-form">
				<h1 class="text-center">Add Blog Post</h1>
				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" name="title" class="form-control" >
				</div>

				<div class="form-group" style="position: relative;">
					<label for="post">Body</label>
					
					<!-- Upload image button -->
					<a href="#" class="btn btn-xs btn-default pull-right upload-img-btn" data-toggle="modal" data-target="#myModal">upload image</a>

					<!-- Input to browse your machine and select image to upload -->
					<input type="file" id="image-input" style="display: none;">

					<textarea name="body" id="body" class="form-control" cols="30" rows="5"></textarea>

					</div>
					<div class="form-group">
						<button type="submit" name="save-post" class="btn btn-success pull-right">Save Post</button>
					</div>
			</form>

			<!-- Pop-up Modal to display image URL -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Click below to copy image url</h4>
			      </div>
			      <div class="modal-body">
					<!-- returned image url will be displayed here -->
					<input 
						type="text" 
						id="post_image_url" 
						onclick="return copyUrl()" 
						class="form-control"
						>
					<p id="feedback_msg" style="color: green; display: none;"><b>Image url copied to clipboard</b></p>
			      </div>
			    </div>
			  </div>
			</div>
		</div>

	</div>
</div>

<!-- JQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- CKEditor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.8.0/ckeditor.js"></script>

<!-- custom scripts -->
<script src="scripts.js"></script>

</body>
</html>