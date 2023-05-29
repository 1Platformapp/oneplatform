               
               <form enctype="multipart/form-data" data-id="u_info_form_{{$question->id}}" class="" action="{{route('agent.contact.details.save', ['code' => $contact->code, 'action' => 'add-answer'])}}" method="post">

                    {{csrf_field()}}
                    <input type="hidden" name="question_id" value="{{$question->id}}">

                    <div class="port_each_field port_field_checked elem_sortable">
                    	<div class="port_field_label">
                    		<div class="port_field_label_text">Question</div>
                    	</div>
                    	<div class="port_field_body">
                    		<textarea class="port_textarea port_question" placeholder="Question" name="question" {{$isAllowed == 'user' ? 'disabled' : ''}}>{{$question->value}}</textarea>
                    	</div>
                    </div>
                    <br>
                    <div class="add_port_wid_outer">
                    	<div class="port_wid_head">
                    		<i class="fa fa-plus"></i>
                    		<span>Add To Answer</span>
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
                    			<div data-id="paragraph" class="port_wid_drop_each add_element">
	                    			<i class="fa fa-paragraph"></i> 
	                    			<span>Paragraph</span>
	                    		</div>
                    			<div data-id="heading" class="port_wid_drop_each add_element"> 
	                    			<i class="fa fa-header"></i>
	                    			<span>Heading</span>
	                    		</div>
	                    		<div data-id="image" class="port_wid_drop_each add_element">
	                    			<i class="fa fa-image"></i> 
	                    			<span>Image</span>
	                    		</div>
	                    		<div data-id="youtube" class="port_wid_drop_each add_element">
	                    			<i class="fa fa-youtube"></i> 
	                    			<span>YouTube Video</span>
	                    		</div>
                                <div data-id="spotify" class="port_wid_drop_each add_element">
                                    <i class="fa fa-spotify"></i> 
                                    <span>Spotify URL</span>
                                </div>
                                <div data-id="ask_question" class="port_wid_drop_each add_element">
                                    <i class="fa fa-question-circle"></i> 
                                    <span>Ask Question</span>
                                </div>
	                    	</div>
                    	</div>
                    </div>

                    <div class="element_container">
                        @if(count($question->elements))
                        @foreach($question->elements as $element)
                    		@if($element->type == 'heading')
                    		<div data-sort="qans_{{$element->id}}" data-order="{{$element->order}}" class="port_each_field port_field_checked elem_sortable">
                    		    <div class="port_field_label">
                    		        <div class="port_field_label_text">Heading</div>
                                    <div class="port_field_label_tools">
                                        @if(Auth::check())
                                        <div class="edit_elem_sort_up">
                                            <i class="fa fa-hand-o-up"></i>
                                        </div>
                                        <div class="edit_elem_sort_down">
                                            <i class="fa fa-hand-o-down"></i>
                                        </div>
                                        @endif
                                        <div class="port_field_remove"><i class="fa fa-trash"></i></div>
                                    </div>
                    		    </div>
                    		    <div class="port_field_body">
                    		        <input type="text" class="port_field_text main_info" placeholder="Add Heading" name="element[{{$element->order}}][0][]" value="{{$element->value}}" />
                    		        <input type="hidden" class="extra_info" value="heading" name="element[{{$element->order}}][1][]" />
                    		    </div>
                    		</div>
                    		@endif
                    		@if($element->type == 'paragraph')
                    		<div data-sort="qans_{{$element->id}}" data-order="{{$element->order}}" class="port_each_field port_field_checked elem_sortable">
                    		    <div class="port_field_label">
                    		        <div class="port_field_label_text">Paragraph</div>
                    		        <div class="port_field_label_tools">
                                        @if(Auth::check())
                                        <div class="edit_elem_sort_up">
                                            <i class="fa fa-hand-o-up"></i>
                                        </div>
                                        <div class="edit_elem_sort_down">
                                            <i class="fa fa-hand-o-down"></i>
                                        </div>
                                        @endif
                                        <div class="port_field_remove"><i class="fa fa-trash"></i></div>
                                    </div>
                    		    </div>
                    		    <div class="port_field_body">
                    		        <textarea class="port_textarea main_info" placeholder="Add your answer here" name="element[{{$element->order}}][0][]">{{$element->value}}</textarea>
                    		        <input type="hidden" class="extra_info" value="paragraph" name="element[{{$element->order}}][1][]" />
                    		    </div>
                    		</div>
                    		@endif
                    		@if($element->type == 'youtube')
                    		<div data-sort="qans_{{$element->id}}" data-order="{{$element->order}}" class="port_each_field port_field_checked elem_sortable">
                    		    <div class="port_field_label">
                    		        <div class="port_field_label_text">YouTube Video</div>
                    		        <div class="port_field_label_tools">
                                        @if(Auth::check())
                                        <div class="edit_elem_sort_up">
                                            <i class="fa fa-hand-o-up"></i>
                                        </div>
                                        <div class="edit_elem_sort_down">
                                            <i class="fa fa-hand-o-down"></i>
                                        </div>
                                        @endif
                                        <div class="port_field_remove"><i class="fa fa-trash"></i></div>
                                    </div>
                    		    </div>
                    		    <div class="port_field_body">
                    		        <input type="text" class="port_field_text main_info" placeholder="Add YouTube URL" name="element[{{$element->order}}][0][]" value="{{$element->value}}" />
                    		        <input type="hidden" class="extra_info" value="youtube" name="element[{{$element->order}}][1][]" />
                    		    </div>
                    		</div>
                    		@endif
                    		@if($element->type == 'image')
                    		<div data-sort="qans_{{$element->id}}" data-order="{{$element->order}}" class="port_each_field port_field_checked elem_sortable">
                    		    <div class="port_field_label">
                    		        <div class="port_field_label_text">Image</div>
                    		        <div class="port_field_label_tools">
                                        @if(Auth::check())
                                        <div class="edit_elem_sort_up">
                                            <i class="fa fa-hand-o-up"></i>
                                        </div>
                                        <div class="edit_elem_sort_down">
                                            <i class="fa fa-hand-o-down"></i>
                                        </div>
                                        @endif
                                        <div class="port_field_remove"><i class="fa fa-trash"></i></div>
                                    </div>
                    		    </div>
                    		    <div class="port_field_body">
                    		        <img src="{{asset('contact-info-images/'.$element->value)}}" class="custom_file_thumb">
                    		        <input name="element[{{$element->order}}][0][]" onchange="updatePortThumb(this)" type="file" accept="image/jpg,image/jpeg,image/png,image/gif" class="port_file_input" />
                                      <input type="hidden" class="extra_info" value="image" name="element[{{$element->order}}][1][]" />
                    		    </div>
                    		</div>
                    		@endif
                            @if($element->type == 'spotify')
                            <div data-sort="qans_{{$element->id}}" data-order="{{$element->order}}" class="port_each_field port_field_checked elem_sortable">
                                <div class="port_field_label">
                                    <div class="port_field_label_text">Spotify URL</div>
                                    <div class="port_field_label_tools">
                                        @if(Auth::check())
                                        <div class="edit_elem_sort_up">
                                            <i class="fa fa-hand-o-up"></i>
                                        </div>
                                        <div class="edit_elem_sort_down">
                                            <i class="fa fa-hand-o-down"></i>
                                        </div>
                                        @endif
                                        <div class="port_field_remove"><i class="fa fa-trash"></i></div>
                                    </div>
                                </div>
                                <div class="port_field_body">
                                    <input type="text" class="port_field_text main_info" placeholder="Add Spotify URL" name="element[{{$element->order}}][0][]" value="{{$element->value}}" />
                                    <input type="hidden" class="extra_info" value="spotify" name="element[{{$element->order}}][1][]" />
                                </div>
                            </div>
                            @endif
                            @if($element->type == 'ask-question')
                            <div data-sort="qans_{{$element->id}}" data-order="{{$element->order}}" class="port_each_field port_field_checked elem_sortable">
                                <div class="port_field_label">
                                    <div class="port_field_label_text">Supplementary Question</div>
                                    <div class="port_field_label_tools">
                                        @if(Auth::check())
                                        <div class="edit_elem_sort_up">
                                            <i class="fa fa-hand-o-up"></i>
                                        </div>
                                        <div class="edit_elem_sort_down">
                                            <i class="fa fa-hand-o-down"></i>
                                        </div>
                                        @endif
                                        <div class="port_field_remove"><i class="fa fa-trash"></i></div>
                                    </div>
                                </div>
                                <div class="port_field_body">
                                    <textarea class="port_textarea main_info" placeholder="As a question" name="element[{{$element->order}}][0][]">{{$element->value}}</textarea>
                                    <input type="hidden" class="extra_info" value="ask-question" name="element[{{$element->order}}][1][]" />
                                </div>
                            </div>
                            @endif
                    	@endforeach
                        @else
                            <div data-order="1" class="port_each_field port_field_checked">
                                <div class="port_field_label">
                                    <div class="port_field_label_text">Paragraph</div>
                                    <div class="port_field_remove"><i class="fa fa-trash"></i></div>
                                </div>
                                <div class="port_field_body">
                                    <textarea class="port_textarea main_info" placeholder="Add your answer here" name="element[1][0][]"></textarea>
                                    <input type="hidden" class="extra_info" value="paragraph" name="element[1][1][]" />
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="action_btn">
                        <div class="save_portfolio_outer edit_profile_btn_1 clearfix">
                            <a href="javascript:void(0)">Save </a>
                        </div>
                    </div>
                </form>