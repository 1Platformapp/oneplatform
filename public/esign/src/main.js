$('document').ready(function(){

    var submitBtn = $('#signature-submit-button');
    $("#signature-file").change(function() {
        readURL(this, 'signature-image');
        $('#signature-prompt').addClass('instant_hide');
        $('#signature-result').removeClass('instant_hide');
        submitBtn.prop('disabled', false);
    });

    $("#signature-prompt, #signature-prompt svg, #signature-prompt span").click(function(e) {
        if(e.target !== e.currentTarget) return;
        $('#esign_popup,#body-overlay').show();
        $('#signature').empty();
        $(window).unbind('#signature');
        var $sigdiv = $("#signature").jSignature({'UndoButton':false, lineWidth: 1, height: 170, 'decor-color': 'transparent',});
        $('#reset').unbind('click').click(function(){

            $sigdiv.jSignature('reset');
            submitBtn.prop('disabled', true);
        });
        $('#submit_agreement_sign_draw').unbind('click').click(function(){

            var data = $sigdiv.jSignature('getData', 'default');
            $('#signature-prompt').addClass('instant_hide');
            $('#signature-result').removeClass('instant_hide').find('img').attr('src', data);
            submitBtn.prop('disabled', false);
            $('#esign_popup,#body-overlay').hide();
        });
    });

    $('#signature-result i').click(function(){

        $('#signature-prompt').removeClass('instant_hide');
        $('#signature-result').addClass('instant_hide').find('img').attr('src', '');
        submitBtn.prop('disabled', true);
    });

    submitBtn.click(function(e){

        e.preventDefault();
        if($('#signature-image').attr('src') == ''){

            alert('Add your signature');
        }else if($('#legal-name').val() == ''){

            alert('Enter your legal name');
        }else{

            $('#signature-form #signature-data').val($('#signature-image').attr('src'));
            $('#signature-form').submit();
        }
    })
});
