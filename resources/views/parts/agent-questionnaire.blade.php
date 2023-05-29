
@php $questionnaire = \App\Models\AgentQuestionnaire::where(['agent_id' => Auth::user()->id, 'skill' => $skill])->first() @endphp
@php $skills = \App\Models\Skill::all() @endphp

<div data-skill="{{$skill}}" class="my_sub_sec">
    <div class="my_sub_sec_inner">
        <h3>
            <span class="head_text">{{$skill}}</span>
            <i class="fa fa-angle-down orders_bottom_arrow"></i>
        </h3>
        <div class="profile_orders_slide_win">
            <form action="{{route('agent.manage.questionnaire')}}" method="POST">
            	{{csrf_field()}}
            	<input type="hidden" name="skill" value="{{$skill}}">
	            <div class="agent_que_actions">
	            	<div data-id="add_question_btn" class="agent_que_action_btn">
	            	    <i class="fa fa-plus"></i> Add question
	            	</div>
	            	<div data-id="import_questions" class="agent_que_action_btn">
	            		<select class="agent_que_import">
	            	            <option value="">Import Questions From</option> 
	            	            @foreach($skills as $skilll)
	            	            	@if($skilll->value != $skill)
	            	            		<option value="{{$skilll->value}}">{{$skilll->value}}</option>
	            	            	@endif
	            	            @endforeach
	            	    </select>
	            	</div>
	            </div>
	            <div class="element_container">
	            	@if($questionnaire && count($questionnaire->questions))
	            		@foreach($questionnaire->questions as $question)
	            			@if($question->type == 'text')
	            			<div class="port_each_field port_field_checked">
	            			    <div class="port_field_label">
	            			        <div class="port_field_label_text">Question</div>
	            			        <div class="port_field_remove"><i class="fa fa-trash"></i></div>
	            			    </div>
	            			    <div class="port_field_body">
	            			    	<textarea class="ques_field_textarea main_info" placeholder="Type your question" name="question[]">{{$question->value}}</textarea>
	            			    </div>
	            			</div>
	            			@endif
	            		@endforeach
	            	@else
	            		<div class="port_each_field">
	            		    <div class="port_field_label">
	            		        <div class="port_field_label_text">Question</div>
	            		    </div>
	            		    <div class="port_field_body">
	            		        <textarea class="ques_field_textarea main_info" placeholder="Type your question" name="question[]"></textarea>
	            		    </div>
	            		</div>
	            	@endif
	            </div>

	            <div class="save_questionnaire_outer edit_profile_btn_1 clearfix">
	                <a href="javascript:void(0)">Save </a>
	            </div>
	        </form>
        </div>
    </div>
</div>