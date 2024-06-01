<form data-add="0" class="news_edit_form" data-id="my-news-form_{{ $userNews->id }}" action="{{ route('save.user.profile_news') }}" method="post" style="display: none;">

    <input type="hidden" name="news_id" value="{{ $userNews->id }}">

    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="pro_music_info">
        <label>
            Edit News
            <i class="fa fa-times edit_elem_close"></i>
        </label>
    </div>

    <div class="pro_stream_input_outer">
        <div class="pro_stream_input_each">
            <textarea placeholder="Write here" type="text" class="pro_news_textarea" name="value">{{$userNews->value}}</textarea>
        </div>
        <div class="pro_stream_input_each">
            <div class="stream_sec_opt_outer">
                <select name="pro_stream_tab">
                    <option value="">Choose tab</option>
                    <option {{$userNews->tab == '1' ? 'selected' : ''}} value="1">Bio</option>
                    <option {{$userNews->tab == '2' ? 'selected' : ''}} value="2">Music</option>
                    <option {{$userNews->tab == '3' ? 'selected' : ''}} value="3">Followers</option>
                    <option {{$userNews->tab == '4' ? 'selected' : ''}} value="4">Social</option>
                    <option {{$userNews->tab == '6' ? 'selected' : ''}} value="6">Product</option>
                    <option {{$userNews->tab == '5' ? 'selected' : ''}} value="5">Video</option>
                    <option {{$userNews->tab == '7' ? 'selected' : ''}} value="7">Gigs & Tickets</option>
                </select>
            </div>
        </div>
        <div class="save_news_outer edit_profile_btn_1 clearfix">
            <a href="javascript:void(0)">Submit</a>
        </div>
    </div>
</form>
