@extends('templates.bisection-template')



@section('pagetitle') {{$user->name}} - Profile  @endsection


<!-- Page Level CSS !-->

@section('page-level-css')
    
    <style>
        .chat_each_user { justify-content: space-between; }
        .chat_each_sender_sec,.chat_each_recipient_sec { flex: 0 1 50%; position: relative; display: flex; flex-direction: row; }
        .chat_each_user .chat_user_status { left: 33px !important; bottom: 0 !important; }
    </style>

@stop


<!-- Page Level Javascript !-->

@section('page-level-js')
    
    <script>

        window.currentUserId = {{Auth::user()->id}};

    </script>

@stop



<!-- Page Header !-->

@section('header')

    @include('parts.header')

@stop

<!-- Page Header !-->



<!-- Page Top Section !-->

@section('top-section')

@stop


@section('audio-player')

    @include('parts.audio-player')

@stop



@section('flash-message-container')

    <div class="success_span">
        This page is only visible to 1platform admin
    </div>

@stop





@section('left-section')

    <?php $page = "";?>



    @if(session("page"))

        <?php $page = session("page")?>

    @endif



    <div class="pro_left_sec_outer">

        

        <div class="pro_left_btns_outer">

            <ul>

                <li data-cat="profile" class="pro_tb_each">
                    <a href="{{route('profile')}}">My Profile</a>
                </li>
                <li data-cat="media" class="pro_tb_each">
                    <a href="{{route('profile.with.tab',['tab' => 'media'])}}">My Media</a>
                </li>
                <li data-cat="orders" class="pro_tb_each">
                    <a href="{{route('profile.with.tab',['tab' => 'orders'])}}">My Sales & Purchases</a>
                </li>
                <li data-cat="tools" class="pro_tb_each">
                    <a href="{{route('profile.with.tab',['tab' => 'tools'])}}">My Tools</a>
                </li>
                <li data-cat="crowdfund" class="pro_tb_each">
                    <a href="{{route('profile.with.tab',['tab' => 'crowdfunds'])}}">My Crowdfunding</a>
                </li>
                <li data-cat="chat" class="pro_tb_each">
                    <a href="{{route('profile.with.tab',['tab' => 'chat'])}}">Chat</a>
                </li>

            </ul>

        </div>

    </div>

@stop



@section('right-section')



    <div class="pro_right_sec_outer">

        <div class="pro_right_tb_det_outer">


            <div id="admin_chat" class="chat_outer">
                <div class="chat_left">
                    <div class="chat_search_outer">
                        <div class="chat_search_users">
                            <input id="search_senders" type="text" placeholder="Search users by name" />
                            <input class="dummy_field" />
                            <i class="fa fa-search"></i>
                        </div>
                    </div>  
                    <div class="chat_users_outer"></div>
                </div>
                <div class="chat_right">
                    <div class="chat_main_header">
                        <div class="chat_head_name hide_on_mobile"></div>
                        <div class="chat_main_header_action">
                            <div id="filter_none" class="header_each_action active">
                                <i class="fa fa-comment-o"></i>
                                <span>Chat</span>
                            </div>
                            <div id="filter_agreements" class="header_each_action">
                                <i class="fa fa-file-pdf-o"></i>
                                <span>Agreements</span>
                            </div>
                        </div>
                    </div>
                    <div class="chat_main_body">
                        <div id="chat_head_name_res" class="chat_main_header_action hide_on_desktop">
                            <div class="chat_head_name"></div>
                        </div>
                        <img id="loading_messages" class="instant_hide" src="{{asset('images/loading.gif')}}">
                        <div class="chat_main_body_messages"></div>
                        <div class="chat_main_body_foot">
                            <textarea id="new_message" placeholder="Type your message here"></textarea>
                            <div class="chat_main_foot_actions">
                                <div id="join_chat_btn" class="foot_action_btn"><i class="fa fa-user-plus"></i> Join Chat</div>
                                <div id="submit_btn" class="foot_action_btn"><i class="fa fa-paper-plane"></i> Send</div>
                            </div>
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


@section('bottom-section')

@stop







