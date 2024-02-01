
@extends('templates.basic-template')


@section('pagetitle')  @endsection


<!-- Page Level CSS !-->
@section('page-level-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link href="{{asset('css/contact-details-form.css')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('croppie/croppie-2.css?v=1.4')}}" type="text/css" rel="stylesheet">
    <link href="{{asset('croppie/croppie.css?v=1.2')}}" type="text/css" rel="stylesheet">
@stop

<!-- Page Level Javascript !-->
@section('page-level-js')

    <script src="{{asset('croppie/croppie.min.js')}}"></script>

    <script type="text/javascript">

        var $uploadCrop = new Array();

        $('document').ready(function(){

            $('.port_wid_head').click(function(){

                $(this).closest('.add_port_wid_outer').find('.port_wid_drop_outer').toggle();
            });

            $('.port_wid_drop_inner .head i').click(function(){

                $(this).closest('.add_port_wid_outer').find('.port_wid_drop_outer').toggle();
            });

            $('body').delegate('.custom_file_thumb', 'click', function(e){

                $(this).parent().find('.port_file_input').trigger('click');
            });

            $('body').delegate('.port_field_remove', 'click', function(e){

                if(confirm('Are you sure?')){

                    $(this).closest('.port_field_checked').remove();
                }
            });

            $('.port_thumb_upload').on('change', function () { readCroppedFile(this); });

            $('.save_portfolio_outer').click(function(){

                var form = $(this).closest('form');
                form.find('.has-danger').removeClass('has-danger');
                var error = 0;
                var title = form.find('.port_title');
                var question = form.find('.port_question');

                if(title.val() == ''){

                    error = 1;
                    title.addClass('has-danger');
                }

                if(question.length && question.val() == ''){

                    error = 1;
                    question.addClass('has-danger');
                }

                if(form.find('input[value="youtube"]').length){

                    form.find('input[value="youtube"]').each(function(){
                        var youtubeField = $(this).closest('.port_field_body').find('.port_field_text');
                        if(youtubeField.length && !matchYoutubeUrl(youtubeField.val())){
                            youtubeField.addClass('has-danger');
                            error = 1;
                        }
                    });
                }

                if(!error){

                    $('#body-overlay,#pro_uploading_in_progress_real').show();
                    setTimeout(function() {
                        if(form.find('.upload-demo').hasClass('ready')){

                            var id = form.find('.upload-demo').attr('data-id');
                            $uploadCrop[id].croppie('result', {
                                type: 'canvas',
                                size: 'viewport'
                            }).then(function (resp) {

                                $(form).find('.port_thumb_data').val(resp);
                                form.submit();
                            });
                        }else{
                            form.submit();
                        }
                    }, 500);
                }else{
                    $("html, body").animate({scrollTop: form.find('.has-danger').first().offset().top - 120}, 1500, function(){});
                }
            });

            $('.init_croppie').each(function(){

                var id = $(this).closest('.upload-demo').attr('data-id');
                $uploadCrop[id] = $(this).croppie({
                    viewport: {
                        width: 300,
                        height: 160,
                        type: 'square'
                    },
                    enableExif: true,
                    showZoomer: true,
                });
            });

            $('.add_element').click(function(e){
                e.preventDefault();
                var thiss = $(this);
                var id = thiss.attr('data-id');

                var currentOrder = thiss.closest('form').find('.port_field_checked').last().attr('data-order');
                if(currentOrder === undefined){ currentOrder = 0; }

                var order = parseInt(currentOrder) + 1;

                if(id == 'paragraph'){
                    var element = $('#paragraph_sample');
                    element.find('.main_info').attr('name', 'element['+order+'][0][]');
                    element.find('.extra_info').attr('name', 'element['+order+'][1][]').val('paragraph');
                }
                if(id == 'image'){
                    var element = $('#image_sample');
                    element.find('input[type=file]').attr('name', 'element['+order+'][0][]');
                    element.find('.extra_info').attr('name', 'element['+order+'][1][]').val('image');
                }
                if(id == 'youtube'){
                    var element = $('#youtube_sample');
                    element.find('.main_info').attr('name', 'element['+order+'][0][]');
                    element.find('.extra_info').attr('name', 'element['+order+'][1][]').val('youtube');
                }
                if(id == 'heading'){
                    var element = $('#heading_sample');
                    element.find('.main_info').attr('name', 'element['+order+'][0][]');
                    element.find('.extra_info').attr('name', 'element['+order+'][1][]').val('heading');
                }
                if(id == 'spotify'){
                    var element = $('#spotify_sample');
                    element.find('.main_info').attr('name', 'element['+order+'][0][]');
                    element.find('.extra_info').attr('name', 'element['+order+'][1][]').val('spotify');
                }
                if(id == 'ask_question'){
                    var element = $('#ask_question_sample');
                    element.find('.main_info').attr('name', 'element['+order+'][0][]');
                    element.find('.extra_info').attr('name', 'element['+order+'][1][]').val('ask-question');
                }

                element.find('.port_each_field').addClass('port_field_checked').attr('data-order', order);
                thiss.closest('form').find('.element_container').append(element.html());
                element.find('.port_each_field').removeClass('port_field_checked').removeAttr('data-order');

            });

            $('.m_btm_right_icons .m_btm_edit').click(function(e){

                var id = $(this).attr('data-id');
                $('form[data-id="u_info_form_'+id+'"]').show();
            });

            $('.que_tools_each[data-type="3"]').click(function(e){

                e.preventDefault();
                var id = $(this).closest('.que_view_outer').attr('data-id');
                $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-id', id);
                $('.pro_confirm_delete_outer #pro_delete_submit_yes').attr('data-delete-item-type', 'contact-question');
                if( id ){

                    $('.pro_confirm_delete_outer').show();
                    $('#body-overlay').show();
                }
            });

            $('.close_portfolio_outer').click(function(){

                $(this).closest('form').hide();
            });

            $('.notify_now').click(function(){

                if(confirm('Are you sure?')){
                    var formData = new FormData();
                    var code = window.location.href.split('/').slice(-1).toString();
                    $.ajax({

                        url: '/agent-contact/save-details/'+code+'/send-notification',
                        type: 'POST',
                        data: formData,
                        contentType:false,
                        cache: false,
                        processData: false,
                        dataType: 'json',
                        success: function (response) {
                            if(response.success == 1){
                                location.reload();
                            }
                        }
                    });
                }
            });

            $('.que_tools_each').click(function(){

            	var thiss = $(this);
            	if(thiss.attr('data-type') == '1' || thiss.attr('data-type') == '2'){
            		thiss.closest('.que_view_tools').find('.que_tools_each.active').removeClass('active');
            		thiss.addClass('active');

            		if(thiss.closest('.que_view_outer').find('.que_tools_each.active').attr('data-type') == '1'){
            			thiss.closest('.que_view_outer').find('.que_edit_each').addClass('instant_hide');
            			thiss.closest('.que_view_outer').find('.que_view_each').removeClass('instant_hide');
            		}else{
            			thiss.closest('.que_view_outer').find('.que_edit_each').removeClass('instant_hide');
            			thiss.closest('.que_view_outer').find('.que_view_each').addClass('instant_hide');
            		}
            	}
            });

            @if(Session::has('question'))
		        var activeQuestion = '{{(is_array(Session::get("question"))) ? Session::get("question")[0] : Session::get("question")}}';
		        if(activeQuestion != ''){
		        	$("html, body").animate({scrollTop: $('.que_view_outer[data-id="'+activeQuestion+'"]').offset().top - 120}, 0, function(){});
		        }
	        @endif
        });

        function readCroppedFile(input) {
            var id = $(input).closest('.upload-demo').attr('data-id');
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(input).closest('.upload-demo').find('.upload-current').addClass('instant_hide');
                    $(input).closest('.upload-demo').addClass('ready');
                    $uploadCrop[id].croppie('bind', {
                        url: e.target.result
                    }).then(function(){
                        console.log('jQuery bind complete');
                    });
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function updatePortThumb(elem){

            var data = elem.files[0];
            if(data.size > 5*1024*1024) {
                alert('File cannot be more than 5MB');
                $(elem).val('');
                return false;
            }

            if(elem.files && elem.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {

                    $(elem).parent().find('.custom_file_thumb').attr('src', e.target.result);
                }
                reader.readAsDataURL(elem.files[0]);
            }

        }

    </script>
@stop

<!-- Page Header !-->
@section('header')
    @include('parts.header')
@stop


@section('flash-message-container')

@stop

<!-- facebook/twitter share Login !-->
@section('social-media-html')
@stop


@section('page-content')
	@php $tab = 'view' @endphp
	@if(Session::has('tab') && Session::get('tab') == 'edit')
		@php $tab = 'edit' @endphp
	@endif

    @if(Auth::check() && Auth::user()->id == $agent->id)
        @php $isAllowed = 'agent' @endphp
    @elseif(!Auth::check() && $contact->contactUser->email == NULL && $contact->contactUser->password == NULL && $contact->approved == NULL)
        @php $isAllowed = 'user' @endphp
    @elseif(Auth::check() && Auth::user()->id == $contact->contactUser->id)
        @php $isAllowed = 'user' @endphp
    @else
        @php $isAllowed = false @endphp
    @endif

    <div class="contact_details_outer">
        <div class="contact_details_inner">
            @if (Session::has('success'))
                <div class="success_span">{{ Session::get('success') }}</div>
            @endif
            @if(Auth::check())
            <div class="back_to_profile">
                <i class="fa fa-arrow-left"></i>
                <a href="{{route('profile')}}">Back to profile</a>
            </div>
            @endif
            @if($isAllowed)
            <div class="contact_details_section">
                <div class="contact_section_head">
                    <span class="font-bold">{{$contact->contactUser->name}} - Creative Brief</span>
                    <br>
                    <div class="contact_section_sub_head !text-white mt-4 !text-[15px]">
                        The brief is private and is only visible to you and your contact<br>
                        Press the <i class="fa fa-pencil"></i> to add your answers, then click SAVE button to save each answer<br>
                        After making changes to this form press
                        <span class="notify_now"><i class="fa fa-bell"></i> Notify Now</span>
                        to send notification to {{$isAllowed == 'agent' ? $contact->contactUser->name : $agent->name}}
                    </div>
                </div>
                <div class="contact_section_body">
                	<form action="{{route('agent.contact.details.save', ['code' => $contact->code, 'action' => 'add-question'])}}" method="POST">
                		{{csrf_field()}}

                        <div class="element_container">
                            <div class="port_each_field">
                                <div class="port_field_label">
                                    <div class="port_field_label_text">Question</div>
                                </div>
                                <div class="port_field_body">
                                    <input type="text" class="port_field_text port_title" placeholder="Add question" name="question" />
                                </div>
                            </div>
                        </div>

                        <div class="save_portfolio_outer edit_profile_btn_1 clearfix">
                            <a href="javascript:void(0)">Save </a>
                        </div>
                        <input type="hidden" value="" class="port_thumb_data" name="port_thumb_data" />
                        <input type="hidden" value="{{$contact->contactUser->id}}" name="port_sandbox" />
	                </form>
                    <br><br><br>
                    <div class="music_btm_listing_outer_edit">
                        <label class="main_label">
                        	<span class="left">Questions</span>
                        </label>
                        @if(count($contact->questions))
                        	@php $commonMethods = new \App\Http\Controllers\CommonMethods() @endphp
                            @foreach($contact->questions as $key => $question)
                            <div data-sort="qa_{{$question->id}}" data-id="{{$question->id}}" class="que_view_outer elem_sortable">
                            	<span class="que_view_tools">
                            		<div data-type="1" class="que_tools_each active"><i class="fa fa-eye"></i></div>
                            		<div data-type="2" class="que_tools_each"><i class="fa fa-pencil"></i></div>
                                    @if(Auth::check())
                            		<div data-type="4" class="que_tools_each edit_elem_sort_up"><i class="fa fa-hand-o-up"></i></div>
                            		<div data-type="5" class="que_tools_each edit_elem_sort_down"><i class="fa fa-hand-o-down"></i></div>
                                    @endif
                            		<div data-type="3" class="que_tools_each"><i class="fa fa-trash"></i></div>
                            	</span>
                            	<div class="que_view_q">
                            	    {!! nl2br($question->value) !!}
                            	</div>
                            	<div class="que_edit_each instant_hide">
                            		<div data-navigate="" data-sort="qa_{{$question->id}}" class="music_btm_list elem_sortable">
                            		    <div class="edit_elem_bottom">
                            		        @include('parts.user-answer-edit-template', ['question' => $question])
                            		    </div>
                            		</div>
                            	</div>
                                <div class="que_view_each">
                                    <div class="que_view_a">
                                        @foreach($question->elements as $element)
                                            @if($element->type == 'heading')
                                                <div class="que_view_a_each q_view_heading">
                                                    {{$element->value}}
                                                </div>
                                            @endif
                                            @if($element->type == 'paragraph')
                                                <div class="que_view_a_each q_view_para">
                                                    @php $url = '@(http)?(s)?(://)?(([a-zA-Z])([-\w]+\.)+([^\s\.]+[^\s]*)+[^,.\s])@' @endphp
                                                    @php $text = preg_replace($url, '<a class="user_message_hyp" href="$0" target="_blank" title="Click here">$0</a>', $element->value); @endphp
                                                    {!! nl2br($text) !!}
                                                </div>
                                            @endif
                                            @if($element->type == 'youtube')
                                                @php $videoId = $commonMethods->getYoutubeVideoId($element->value) @endphp
                                                <div class="que_view_a_each q_view_youtube">
                                                    <a target="_blank" href="{{$element->value}}">
                                                        <img src="https://i.ytimg.com/vi/{{$videoId}}/mqdefault.jpg">
                                                        {{$commonMethods->getVideoTitle($videoId)}}
                                                    </a>
                                                </div>
                                            @endif
                                            @if($element->type == 'image')
                                                <div class="que_view_a_each q_view_image">
                                                    <img src="{{asset('contact-info-images/'.$element->value)}}" class="custom_file_thumb">
                                                </div>
                                            @endif
                                            @if($element->type == 'spotify')
                                                <div class="que_view_a_each q_view_spotify">
                                                    <a target="_blank" href="{{$element->value}}">Spotify Link</a>
                                                </div>
                                            @endif
                                            @if($element->type == 'ask-question')
                                                <div class="que_view_a_each q_view_ask_question">
                                                    {!! nl2br($element->value) !!}
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            @else
                <div class="contact_details_section">
                    <div class="contact_section_head">
                        You are not authorized to view this page
                    </div>
                </div>
            @endif
        </div>
    </div>
@stop

@section('miscellaneous-html')

    @include('parts.add-form-elements')
    <div id="body-overlay"></div>
    <div class="pro_uploading_in_progress in_progress pro_page_pop_up clearfix" style="z-index: 10;" id="pro_uploading_in_progress_real">

        <div class="pro_soc_con_face_inner clearfix">

            <div class="soc_con_top_logo clearfix">

                <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="https://www.recordingexperiences.com/images/1logo8.png"><div>Platform</div></a>
            </div>
            <div class="soc_con_face_username clearfix">

                <h3>Please wait. Uploading is in progress...</h3><br><br><br>
            </div>
        </div>
    </div>
    <div class="pro_confirm_delete_outer pro_page_pop_up clearfix" >
        <div class="pro_confirm_delete_inner clearfix">
            <div class="soc_con_top_logo clearfix">
                <a style="opacity: 0;" class="logo8">
                    <img class="pro_soc_top_logo defer_loading" src="" data-src="https://www.recordingexperiences.com/images/1logo8.png">
                    <div>Platform</div>
                </a>
                <i class="fa fa-times pro_soc_top_close"></i>
            </div>
            <div class="pro_confirm_delete_text clearfix">
                <div class="main_headline">Are You Sure You Want To Delete This Item?</div><br>
                <span class="error"></span>
            </div>
            <div class="pro_confirm_box_outer pro_submit_button_outer soc_submit_success clearfix">
                <div class="delete_yes pro_confirm_box_each" data-delete-id="" data-delete-item-type="" data-album-status="" data-album-music-id="" id="pro_delete_submit_yes">YES</div>
                <div class="delete_no pro_confirm_box_each" id="pro_confirm_delete_submit_no">NO</div>
            </div>
        </div>
    </div>
@stop
