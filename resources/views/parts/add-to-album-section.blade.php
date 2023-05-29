<div class="pro_aad_albm_outer">
    <h2 class="add_to_album_create_outer">Add To Album</h2>
    <div class="pro_aad_albm_drop add_to_album_add_music">
        <div class="AddtoAlbumPriceSection">
            <ul class="albums_list">
                @include('parts.albums-list', ['albums' => $albums])
            </ul>
        </div>

        <div class="pro_aad_albm_outer_01">
            <h2 class="drop_down_01 add_to_album_create_inner">Create New Album</h2>
            <div class="pro_aad_albm_drop_01 add_to_album_create_drop" style="display: none;">
                <div class="AddtoAlbumPriceSection_01">
                    <label><input placeholder="Add Album Title" id="album_title" name="album_title" type="text"></label>
                    <label><input placeholder="Add Album Price" id="album_price" name="album_price" type="text"></label>
                    <strong><span data-status="create" class="pro_music_crt_alb add_to_album_button" style="cursor: pointer; padding: 25px;"></span></strong>
                </div>
            </div>
        </div>



    </div>
</div>