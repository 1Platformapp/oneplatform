<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="/css/style.css" rel="stylesheet" type="text/css" />

    <script src="/js/jquery.min.js" type="text/javascript"></script>


    <script>

        $(document).ready(function(){

            // rich text area drag n drop
            $("#richTextFieldInner").on('dragenter', function (e){
                e.preventDefault();
                //$(this).css('background', '#ccc');
            });

            $("#richTextFieldInner").on('dragover', function (e){
                e.preventDefault();
            });

            $('#editor-body').on('paste', function (e) {
                if (e.originalEvent.clipboardData) {
                    var text = e.originalEvent.clipboardData.getData("text/plain");
                    if($("#paragraph").length){
                        $("#paragraph").append(text);
                    }else{
                        $("#editor-body").append(text);
                    }
                    //insertAtCaret('paragraph', text);
                    return false;
                }
            });

        });

        function setEditorText(){
            var html = document.getElementById('editor-body').innerHTML;
            document.getElementById('editor-body').innerHTML = html.replace(/<\/?[^>]+(>|$)/g, "");

        }

        function insertAtCaret(areaId, text) {
            var txtarea = document.getElementById(areaId);
            if (!txtarea) { return; }

            var scrollPos = txtarea.scrollTop;
            var strPos = 0;
            var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
                    "ff" : (document.selection ? "ie" : false ) );
            if (br == "ie") {
                txtarea.focus();
                var range = document.selection.createRange();
                range.moveStart ('character', -txtarea.innerHTML.length);
                strPos = range.text.length;
            } else if (br == "ff") {
                strPos = txtarea.selectionStart;
            }

            var front = (txtarea.innerHTML).substring(0, strPos);
            var back = (txtarea.innerHTML).substring(strPos, txtarea.innerHTML.length);
            txtarea.innerHTML = front + text + back;
            strPos = strPos + text.length;
            if (br == "ie") {
                txtarea.focus();
                var ieRange = document.selection.createRange();
                ieRange.moveStart ('character', -txtarea.innerHTML.length);
                ieRange.moveStart ('character', strPos);
                ieRange.moveEnd ('character', 0);
                ieRange.select();
            } else if (br == "ff") {
                txtarea.selectionStart = strPos;
                txtarea.selectionEnd = strPos;
                txtarea.focus();
            }

            txtarea.scrollTop = scrollPos;
        }

    </script>

    <style>
        #editor-body { line-height: 20px; }
    </style>

</head>

<body id="editor-body">


    <?php
    $str = preg_replace("/[^a-zA-Z0-9]+/", "", html_entity_decode($profile->story_text, ENT_QUOTES));
    if(strpos($str, "richTextFieldInner") !== false || true){
        echo html_entity_decode($profile->story_text);
    }else{
    ?>
    <div style="width: 290px; height: 100%;" id="richTextFieldInner" class="bold_class">
        <p id="paragraph" style="letter-spacing: 0.25px; text-align: justify; margin: 0 10px 0 0;">
            <?php echo html_entity_decode($profile->story_text); ?>
        </p>
    </div>
    <?php }?>


</body>

