@foreach($userCampaign->perks as $key => $bonus)
    <div class="each_bonus_outer">
        <div class="proj_bonus_sec clearfix">

            <label>Bonus Title *</label>
            <input class="read_bonus_field" disabled="readonly" value="{{ $bonus->title }}" name="bonusTitle" type="text" placeholder="Bonus Title" />
            <p>The title for your bonus tells your supporters what you are oftering them. So a good title describes what the bonus contains.  </p>
            <p>Once a bonus has been claimed it cannot be deleted or edited*</p>

            <label>Bonus Thumbnail (Optional)</label>
            <div class="proj_bonus_thumb_sec">
                <span><img src="{{ ( $bonus->thumbnail != '' ) ? asset('user-bonus-thumbnails').'/'.$bonus->thumbnail : asset('/images/p_music_thum_img.png') }}" alt="#" /></span>
            </div>
            <label>Bonus Description *</label>
            <textarea class="read_bonus_field" disabled="readonly" name="bonusDescription">{{ $bonus->description }}</textarea>
            <p>Tell your supporters about this bonus, make it sound fun and exciting. </p>

            <label>Amount Of Bonuses Available*</label>
            <input class="read_bonus_field" disabled="readonly" value="{{ $bonus->items_available }}" name="bonusQuantity" type="text" placeholder="" />
            <p>How many of these Bonuses are available? </p>

            <label>Bonus Items *</label>
            <input class="read_bonus_field" disabled="readonly" value="{{ $bonus->items_included }}" name="bonusItemsIncluded" type="text" placeholder="" />
            <p>What items are included in the bonus. A signed CD? A cover song? Don’t forget to seperate items with a comma</p>

            <label>Bonus Price *</label>
            <input class="read_bonus_field" disabled="readonly" value="{{ $bonus->amount }}" name="bonusPrice" type="text" placeholder="$" />
            <p>Cost of the bonus, Rember that this cost includes all items in the bonus</p>

        </div>
        <div class="proj_ship_sec">
            <label>Shipping Cost *</label>

            <div class="proj_ship_flt_outer clearfix">
                <div class="proj_ship_flt_left clearfix">
                    <span>{{ $bonus->worldwide_delivery_cost_currency }}</span><input disabled="readonly" value="{{ $bonus->worldwide_delivery_cost }}" name="bonusWorldwideDelivery" type="" placeholder="" />
                </div>
                <label>Worldwide delivery cost</label>
            </div>
            <div class="proj_ship_flt_outer clearfix">
                <div class="proj_ship_flt_left clearfix">
                    <span>{{ $bonus->my_country_delivery_cost_currency }}</span><input disabled="readonly" value="{{ $bonus->my_country_delivery_cost }}" name="bonusLocalDelivery" type="" placeholder="" />
                </div>
                <label>My country delivery cost</label>
            </div>

            <input type="hidden" name="currency" value="{{ $bonus->currency }}">
            <input type="hidden" name="worldwide_delivery_cost_currency" value="{{ $bonus->worldwide_delivery_cost_currency }}">
            <input type="hidden" name="my_country_delivery_cost_currency" value="{{ $bonus->my_country_delivery_cost_currency }}">
            <br>
            <div class="proj_ship_flt_outer prof_btn_contain clearfix">
                <ul>
                    <li><a data-del-id="{{ $bonus->id }}" data-campaign-id="{{ $bonus->campaign_id }}" class="delete_bonus" href="#" class="proj_del_btn">Delete</a></li>
                    <li><a data-id="{{ $bonus->id }}" data-campaign-id="{{ $bonus->campaign_id }}" class="edit_bonus" href="#">Edit Bonus</a></li>
                </ul>
            </div>
        </div>
    </div>
@endforeach