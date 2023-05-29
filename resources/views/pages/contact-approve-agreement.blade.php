


@extends('templates.basic-template')


@section('pagetitle') Review and sign the agreement @endsection

@section('pagekeywords') 
    
@endsection

@section('pagedescription') 
    
@endsection

<!-- Page Level CSS !-->
@section('page-level-css')
    <style type="text/css">
        
        .auto_content { width: 100%; }
        .document_outer { max-width: 1000px; width: 100%; margin: 50px auto 100px auto; }
        .document_outer .document_in { padding: 30px 10px 50px 10px; background: #fff; }
        .wrapper_outer { background-color: #efefef; }
        #esign_popup { width: 99%; max-width: 800px; }

        #sign_wrapper { font-family: Open sans, sans-serif; width: 100%; margin: 0 auto; position: relative; }
        #sign_wrapper div { margin-top:1em; margin-bottom:1em; }
        #sign_wrapper input { padding: .5em; margin: .5em; }
        #sign_content{ position: relative; }
        #signatureparent { color:#000; background-color:darkgrey; padding:20px; }
        #signature { border: 2px dotted black; background-color:lightgrey; }
        #reset { position: absolute; top: 45px; right: 30px; }
        html.touch #reset { font-size: 10px; }
        #signature_result i { cursor: pointer; font-size: 16px; }
        #signature_result #result_in { position: absolute; top: -20px; left: 335px; display: flex; }
        #signature_result img { max-width: 350px; }

        @media (min-width:320px) and  (max-width:767px) {

            .esign_submit { margin: 0 10px; }
        }

        @media (min-width:320px) and  (max-width:360px) {

            #signature_result img { max-width: 100%; }
            #signature_result #result_in { left: 95%; }
        }

        .btn_01 { background: #fff; width: 150px; text-align: center; padding: 10px; cursor: pointer; border: 1px solid #818181; text-transform: uppercase; font-size: 14px; }
        .btn_01:hover { background: #818181; color: #fff; } 
        
    </style>
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}" >
@stop

<!-- Page Level Javascript !-->
@section('page-level-js')
    
    <script src="{{asset('esign/libs/modernizr.js')}}"></script>
    <script src="{{asset('esign/src/jSignature.js')}}"></script>

    <script type="text/javascript">
        $('document').ready(function(){

            if (Modernizr.touch){
                      
            }

            $('#do_sign').click(function(){

                $('#esign_popup,#body-overlay').show();
                $('#signature').empty();
                $(window).unbind('#signature');
                var $sigdiv = $("#signature").jSignature({'UndoButton':false, lineWidth: 1, height: 170, 'decor-color': 'transparent',});
                $('#reset').unbind('click').click(function(){

                    $sigdiv.jSignature('reset');
                });

                $('#submit_agreement_sign_draw').unbind('click').click(function(){

                    var data = $sigdiv.jSignature('getData', 'default');
                    $('#add_your_signature').addClass('instant_hide');
                    $('#signature_result').removeClass('instant_hide').find('img').attr('src', data);
                    $('#esign_popup,#body-overlay').hide();
                });

                $('#signature_result i').click(function(){

                    $('#add_your_signature').removeClass('instant_hide');
                    $('#signature_result').addClass('instant_hide').find('img').attr('src', '');
                });

                $("#esign_scan_file").change(function() {

                    readURL(this, 'signature_image');
                    $('#add_your_signature').addClass('instant_hide');
                    $('#signature_result').removeClass('instant_hide');
                    $('#esign_popup,#body-overlay').hide();
                });
            });

            $('.esign_submit_button').click(function(e){

                e.preventDefault();
                if($('#signature_image').attr('src') != ''){

                    $('#esign_form #esign_data').val($('#signature_image').attr('src'));
                    $('#esign_form').submit();
                }else{
                    alert('Add your signature');
                }
            });
        });
    </script>
@stop

<!-- Page Header !-->
@section('header')
    @include('parts.header')
@stop


@section('flash-message-container')
    @if (Session::has('success'))
        <div class="success_span">{{ Session::get('success') }}</div>
    @endif
@stop


@section('social-media-html')
@stop


@section('page-content')
    
    <div class="document_outer">

        <div class="document_header">

        </div>
        <div class="document_in">

            @php $terms = preg_replace('/\r|\n/', '</td></tr><tr><td>', $review ? $contact->c_terms : $contact->terms) @endphp
            @include('pdf.agent-contact-agreement', ['agent' => $contact->agentUser, 'name' => $contact->name, 'email' => $contact->email, 'commission' => $review ? $contact->c_commission : $contact->commission, 'terms' => $terms, 'view' => ''])

            <div class="sign_outer">
                <table align="center" style="width:100%; padding-left: 12px; padding-right: 17px;" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:50px;width:55%;vertical-align:top;"></td>
                        <td style="width:30%;vertical-align:top;"></td>
                        <td style="width:15%;vertical-align:top;"></td>
                    </tr>
                    <tr id="add_your_signature">
                        <td style="color:#000;font-size: 20px; width:100%;vertical-align:bottom;">
                            <span id="do_sign" class="btn_01">
                                Add Your Signature
                            </span>
                        </td>
                        <td style="width:30%;vertical-align:top;"></td>
                        <td style="width:15%;vertical-align:top;"></td>
                    </tr>
                    <tr class="instant_hide" id="signature_result">
                        <td style="color:#000;font-size: 20px; width:100%;vertical-align:bottom;">
                            <span style="display:flex;position: relative;">
                                <img id="signature_image" src="">
                                <span id="result_in"><i class="fa fa-times-circle"></i></span>
                            </span>
                        </td>
                        <td style="width:30%;vertical-align:top;"></td>
                        <td style="width:15%;vertical-align:top;"></td>
                    </tr>
                    <tr>
                        <td style="height: 15px;width:55%;vertical-align:top;"></td>
                        <td style="width:30%;vertical-align:top;"></td>
                        <td style="width:15%;vertical-align:top;"></td>
                    </tr>
                    <tr>
                        <td style="color:#888;font-size: 14px;width:55%;vertical-align:bottom;border-top:1px solid;padding-top:5px;">
                            {{$contact->name}}'s signature
                        </td>
                        <td style="width:30%;vertical-align:top;"></td>
                        <td style="width:15%;vertical-align:top;"></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="esign_submit">
            <p style="font-size: 16px;color: #818181;margin: 50px 0;">
                If you approve the agreement and have added your valid signature you can click submit 
            </p>

            <div class="esign_submit_button btn_01">Submit</div>
            <form id="esign_form" class="instant_hide" action="{{route('agent.contact.verify.response')}}" method="POST">
                {{csrf_field()}}
                <input type="hidden" value="" id="esign_data" name="data">
                <input type="hidden" value="{{$contact->id}}" name="id">
            </form>
        </div>
    </div>

@stop

@section('miscellaneous-html')

    <div class="pro_page_pop_up clearfix" id="esign_popup">

        <div class="pro_soc_con_face_inner clearfix">

            <div class="soc_con_top_logo clearfix">

                <a style="opacity: 0;" class="logo8">
                    <img class="pro_soc_top_logo defer_loading" src="{{asset('images/1logo8.png')}}">
                    <div>Platform</div>
                </a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="main_headline">You can either draw or upload your signature</div><br>
            <div class="login_separator slim">
                <div class="login_separator_left"></div>
                <div class="login_separator_center">DRAW SIGNATURE</div>
                <div class="login_separator_right"></div>
            </div>
            <div class="esign_draw">
                <div id="sign_wrapper">
                    <div id="sign_content">
                        <div id="signatureparent">
                            <div id="signature"></div>
                        </div>
                        <button id="reset">Clear</button>
                    </div>
                </div>
                <div id="submit_agreement_sign_draw" class="pro_button">Add</div>
            </div><br>
            <div class="login_separator">
                <div class="login_separator_left"></div>
                <div class="login_separator_center">UPLOAD IMAGE / SCAN OF SIGNATURE</div>
                <div class="login_separator_right"></div>
            </div>
            <div class="esign_upload_scan">
                <div class="upload_sign_scan">
                    <br>
                    <div class="sign_scan_uploader">
                        <input type="file" id="esign_scan_file" />
                    </div>
                </div>
            </div>
            <br>
        </div>
    </div>
@stop