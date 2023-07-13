
@extends('templates.basic-template')


@section('pagetitle')  @endsection


<!-- Page Level CSS !-->
@section('page-level-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link href="{{asset('css/contact-details-form.css')}}" type="text/css" rel="stylesheet">
@stop

<!-- Page Level Javascript !-->
@section('page-level-js')

<script src="https://cdn.tailwindcss.com"></script>
<script src="{{ asset('js/tailwind-custom.js') }}"></script>
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
                <form method="POST" class="flex flex-col">
                    {{csrf_field()}}

                    <div class="element_container mt-8">
                    @foreach ($variables as $index => $variable)
                        <span class="text-sm font-normal">{!!$variable!!}</span>

                        @if($index + 1 < count($variables))
                        <input class="border-b border-solid border-black text-theme-red mb-2" name="input-{{$index}}" type="text" value="" placeholder="" />
                        @endif
                    @endforeach
                    </div>
                    <div class="my-12">
                        <label for="comment" class="block text-sm font-medium leading-6 text-gray-900">Name your contract (optional)</label>
                        <div class="mt-2">
                            <input type="text" name="title" class="block w-full px-2 rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6" placeholder="(e.g song writing contract)">
                        </div><br>
                        <label for="comment" class="block text-sm font-medium leading-6 text-gray-900">Add your custom terms(optional)</label>
                        <div class="mt-2">
                            <textarea placeholder="Enter terms on top of above..." rows="4" name="comment" class="px-2 outline-none block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6"></textarea>
                        </div>
                    </div>
                    <div class="flex items-center justify-between mt-24 mb-12 gap-20">
                        <div class="flex flex-col w-1/2">
                        <img src="https://onlinepngtools.com/images/examples-onlinepngtools/marilyn-monroe-signature.png" alt="">
                            <div class="border-t border-solid pt-1 border-black text-center font-medium">Producer</div>
                        </div>
                        <div class="flex flex-col w-1/2">
                            <img src="https://onlinepngtools.com/images/examples-onlinepngtools/marilyn-monroe-signature.png" alt="">
                            <div class="border-t border-solid pt-1 border-black text-center font-medium">Artist</div>
                        </div>
                    </div>
                    <button type="button" class="my-10 ml-auto rounded-md bg-indigo-600 px-5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('miscellaneous-html')

@stop
