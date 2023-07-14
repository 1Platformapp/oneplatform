
@extends('templates.basic-template')


@section('pagetitle')  @endsection


<!-- Page Level CSS !-->
@section('page-level-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link href="{{asset('css/contact-details-form.css')}}" type="text/css" rel="stylesheet">
    <style>
        .jSignature { max-width: 100% !important; }
    </style>
@stop

<!-- Page Level Javascript !-->
@section('page-level-js')

<script src="https://cdn.tailwindcss.com"></script>
<script src="{{ asset('js/tailwind-custom.js') }}"></script>
<script src="{{asset('esign/libs/modernizr.js')}}"></script>
<script src="{{asset('esign/src/jSignature.js')}}"></script>

<script type="text/javascript">
    $('document').ready(function(){

        var submitBtn = $('#signature-submit-button');
        $("#signature-file").change(function() {
            readURL(this, 'signature-image');
            $('#signature-prompt').addClass('instant_hide');
            $('#signature-result').removeClass('instant_hide');
            submitBtn.prop('disabled', false);
        });

        $("#signature-prompt").click(function(e) {
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
            if($('#signature-image').attr('src') != ''){

                $('#signature-form #signature-data').val($('#signature-image').attr('src'));
                $('#signature-form').submit();
            }else{
                alert('Add your signature');
            }
        })
    });
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

@php
    $body = $contract->body;
    $variables = explode("<<var>>", $body);
    $isAgent = $agentContact->agentUser->id == $user->id ? true : false;
    $isContact = $agentContact->contactUser->id == $user->id ? true : false;
@endphp

<div class="contact_details_outer">
    <div class="contact_details_inner">
        @if(Auth::check())
        <div class="back_to_profile">
            <i class="fa fa-arrow-left"></i>
            <a href="{{route('profile')}}">Back to profile</a>
        </div>
        @endif
        <div class="contact_details_section">
            <div class="contact_section_head">
                {{$contract->title}}
            </div>
            <div class="contact_section_body">
                <form class="flex flex-col" id="signature-form" action="" method="POST">
                    {{csrf_field()}}

                    <div class="element_container mt-8">
                    @foreach ($variables as $index => $variable)
                        <span class="text-sm font-normal">{!!$variable!!}</span>

                        @if($index + 1 < count($variables))
                        <input class="border-b border-solid border-black text-theme-red mb-2" name="input-{{$index}}" type="text" />
                        @endif
                    @endforeach
                    </div>
                    <div class="my-12">
                        <label for="comment" class="block text-sm font-medium leading-6 text-gray-900">Name your contract (optional)</label>
                        <div class="mt-2">
                            <input type="text" name="name" class="block w-full px-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6" placeholder="(e.g song writing contract)">
                        </div><br>
                        <label for="comment" class="block text-sm font-medium leading-6 text-gray-900">Add your custom terms(optional)</label>
                        <div class="mt-2">
                            <textarea placeholder="Enter terms on top of above..." rows="4" name="terms" class="px-2 outline-none block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6"></textarea>
                        </div>
                    </div>
                    <div class="flex items-end justify-between mt-24 mb-12 gap-20">
                        <div class="flex flex-col w-1/2">
                            @if($isAgent)
                            <button id="signature-prompt" type="button" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 px-12 py-4 mb-2 text-center hover:border-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
                                </svg>
                                <span class="mt-2 block text-sm text-gray-400">Add signature or</span>
                                <label for="signature-file" class="inline-flex items-center rounded-md bg-gray-400 px-2 cursor-pointer mt-2 py-1 text-sm text-white shadow-sm hover:bg-gray-500">
                                    Upload signature file
                                </label>
                                <input id="signature-file" type="file" accept="image/*" class="absolute top-[-100px] left-[-100px] w-0 h-0 inset-0 opacity-0 -z-50 pointer-events-none" />
                            </button>
                            <div id="signature-result" class="instant_hide flex justify-center">
                                <img id="signature-image" class="mb-2" src="">
                                <span class="cursor-pointer"><i class="fa fa-times-circle"></i></span>
                            </div>
                            @endif
                            <div class="border-t border-solid pt-1 border-black text-center font-medium">Producer</div>
                        </div>
                        <div class="flex flex-col w-1/2">
                            @if($isContact)
                            <button id="signature-prompt" type="button" class="relative block w-full rounded-lg border-2 border-dashed border-gray-300 px-12 py-4 mb-2 text-center hover:border-gray-400">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
                                </svg>
                                <span class="mt-2 block text-sm text-gray-400">Add signature or</span>
                                <label for="signature-file" class="inline-flex items-center rounded-md bg-gray-400 px-2 cursor-pointer mt-2 py-1 text-sm text-white shadow-sm hover:bg-gray-500">
                                    Upload signature file
                                </label>
                                <input id="signature-file" type="file" accept="image/*" class="absolute top-[-100px] left-[-100px] w-0 h-0 inset-0 opacity-0 -z-50 pointer-events-none" />
                            </button>
                            <div id="signature-result" class="instant_hide flex justify-center">
                                <img id="signature-image" class="mb-2" src="">
                                <span class="cursor-pointer"><i class="fa fa-times-circle"></i></span>
                            </div>
                            @endif
                            <div class="border-t border-solid pt-1 border-black text-center font-medium">Artist</div>
                        </div>
                    </div>
                    <button id="signature-submit-button" type="button" disabled class="my-10 ml-auto rounded-md bg-indigo-600 px-5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                    <input type="hidden" value="" id="signature-data" name="data">
                </form>
            </div>
        </div>
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
            <div class="login_separator_center">DRAW SIGNATURE BELOW</div>
            <div class="login_separator_right"></div>
        </div>
        <div class="esign_draw">
            <div id="sign_wrapper" class="rounded-lg border-2 border-dashed border-gray-300 my-4">
                <div id="sign_content">
                    <div id="signatureparent">
                        <div id="signature"></div>
                    </div>
                </div>
            </div>
            <div class="flex flex-row items-center gap-4">
                <div id="reset" class="flex-1 text-center bg-white shadow-lg shadow-custom rounded-md text-sm font-semibold text-gray-600 px-5 py-2 cursor-pointer">Clear</div>
                <div id="submit_agreement_sign_draw" class="flex-1 text-center bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-custom rounded-md text-sm font-semibold text-white px-5 py-2 cursor-pointer">Add</div>
            </div>
        </div><br>
    </div>
</div>
@stop
