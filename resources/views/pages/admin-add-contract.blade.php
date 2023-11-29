
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
    $details = $action == 'edit' ? $agencyContract->contract_details['body'] : $body;
    $variables = explode("<<var>>", $details);
    $agentContact = $action == 'edit' ? $agencyContract->contact : $agentContact;
    $isAgent = $agentContact->agentUser->id == $user->id ? true : false;
    $isContact = $agentContact->contactUser->id == $user->id ? true : false;
@endphp

<div class="contact_details_outer">
    <div class="contact_details_inner">
        @if(Auth::check())
        <div class="back_to_profile">
            <i class="fa fa-arrow-left"></i>
            <a href="{{route('agency.dashboard')}}">Back to dashboard</a>
        </div>
        @endif
        <div class="contact_details_section">
            <div class="contact_section_head">
                {{$contract->title}}
            </div>
            <div class="contact_section_body">
                <form class="flex flex-col" id="signature-form" action="{{$action == 'edit' ? route('agency.contract.update', ['id' => $agencyContract->id]) : route('agency.contract.create', ['id' => $contract->id, 'contact' => $agentContact->id])}}" method="POST">
                    {{csrf_field()}}

                    <div class="element_container mt-8">
                    @foreach ($variables as $index => $variable)
                        <span class="text-sm font-normal">{!!$variable!!}</span>
                        @if($index + 1 < count($variables))
                        <input class="border-b border-solid border-black text-theme-red mb-2" name="inputData[]" value="{{$action == 'edit' && isset($agencyContract->contract_details['data'][$index]) ? $agencyContract->contract_details['data'][$index] : ''}}" type="text" />
                        @endif
                    @endforeach

                    </div>
                    <div class="my-12">
                        <label for="comment" class="block text-sm font-medium leading-6 text-gray-900">Name your contract (optional)</label>
                        <div class="mt-2">
                            <input type="text" value="{{$action == 'edit' ? $agencyContract->contract_name : ''}}" name="name" class="block w-full px-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6" placeholder="(e.g song writing contract)">
                        </div><br>
                        <label for="comment" class="block text-sm font-medium leading-6 text-gray-900">Add your custom terms(optional)</label>
                        <div class="mt-2">
                            <textarea placeholder="Enter terms on top of above..." rows="4" name="terms" class="px-2 outline-none block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6">{{$action == 'edit' ? $agencyContract->custom_terms : ''}}</textarea>
                        </div>
                    </div>
                    <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between mt-24 mb-12 gap-20">
                        <div class="flex flex-col w-full lg:w-1/2">
                            @if($isAgent)
                                @if($action == 'edit' && count($agencyContract->signatures) && isset($agencyContract->signatures['agent']))
                                    <img class="mb-2" src="{{asset('signatures/'.$agencyContract->signatures['agent'])}}">
                                    <div class="text-theme-red">Dated: {{date('d-m-Y', strtotime($agencyContract->created_at))}}</div>
                                    <div class="border-t border-solid pt-1 border-black text-center font-medium">
                                        {{$agencyContract->legal_names['agent']}}
                                    </div>
                                @else
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
                                    <div class="border-t border-solid pt-1 border-black text-center font-medium">
                                        <input id="legal-name" name="legalName" class="border-b border-solid pt-1 border-black text-center font-medium" type="text" placeholder="Enter your legal name" />
                                    </div>
                                @endif
                            @else
                                <div class="border-t border-solid pt-1 border-black text-center font-medium">Producer</div>
                            @endif
                        </div>
                        <div class="flex flex-col w-full lg:w-1/2">
                            @if($isContact)
                                @if($action == 'edit' && count($agencyContract->signatures) && isset($agencyContract->signatures['artist']))
                                    <img class="mb-2" src="{{asset('signatures/'.$agencyContract->signatures['artist'])}}">
                                    <div class="text-theme-red">Dated: {{date('d-m-Y', strtotime($agencyContract->created_at))}}</div>
                                    <div class="border-t border-solid pt-1 border-black text-center font-medium">
                                        {{$agencyContract->legal_names['artist']}}
                                    </div>
                                @else
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
                                    <div class="border-t border-solid pt-1 border-black text-center font-medium">
                                        <input id="legal-name" name="legalName" class="border-b border-solid pt-1 border-black text-center font-medium" type="text" placeholder="Enter your legal name" />
                                    </div>
                                @endif
                            @else
                                <div class="border-t border-solid pt-1 border-black text-center font-medium">Artist</div>
                            @endif
                        </div>
                    </div>

                    @if($action == 'edit')
                        <button type="submit" class="my-10 ml-auto rounded-md bg-indigo-600 px-5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                    @else
                        <button id="signature-submit-button" type="button" class="my-10 ml-auto rounded-md bg-indigo-600 px-5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                        <input type="hidden" value="" id="signature-data" name="data">
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('miscellaneous-html')

    @include('parts.signature-popups')
@stop
