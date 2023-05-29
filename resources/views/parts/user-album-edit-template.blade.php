<form data-id="my-album-form_{{ $album->id }}" action="{{route('user.album.save')}}" method="POST" enctype="multipart/form-data" style="display: none;">
    {{ csrf_field() }}

    <input type="hidden" name="edit" value="{{ $album->id }}">

    <div class="pro_music_info">
        <label>
            <i class="fa fa-times edit_elem_close"></i>
        </label>

        <?php
            $editAlbumThumb = asset('images/p_music_thum_img.png');
            if($album->thumbnail != null && $album->thumbnail != ''){
                $editAlbumThumb = asset('user-album-thumbnails/'.$album->thumbnail);
            }
        ?>

        <div class="pro_music_info">
            <div class="pro_upload_video music_thum_sec clearfix">
                <div class="pro_left_video_img">
                    <span class="upload_vieo_img">
                        <img src="{{$editAlbumThumb}}" alt="#" id="display-album-thumb-{{$album->id}}" class="display-album-thumb" />
                    </span>
                    <a class="display-album-thumb">Add Thumbnail*</a>
                    <input accept="image/*" type="file" style="display: none;" name="album_thumb" class="album_thumb" />
                </div>
                <div class="pro_right_video_det">
                    <p>Upload album thumbnail. It is mandatory</p>
                </div>
            </div>
        </div>
        <div class="pro_stream_input_outer">
            <div class="pro_stream_input_each">
                <input placeholder="Name*" type="text" class="pro_stream_input" name="pro_album_name" value="{{$album->name}}" />
            </div>
            <div class="pro_stream_input_each">
                <input placeholder="Price*" type="number" class="pro_stream_input" name="pro_album_price" value="{{$album->price}}" />
            </div>
            <div class="pro_stream_input_each">
                <div class="stream_sec_opt_outer">
                    <select name="pro_album_product">
                        <option value="">Do you want to show this album in your store tab?</option> 
                        <option value="0">No</option>
                        <option {{$album->is_product == 1 ? 'selected' : ''}} value="1">Yes</option>
                    </select>
                </div>
            </div>
            <div class="pro_stream_input_each">
                <div class="stream_sec_opt_outer">
                    <div class="stream_sec_opt_checks">
                        <div class="stream_sec_opt_label">
                            Select multiple songs to add to this album
                        </div>
                        @foreach($user->musics as $music)
                        <div class="stream_sec_opt_check_each">
                            <input {{is_array($album->musics) && in_array($music->id,$album->musics) ? 'checked' : ''}} class="pro_check_multiple" value="{{$music->id}}" type="checkbox" name="pro_album_musics[]" />
                            <label> {{$music->song_name}}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="pro_stream_input_each">
                <textarea placeholder="Description" type="text" class="pro_news_textarea" name="pro_album_description">{{$album->description}}</textarea>
            </div><br><br>
            <div class="save_album_outer edit_profile_btn_1 clearfix">
                <a href="javascript:void(0)">Submit</a>
            </div>
        </div>

    </div>


</form>