@extends('templates.basic-template')


@section('pagetitle') 1Platform Reset Password @endsection



@section('miscellaneous-html')

    <div id="body-overlay"></div>
    @if($user)
        <!-- reset Password Pop-up  !-->
        <div class="forget_pass_popup_outer pro_page_pop_up clearfix" style="display: block;" >

            <div class="forget_pass_popup_inner clearfix">

                <div class="soc_con_top_logo clearfix">

                    <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
                    <i class="fa fa-times pro_soc_top_close"></i>
                </div>
                <div class="forget_pass_popup_email_cont clearfix">

                    <h3>Enter Your New Password</h3><br>
                    <input placeholder="New Password" type="password" id="new_password_one" value="" style="margin-bottom: 10px;" />
                    <input class="groupon" placeholder="New Password" type="password" id="new_password_two" value="" />
                    <span class="error"></span>
                </div>
                <div class="pro_submit_button_outer soc_con_submit_success clearfix">

                    <a style="cursor: pointer;" id="reset_pass_popup_submit" data-userid="{{ $user->id }}" data-baseurl="{{ asset('/') }}">Reset Password</a>
                </div>
            </div>
        </div>
        <!-- reset Password Pop-up  !-->
    @else

        <div class="forget_pass_popup_outer pro_page_pop_up clearfix" style="display: block;" >

            <div class="forget_pass_popup_inner clearfix">

                <div class="soc_con_top_logo clearfix">

                    <a class="logo8"><img class="pro_soc_top_logo defer_loading" src="" data-src="{{ asset('images/1logo8.png') }}"><div>Platform</div></a>
                    <i class="fa fa-times pro_soc_top_close"></i>
                </div>
                <div class="forget_pass_popup_email_cont clearfix">

                    <h3>Invalid Token</h3><br>

                </div>
                <div class="pro_submit_button_outer soc_con_submit_success clearfix">

                    <a href="{{ asset('login') }}">Try Again with Valid Email</a>
                </div>
            </div>
        </div>

    @endif
@stop