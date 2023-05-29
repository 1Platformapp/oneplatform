<html>
	
	<head>

		<link type="text/css" href="/ckeditor/classic/sample/css/sample.css" rel="stylesheet" media="screen" />
		<link href="/css/ckeditor-apply.css" rel="stylesheet">
		<style>
			.ck-editor__editable_inline {
			    min-height: 300px;
			    overflow-y: scroll;
			}
		</style>
	</head>

	<body>
		<textarea id="project_story_text" name="project_story_text" style="width: 100%; height: 400px;">{!! $story_text !!}</textarea>
	</body>

	<script src="/ckeditor/classic/ckeditor.js"></script>
	<script type="text/javascript">
		ClassicEditor
        .create( document.querySelector( '#project_story_text' ), {
            // toolbar: [ 'heading', '|', 'bold', 'italic', 'link' ]
            ckfinder: {
                uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json',
            },
        } )
        .then( editor => {
            window.editor = editor;
        } )
        .catch( err => {
            console.error( err.stack );
        } );
	</script>

</html>