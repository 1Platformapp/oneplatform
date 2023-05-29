@php $commonMethods = new \App\Http\Controllers\CommonMethods() @endphp
@foreach($albums as $album)
    <li>
        <a data-albumid="{{ $album->id }}" data-type="create" style="cursor: pointer;">
            <div class="AddtoAlbumData">
                <span class="AddtoAlbumTitle"> {{ $album->title }}</span>
                <span class="AddtoAlbumPrice">{{$commonMethods->getCurrencySymbol(strtoupper(Auth::user()->profile->default_currency))}}{{ $album->price }}</span>
                <div class="m_btm_right_icons">
                    <span class="m_btm_edit" onclick="editAlbumClicked({{ "'#edit_album_part_" . $album->id . "'"  }})"></span>
                    <span data-albumid="{{ $album->id }}" data-tempaltestatus="create" data-musicid="0" class="m_btm_del delete_album_button" onclick="deleteAlbumClicked()"></span>
                </div>
            </div>
        </a>

        <div class="pro_aad_albm_outer_01">
            <div class="pro_aad_albm_drop_01" style="display: none;" id="edit_album_part_{{ $album->id }}">
                <div class="AddtoAlbumPriceSection_01">
                    <label><input placeholder="Add Album Title" id="album_title_{{ $album->id }}" type="text"></label>
                    <label><input placeholder="Add Album Price" id="album_price_{{ $album->id }}" type="text"></label>
                    <strong><span data-albumid="{{ $album->id }}" data-status="create" class="pro_music_crt_alb edit_album_button" style="cursor: pointer; padding: 25px;"></span></strong>
                </div>
            </div>
        </div>

    </li>
@endforeach