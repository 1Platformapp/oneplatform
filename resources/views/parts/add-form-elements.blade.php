<!--  Element Samples !-->
<div id="image_sample" class="element_sample">
    <div data-order="1" class="port_each_field">
        <div class="port_field_label">
            <div class="port_field_label_text">Image</div>
            <div class="port_field_remove"><i class="fa fa-trash"></i></div>
        </div>
        <div class="port_field_body">
            <img src="{{asset('images/p_music_thum_img.png')}}" class="custom_file_thumb">
            <input onchange="updatePortThumb(this)" type="file" accept="image/*" class="port_file_input" />
            <input type="hidden" class="extra_info" />
        </div>
    </div>
</div>
<div id="paragraph_sample" class="element_sample">
    <div data-order="1" class="port_each_field">
        <div class="port_field_label">
            <div class="port_field_label_text">Paragraph</div>
            <div class="port_field_remove"><i class="fa fa-trash"></i></div>
        </div>
        <div class="port_field_body">
            <textarea class="port_textarea main_info" placeholder="Write here"></textarea>
            <input type="hidden" class="extra_info" />
        </div>
    </div>
</div>
<div id="youtube_sample" class="element_sample">
    <div data-order="1" class="port_each_field">
        <div class="port_field_label">
            <div class="port_field_label_text">YouTube Video</div>
            <div class="port_field_remove"><i class="fa fa-trash"></i></div>
        </div>
        <div class="port_field_body">
            <input type="text" class="port_field_text main_info" placeholder="Add YouTube URL" />
            <input type="hidden" class="extra_info" />
        </div>
    </div>
</div>
<div id="heading_sample" class="element_sample">
    <div data-order="1" class="port_each_field">
        <div class="port_field_label">
            <div class="port_field_label_text">Heading</div>
            <div class="port_field_remove"><i class="fa fa-trash"></i></div>
        </div>
        <div class="port_field_body">
            <input type="text" class="port_field_text main_info" placeholder="Add Heading" />
            <input type="hidden" class="extra_info" />
        </div>
    </div>
</div>
<div id="question_sample" class="element_sample">
    <div class="port_each_field">
        <div class="port_field_label">
            <div class="port_field_label_text">Question</div>
            <div class="port_field_remove"><i class="fa fa-trash"></i></div>
        </div>
        <div class="port_field_body">
            <textarea class="ques_field_textarea genHeight h-90" placeholder="Type your question" name="question[]"></textarea>
        </div>
    </div>
</div>
<div id="spotify_sample" class="element_sample">
    <div data-order="1" class="port_each_field">
        <div class="port_field_label">
            <div class="port_field_label_text">Spotify URL</div>
            <div class="port_field_remove"><i class="fa fa-trash"></i></div>
        </div>
        <div class="port_field_body">
            <input type="text" class="port_field_text main_info" placeholder="Add Spotify URL" />
            <input type="hidden" class="extra_info" />
        </div>
    </div>
</div>
<div id="ask_question_sample" class="element_sample">
    <div data-order="1" class="port_each_field">
        <div class="port_field_label">
            <div class="port_field_label_text">Supplementary Question</div>
            <div class="port_field_remove"><i class="fa fa-trash"></i></div>
        </div>
        <div class="port_field_body">
            <textarea class="port_textarea main_info" placeholder="Ask a question"></textarea>
            <input type="hidden" class="extra_info" />
        </div>
    </div>
</div>
<div id="pro_pop_chat_upload_sample" class="element_sample">
    <div class="pro_pop_chat_upload_each waiting">
        <div class="pro_pop_each_item item_type item_file instant_hide"><i class="fa fa-file-o"></i></div>
        <div class="pro_pop_each_item item_type item_info instant_hide"><i class="fa fa-info"></i></div>
        <div class="pro_pop_each_item item_name"></div>
        <div class="pro_pop_each_item item_size"></div>
        <div class="pro_pop_each_item item_status"><i class="fa fa-pause"></i></div>
    </div>
</div>
<!--  Element Samples !-->