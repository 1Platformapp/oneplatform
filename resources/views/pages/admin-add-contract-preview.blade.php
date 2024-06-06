
@extends('templates.basic-template')


@section('pagetitle') Add Contract | Dashboard @endsection


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

<script src="{{asset('esign/libs/modernizr.js')}}"></script>
<script src="{{asset('esign/src/jSignature.js')}}"></script>
<script src="{{asset('esign/src/main.js')}}"></script>

@stop

<!-- Page Header !-->
@section('header')
    @include('parts.header')
@stop


@section('flash-message-container')

@stop

@section('social-media-html')
@stop


@section('page-content')

@php
    $body = $contract->body;
    $details = $body;
@endphp

<div class="relative contact_details_outer">
    <img class="absolute top-1/2 z-50 left-1/2 tranform -translate-x-[50%] -translate-y-[50%] -rotate-45" src="{{asset('images/preview.png')}}" alt="">
    <div class="contact_details_inner">
        @if(Auth::check())
        <div class="back_to_profile">
            <i class="fa fa-arrow-left"></i>
            <a style="background-color: #444; padding: 8px; color: #fff; border-radius: 7px;" href="{{route('agency.dashboard')}}">Back to dashboard</a>
        </div>
        @endif
        <div class="contact_details_section">
            <div class="contact_section_head">
                {{ $contract->title }}
            </div>
            <div class="contact_section_body">
                <form class="flex flex-col" id="signature-form" action="#" method="POST">
                    <div class="mt-8 element_container">
                    {!! nl2br(substr($details, 0, 3000)) !!}

                    </div>
                    <div class="my-12">
                        <label for="comment" class="block text-sm font-medium leading-6 text-gray-900">Name your contract (optional)</label>
                        <div class="mt-2">
                            <input disabled type="text"class="block w-full px-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6" placeholder="(e.g song writing contract)">
                        </div><br>
                        <label for="comment" disabled class="block text-sm font-medium leading-6 text-gray-900">Add your custom terms(optional)</label>
                        <div class="mt-2">
                            <textarea disabled placeholder="Enter terms on top of above..." rows="4" class="px-2 outline-none block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6"></textarea>
                        </div>
                    </div>
                    <div class="flex flex-col gap-20 mt-24 mb-12 lg:flex-row lg:items-end lg:justify-between">
                        <div class="flex flex-col w-full lg:w-1/2">
                            <button type="button" class="relative block w-full px-12 py-4 mb-2 text-center border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400">
                                <svg class="w-12 h-12 mx-auto text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
                                </svg>
                                <span class="block mt-2 text-sm text-gray-400">Add signature or</span>
                                <label for="signature-file" class="inline-flex items-center px-2 py-1 mt-2 text-sm text-white bg-gray-400 rounded-md shadow-sm cursor-pointer hover:bg-gray-500">
                                    Upload signature file
                                </label>
                                <input type="file" accept="image/*" class="absolute top-[-100px] left-[-100px] w-0 h-0 inset-0 opacity-0 -z-50 pointer-events-none" />
                            </button>
                            <div id="signature-result" class="flex justify-center instant_hide">
                                <img id="signature-image" class="mb-2" src="">
                                <span class="cursor-pointer"><i class="fa fa-times-circle"></i></span>
                            </div>
                            <div class="pt-1 font-medium text-center border-t border-black border-solid">
                                <input id="legal-name" class="pt-1 font-medium text-center border-b border-black border-solid" type="text" placeholder="Enter your legal name" />
                            </div>
                        </div>
                        <div class="flex flex-col w-full lg:w-1/2">
                            <div class="pt-1 font-medium text-center border-t border-black border-solid">Artist</div>
                        </div>
                    </div>
                    <div>
                        <p style="font-size: 16px;color: #818181;margin: 10px 0;">
                            <span class="text-red-600 text-sm">Disclaimer:</span> {{Config('constants.disclaimer')}}
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('miscellaneous-html')

    @include('parts.signature-popups')
@stop
