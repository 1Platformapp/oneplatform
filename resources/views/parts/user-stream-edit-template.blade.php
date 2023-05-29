<form data-id="my-stream-form_{{ $stream->id }}" action="{{route('user.live.stream.create')}}" method="POST" enctype="multipart/form-data" style="display: none;">
    {{ csrf_field() }}

    <input type="hidden" name="edit" value="{{ $stream->id }}">

    <div class="pro_music_info">
        <label>
            Edit Live Stream
            <i class="fa fa-times edit_elem_close"></i>
        </label>

        <?php
        $editProdThumb = asset('img/url-thumb-profile.jpg');
        if($stream->thumbnail && $stream->thumbnail != ''){
            $editProdThumb = asset('user-stream-thumbnails/'.$stream->thumbnail);
        }
        ?>

        <div class="pro_music_info">
            <div class="pro_upload_video music_thum_sec clearfix">
                <div class="pro_left_video_img">
                    <span class="upload_vieo_img">
                        <img src="{{$editProdThumb}}" alt="#" id="display-stream-thumb-{{$stream->id}}" class="display-stream-thumb" />
                    </span>
                    <a class="display-stream-thumb">Add Thumbnail</a>
                    <input accept="image/*" type="file" style="display: none;" name="live_stream_thumb" class="live_stream_thumb" />
                </div>

                <div class="pro_right_video_det">
                    <p>You can upload a custom thumbnail</p>
                </div>

            </div>

        </div>
        <div class="pro_stream_input_outer">
            <div class="pro_stream_input_each">
                <input placeholder="Add Your Video/Stream URL" type="text" class="pro_stream_input" name="pro_stream_url" value="{{$stream->url}}" />
            </div>
            <div class="pro_stream_input_each">
                <div class="stream_sec_opt_outer">
                    <select id="pro_stream_product" name="pro_stream_product">
                        <option value="">Choose Product</option>
                        <option {{$stream->product == 'all' ? 'selected' : ''}} value="all">All products</option>
                        @foreach($user->products as $product)
                        <option {{$stream->product == $product->id ? 'selected' : ''}} value="{{$product->id}}">{{$product->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="pro_stream_input_each">
                <div class="stream_sec_opt_outer">
                    <select id="pro_stream_music" name="pro_stream_music">
                        <option value="">Choose Music</option>
                        <option {{$stream->music == 'all' ? 'selected' : ''}} value="all">All musics</option>
                        @foreach($user->musics as $music)
                        <option {{$stream->music == $music->id ? 'selected' : ''}} value="{{$music->id}}">{{$music->song_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="pro_stream_input_each">
                <div class="stream_sec_opt_outer">
                    <select id="pro_stream_more_viewers" name="pro_stream_more_viewers">
                        <option value="">Add Your Followers, Fans or Subscribers</option>
                        <option {{$stream->more_viewers == 'all_subs' ? 'selected' : ''}} value="all_subs">Add all my subscribers</option>
                        <option {{$stream->more_viewers == 'all_fans' ? 'selected' : ''}} value="all_fans">Add all my fans</option>
                        <option {{$stream->more_viewers == 'all_follow' ? 'selected' : ''}} value="all_follow">Add my followers</option>
                        <option {{$stream->more_viewers == 'all_subs_fans_follow' ? 'selected' : ''}} value="all_subs_fans_follow">Add my fans, followers, and subscribers</option>
                    </select>
                </div>
            </div>
            <div class="save_live_stream_outer edit_profile_btn_1 clearfix">
                <a href="javascript:void(0)">Submit</a>
            </div>
        </div>

    </div>


</form>