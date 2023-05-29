<html>
	
	<head>

		<link type="text/css" href="/ckeditor/classic/sample/css/sample.css" rel="stylesheet" media="screen" />
		<link href="/css/ckeditor-apply.css?v=1.1" rel="stylesheet">
		<style>
			.ck.ck-editor__main>.ck-editor__editable:not(.ck-focused){ border: none; }
			.ck.ck-editor__main>.ck-editor__editable { background: rgb(39, 40, 42); color: #fff; }
		</style>
	</head>

	<body>
		<div class="ck ck-reset ck-editor ck-rounded-corners" role="application" dir="ltr" lang="en" aria-labelledby="ck-editor__aria-label_e01b6e74c75125c6a0fa6e9e284bf8a60">
			<div class="ck ck-editor__main" role="presentation">
				<div class="ck ck-content ck-editor__editable ck-rounded-corners ck-blurred ck-editor__editable_inline" role="textbox" aria-label="Rich Text Editor, main">
					{!! $story_text !!}
				</div>
			</div>
		</div>
	</body>
</html>