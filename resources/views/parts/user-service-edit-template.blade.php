<form data-id="my-service-form_{{ $service->id }}" action="{{route('save.user.service')}}" method="POST" enctype="multipart/form-data" style="display: none;">
    {{ csrf_field() }}

    <input type="hidden" name="edit" value="{{ $service->id }}">
    <div class="pro_music_info">
        <label>
            <i class="fa fa-times edit_elem_close"></i>
        </label>
    </div>
    <input type="hidden" class="pro_service_val" name="pro_service" value="">
    <div class="pro_stream_input_each">
        <div class="pro_input_icon">
            <input autocomplete="off" value="{{$service->service_name}}" placeholder="Enter a service name (e.g Photoshoot)" type="text" class="pro_stream_input pro_service_search" name="pro_service">
        </div>
        <div class="pro_services_results pro_custom_drop_res instant_hide clearfix">
            <div class="pro_services_list_drop">
                <ul></ul>
            </div>
        </div>
    </div>
    <div class="pro_stream_input_row">
        <div class="pro_stream_input_each">
            <div class="stream_sec_opt_outer">
                <select class="pro_service_price_option" name="pro_service_price_option">
                    <option value="">Choose price</option>
                    <option {{$service->price_option == '1' ? 'selected' : ''}} value="1">Add price</option>
                    <option {{$service->price_option == '2' ? 'selected' : ''}} value="2">No price</option>
                    <option {{$service->price_option == '3' ? 'selected' : ''}} value="3">POA</option>
                </select>
            </div>
        </div>
        <div class="pro_stream_input_row">
            <div class="pro_stream_input_each">
                <input {{!$service->price ? 'disabled' : ''}} value="{{$service->price}}" placeholder="Enter price" type="number" class="pro_stream_input pro_service_price" name="pro_service_price">
            </div>
            <div class="pro_stream_input_each">
                <div class="stream_sec_opt_outer">
                    <select class="pro_service_price_interval" {{!$service->price_interval ? 'disabled' : ''}}  name="pro_service_price_interval">
                        <option value="">Choose pricing interval</option>
                        <option {{$service->price_interval == 'no' ? 'selected' : ''}} value="no">No Interval</option>
                        <option {{$service->price_interval == 'hour' ? 'selected' : ''}} value="hour">Hour</option>
                        <option {{$service->price_interval == 'day' ? 'selected' : ''}} value="day">Day</option>
                        <option {{$service->price_interval == 'month' ? 'selected' : ''}} value="month">Month</option>
                        <option {{$service->price_interval == 'year' ? 'selected' : ''}} value="year">Year</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="save_service_outer edit_profile_btn_1 clearfix">
        <a href="javascript:void(0)">Submit </a>
    </div>
</form>