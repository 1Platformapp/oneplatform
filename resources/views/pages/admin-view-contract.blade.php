
@extends('templates.basic-template')


@section('pagetitle') View Contract | Dashboard @endsection


<!-- Page Level CSS !-->
@section('page-level-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link href="{{asset('css/contact-details-form.css?v=1.2')}}" type="text/css" rel="stylesheet">
    <style>
        .jSignature { max-width: 100% !important; }
        #myModal {
            display: none;
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 50;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100%;
        }

        .modal-content {
            max-width: 700px;
            width: 100%;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            height: 500px;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            padding: 1rem;
        }

        .modal-header button {
            color: #666;
            cursor: pointer;
            font-size: 1.5rem;
        }

        .modal-body {
            padding-right: 2rem;
            padding-left: 2rem;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            padding: 0rem 1rem 1rem 0rem;
        }

        .modal-footer button {
            background-color: #3490dc;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
@stop

<!-- Page Level Javascript !-->
@section('page-level-js')

<script src="{{asset('esign/libs/modernizr.js')}}"></script>
<script src="{{asset('esign/src/jSignature.js')}}"></script>
<script src="{{asset('esign/src/main.js')}}"></script>
<script>
    
    function openModal() {
        document.getElementById('myModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('myModal').style.display = 'none';
    }

</script>

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
    $details = $contract->contract_details;
    $isAgent = $contract->contact->agentUser->id == $user->id ? true : false;
    $isContact = $contract->contact->contactUser->id == $user->id ? true : false;
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
                {{$contract->contract_name}}
                {{$contract->custom_terms}}
            </div>
            <div class="contact_section_body">
                <form class="flex flex-col" id="signature-form" action="{{route('agency.contract.approve', ['id' => $contract->id])}}" method="POST">
                    {{csrf_field()}}

                    <div class="flex items-center justify-center my-4">
                        <label class="block text-xl font-medium leading-6 text-gray-900 cursor-pointer" onclick="openModal()">Click to see Advisory Notes</label>
                    </div>
                    <div class="h-auto">
                        <label for="contractBody" class="block mb-4 text-lg font-medium leading-6 text-gray-900">Contract Detail</label>
                        {!! nl2br($details) !!}
                    @if($contract->custom_terms)
                        <br><br>
                        {!! $contract->custom_terms !!}
                    @endif
                    </div>
                    <div class="flex items-end justify-between gap-20 mt-24 mb-12">
                        <div class="flex flex-col w-1/2">
                            @if($isAgent)
                                @if(count($contract->signatures) && isset($contract->signatures['agent']))
                                    <img class="mb-2" src="{{asset('signatures/'.$contract->signatures['agent'])}}">
                                @else
                                    <button id="signature-prompt" type="button" class="relative block w-full px-12 py-4 mb-2 text-center border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400">
                                        <svg class="w-12 h-12 mx-auto text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
                                        </svg>
                                        <span class="block mt-2 text-sm text-gray-400">Add signature or</span>
                                        <label for="signature-file" class="inline-flex items-center px-2 py-1 mt-2 text-sm text-white bg-gray-400 rounded-md shadow-sm cursor-pointer hover:bg-gray-500">
                                            Upload signature file
                                        </label>
                                        <input id="signature-file" type="file" accept="image/*" class="absolute top-[-100px] left-[-100px] w-0 h-0 inset-0 opacity-0 -z-50 pointer-events-none" />
                                    </button>
                                    <div id="signature-result" class="flex justify-center instant_hide">
                                        <img id="signature-image" class="mb-2" src="">
                                        <span class="cursor-pointer"><i class="fa fa-times-circle"></i></span>
                                    </div>
                                    <div class="pt-1 font-medium text-center border-t border-black border-solid">
                                        <input id="legal-name" name="legalName" class="pt-1 font-medium text-center border-b border-black border-solid" type="text" placeholder="Enter your legal name" />
                                    </div>
                                @endif
                            @else
                                <img class="mb-2" src="{{asset('signatures/'.$contract->signatures['agent'])}}">
                                <div class="text-theme-red">Dated: {{date('d-m-Y', strtotime($contract->created_at))}}</div>
                                <div class="pt-1 font-medium text-center border-t border-black border-solid">{{$contract->legal_names['agent']}}</div>
                            @endif
                        </div>
                        <div class="flex flex-col w-1/2">
                            @if($isContact)
                                @if(count($contract->signatures) && isset($contract->signatures['artist']))
                                    <img class="mb-2" src="{{asset('signatures/'.$contract->signatures['artist'])}}">
                                @else
                                    <button id="signature-prompt" type="button" class="relative block w-full px-12 py-4 mb-2 text-center border-2 border-gray-300 border-dashed rounded-lg hover:border-gray-400">
                                        <svg class="w-12 h-12 mx-auto text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v20c0 4.418 7.163 8 16 8 1.381 0 2.721-.087 4-.252M8 14c0 4.418 7.163 8 16 8s16-3.582 16-8M8 14c0-4.418 7.163-8 16-8s16 3.582 16 8m0 0v14m0-4c0 4.418-7.163 8-16 8S8 28.418 8 24m32 10v6m0 0v6m0-6h6m-6 0h-6" />
                                        </svg>
                                        <span class="block mt-2 text-sm text-gray-400">Add signature or</span>
                                        <label for="signature-file" class="inline-flex items-center px-2 py-1 mt-2 text-sm text-white bg-gray-400 rounded-md shadow-sm cursor-pointer hover:bg-gray-500">
                                            Upload signature file
                                        </label>
                                        <input id="signature-file" type="file" accept="image/*" class="absolute top-[-100px] left-[-100px] w-0 h-0 inset-0 opacity-0 -z-50 pointer-events-none" />
                                    </button>
                                    <div id="signature-result" class="flex justify-center instant_hide">
                                        <img id="signature-image" class="mb-2" src="">
                                        <span class="cursor-pointer"><i class="fa fa-times-circle"></i></span>
                                    </div>
                                    <div class="pt-1 font-medium text-center border-t border-black border-solid">
                                        <input id="legal-name" name="legalName" class="pt-1 font-medium text-center border-b border-black border-solid" type="text" placeholder="Enter your legal name" />
                                    </div>
                                @endif
                            @else
                                <img class="mb-2" src="{{asset('signatures/'.$contract->signatures['artist'])}}">
                                <div class="text-theme-red">Dated: {{date('d-m-Y', strtotime($contract->created_at))}}</div>
                                <div class="pt-1 font-medium text-center border-t border-black border-solid">{{$contract->legal_names['artist']}}</div>
                            @endif
                        </div>
                    </div>
                    <div>
                        <p style="font-size: 16px;color: #818181;margin: 10px 0;">
                            <span class="text-red-600">Disclaimer:</span> 1Platform is not responsible for any agreements made between users on the platform. 
                            Our website serves as a platform for users to buy, sell, and collaborate. 
                            We do not take responsibility for any disputes or legal issues arising from these interactions. 
                            Users are advised to exercise caution and diligence when engaging with others on the platform. 
                            By using our services, you agree that 1Platform cannot be held liable for any such disputes, 
                            and you waive any right to take legal action against the platform.
                        </p>
                    </div>
                    <button id="signature-submit-button" type="button" class="my-10 ml-auto rounded-md bg-indigo-600 px-5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                    <input type="hidden" value="" id="signature-data" name="data">
                </form>
            </div>
        </div>
    </div>
    <div id="myModal">
        <div class="modal-container">
            <div class="modal-content">
                <div class="items-center modal-header">
                    <p class="text-lg font-bold">Advisory Notes</p>
                    <button onclick="closeModal()">&times;</button>
                </div>
                <div class="modal-body h-400 genHeight">
                    <p class="mb-4 text-md">{!! nl2br($contract->contract->advisory_notes ?? 'N/A') !!}</p>
                </div>
                <div class="modal-footer">
                    <button onclick="closeModal()">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('miscellaneous-html')

    @include('parts.signature-popups')
@stop
