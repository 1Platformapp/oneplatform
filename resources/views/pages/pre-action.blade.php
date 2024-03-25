
@extends('templates.basic-template')


@section('pagetitle') 1Platform Startup Wizard @endsection


<!-- Page Level CSS !-->
@section('page-level-css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
@stop

<!-- Page Level Javascript !-->
@section('page-level-js')

	<script type="text/javascript">

        $('document').ready(function(){


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

    <div class="hm_video_sec_outer">

        <div class="video_upper_sec">
            <div class="auto_content">

                <div class="startup_wizard_outer">
                    <div class="startup_wizard_inner">
                        <div class="startup_wizard_body">
                            <div class="startup_wizard_each_content">
                                <br><br>
                                @if($type == 'subscription.for.home')
                                <div class="pro_note_2">

                                    <h2 class="note_head">
                                        Your home page has not been created yet
                                    </h2>
                                    <div class="note_body">
                                        <p>You are required to select a subscription plan to create or visit your home page</p>
                                        <p>If you are not sure which plan to choose you can begin with our silver plan (Free)</p>
                                    </div>
                                </div>
                                <div class="connect_stripe_actions">
                                    <a class="connect_stripe_now" href="{{route('user.startup.wizard')}}">Choose a plan now</a>
                                    <a class="connect_stripe_skip" href="{{route('agency.dashboard')}}">Continue to browse the site without a plan</a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


@section('miscellaneous-html')

@stop
