<div class="pro_aad_albm_outer">
    <h2 class="add_to_album_edit_dropdown_outer" data-musicid="{{ $music->id }}">Add To Album</h2>
    <div class="pro_aad_albm_drop add_to_album_edit_drop_outer_{{ $music->id }}">
        <div class="AddtoAlbumPriceSection">
            <ul class="albums_list_edit_{{ $music->id }}">

                @include('parts.albums-list-edit', ['albums' => $albums, 'music' => $music])

            </ul>
        </div>

        <div class="pro_aad_albm_outer_01">
            <h2 class="drop_down_01 add_to_album_edit_inner">Create New Album</h2>
            <div class="pro_aad_albm_drop_01 add_to_album_edit_drop" style="display: none;">
                <div class="AddtoAlbumPriceSection_01">
                    <label><input placeholder="Add Album Title" id="album_title_{{ $music->id }}" name="album_title" type="text"></label>
                    <label><input placeholder="Add Album Price" id="album_price_{{ $music->id }}" name="album_price" type="text"></label>
                    <strong><span data-status="edit" data-musicid="{{ $music->id }}" class="pro_music_crt_alb add_to_album_button" style="cursor: pointer; padding: 25px;"></span></strong>
                </div>
            </div>
        </div>



    </div>
</div>