               
               <form enctype="multipart/form-data" data-id="u_port_form_{{$portfolio->id}}" class="edit_port_form" action="{{route('save.user.portfolio')}}" method="post">

                    <div class="pro_music_info">
                         <label>
                              <i class="fa fa-times edit_elem_close"></i>
                         </label>
                    </div>

                    {{csrf_field()}}
                    <input type="hidden" name="portfolio_id" value="{{$portfolio->id}}">

                    <div class="element_container">
                         <div class="port_each_field">
                             <div class="port_field_label">
                                 <div class="port_field_label_text">Title</div>
                             </div>
                             <div class="port_field_body">
                                 <input type="text" class="port_field_text port_title" placeholder="Add Title" name="title" value="{{$portfolio->title}}" />
                             </div>
                         </div>
                         <div class="port_each_field">
                             <div class="port_field_label">
                                 <div class="port_field_label_text">Thumbnail</div>
                             </div>
                             <div class="port_field_body">
                                <div data-id="{{$portfolio->id}}" class="demo-wrap upload-demo">
                                    <div class="upload-current">
                                      <img src="{{asset('portfolio-images/'.$portfolio->displayImage())}}" class="custom_file_thumb">
                                    </div>
                                    <div class="upload-demo-wrap">
                                        <div class="init_croppie"></div>
                                    </div>
                                    <a class="btn file-btn">
                                        <i class="fa fa-upload"></i> <span>Choose a thumbnail</span>
                                        <input type="file" class="port_thumb_upload" value="Choose a file" accept="image/*" />
                                    </a>
                                </div>
                             </div>
                         </div>
                         <div class="add_port_wid_outer">
                            <div class="port_wid_head">
                                <i class="fa fa-plus"></i>
                                <span>Add Widget</span>
                            </div>
                            <div class="port_wid_drop_outer">
                                <span class="top_adjust">
                                    <i class="fa fa-caret-up"></i>
                                </span>
                                <div class="port_wid_drop_inner">
                                    <div class="head">
                                        <span>Choose widget</span>
                                        <i class="fa fa-times"></i>
                                    </div>
                                    <div data-id="heading" class="port_wid_drop_each add_element"> 
                                        <i class="fa fa-header"></i>
                                        <span>Add Heading</span>
                                    </div>
                                    <div data-id="paragraph" class="port_wid_drop_each add_element">
                                        <i class="fa fa-paragraph"></i> 
                                        <span>Add Paragraph</span>
                                    </div>
                                    <div data-id="image" class="port_wid_drop_each add_element">
                                        <i class="fa fa-image"></i> 
                                        <span>Add Image</span>
                                    </div>
                                    <div data-id="youtube" class="port_wid_drop_each add_element">
                                        <i class="fa fa-youtube"></i> 
                                        <span>Add YouTube Video</span>
                                    </div>
                                    <div data-id="spotify" class="port_wid_drop_each add_element">
                                        <i class="fa fa-spotify"></i> 
                                        <span>Add Spotify URL</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                         @if(!isset($sandbox))
                         <div class="port_each_field">
                            <div class="port_field_label">
                                <div class="port_field_label_text">Connect a product with this portfolio (optional)</div>
                            </div>
                            <div class="port_field_body pro_stream_input_each">
                                <div class="stream_sec_opt_outer">
                                    <select name="product">
                                        <option value="">Choose a product</option>
                                        @foreach($user->products as $product)
                                        <option {{$portfolio->product && $product->id == $portfolio->product->id ? 'selected' : ''}} value="{{$product->id}}">{{$product->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @else
                         <div class="port_each_field">
                            <div class="port_field_label">
                                <div class="port_field_label_text">Do you want to make this portfolio live?</div>
                            </div>
                            <div class="port_field_body pro_stream_input_each">
                                <div class="stream_sec_opt_outer">
                                    <select name="live">
                                        <option value="">Choose yes or no</option>
                                        <option {{$portfolio->is_live == '1' ? 'selected' : ''}} value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endif
                    	@foreach($portfolio->elements as $element)

                    		@if($element->type == 'heading')
                    		<div data-order="{{$element->order}}" class="port_each_field port_field_checked">
                    		    <div class="port_field_label">
                    		        <div class="port_field_label_text">Heading</div>
                    		        <div class="port_field_remove"><i class="fa fa-trash"></i></div>
                    		    </div>
                    		    <div class="port_field_body">
                    		        <input type="text" class="port_field_text main_info" placeholder="Add Heading" name="element[{{$element->order}}][0][]" value="{{$element->value}}" />
                    		        <input type="hidden" class="extra_info" value="heading" name="element[{{$element->order}}][1][]" />
                    		    </div>
                    		</div>
                    		@endif
                    		@if($element->type == 'paragraph')
                    		<div data-order="{{$element->order}}" class="port_each_field port_field_checked">
                    		    <div class="port_field_label">
                    		        <div class="port_field_label_text">Paragraph</div>
                    		        <div class="port_field_remove"><i class="fa fa-trash"></i></div>
                    		    </div>
                    		    <div class="port_field_body">
                    		        <textarea class="port_textarea main_info" placeholder="Write here" name="element[{{$element->order}}][0][]">{{$element->value}}</textarea>
                    		        <input type="hidden" class="extra_info" value="paragraph" name="element[{{$element->order}}][1][]" />
                    		    </div>
                    		</div>
                    		@endif
                    		@if($element->type == 'youtube')
                    		<div data-order="{{$element->order}}" class="port_each_field port_field_checked">
                    		    <div class="port_field_label">
                    		        <div class="port_field_label_text">YouTube Video</div>
                    		        <div class="port_field_remove"><i class="fa fa-trash"></i></div>
                    		    </div>
                    		    <div class="port_field_body">
                    		        <input type="text" class="port_field_text main_info" placeholder="Add YouTube URL" name="element[{{$element->order}}][0][]" value="{{$element->value}}" />
                    		        <input type="hidden" class="extra_info" value="youtube" name="element[{{$element->order}}][1][]" />
                    		    </div>
                    		</div>
                    		@endif
                    		@if($element->type == 'image')
                    		<div data-order="{{$element->order}}" class="port_each_field port_field_checked">
                    		    <div class="port_field_label">
                    		        <div class="port_field_label_text">Image</div>
                    		        <div class="port_field_remove"><i class="fa fa-trash"></i></div>
                    		    </div>
                    		    <div class="port_field_body">
                    		        <img src="{{asset('portfolio-images/'.$element->value)}}" class="custom_file_thumb">
                    		        <input name="element[{{$element->order}}][0][]" onchange="updatePortThumb(this)" type="file" accept="image/jpg,image/jpeg,image/png,image/gif" class="port_file_input" />
                                      <input type="hidden" class="extra_info" value="image" name="element[{{$element->order}}][1][]" />
                    		    </div>
                    		</div>
                    		@endif
                            @if($element->type == 'spotify')
                            <div data-order="{{$element->order}}" class="port_each_field port_field_checked">
                                <div class="port_field_label">
                                    <div class="port_field_label_text">Spotify URL</div>
                                    <div class="port_field_remove"><i class="fa fa-trash"></i></div>
                                </div>
                                <div class="port_field_body">
                                    <input type="text" class="port_field_text main_info" placeholder="Add Spotify URL" name="element[{{$element->order}}][0][]" value="{{$element->value}}" />
                                    <input type="hidden" class="extra_info" value="spotify" name="element[{{$element->order}}][1][]" />
                                </div>
                            </div>
                            @endif
                    	@endforeach
                    </div>

                    <div class="save_portfolio_outer edit_profile_btn_1 clearfix">
                        <a href="javascript:void(0)">Save </a>
                    </div>
                    <input type="hidden" value="" class="port_thumb_data" name="port_thumb_data" />
                    @if(isset($sandbox))
                    <input type="hidden" value="{{$contact->contactUser->id}}" class="port_thumb_data" name="port_sandbox" />
                    @endif
                </form>