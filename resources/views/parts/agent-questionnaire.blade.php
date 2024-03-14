
@php $agentQuestionnaires = \App\Models\AgentQuestionnaire::where(['agent_id' => Auth::user()->id])->get(); @endphp
@php $creativeBriefs = \App\Models\CreativeBrief::all() @endphp
<div data-skill="{{$creativeBrief->title}}" class="my_sub_sec">
    <div class="instant_hide other-questionnaires">
        @foreach($agentQuestionnaires as $agentQuestionnaire)
        <div class="each-other-questionnaire" data-brief-id="{{$agentQuestionnaire->brief_id}}">
            @if($agentQuestionnaire && count($agentQuestionnaire->questions))
                @foreach($agentQuestionnaire->questions as $eachQues)
                    <div class="port_each_field port_field_checked">
                        <div class="port_field_label">
                            <div class="port_field_label_text">Question</div>
                            <div class="port_field_remove"><i class="fa fa-trash"></i></div>
                        </div>
                        <div class="port_field_body">
                            <textarea class="ques_field_textarea genHeight h-90" placeholder="Type your question" name="question[]">{{$eachQues->value}}</textarea>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        @endforeach
    </div>
    <div class="my_sub_sec_inner">
        <h3><span class="text-lg head_text">Creative Brief: {{$creativeBrief->title}}</span></h3>
        <form action="{{route('agent.manage.questionnaire')}}" method="POST">
            {{csrf_field()}}
            <input type="hidden" name="brief_id" value="{{$creativeBrief->id}}">
            <div class="agent_que_actions">
                <div data-id="add_question_btn" class="agent_que_action_btn">
                    <i class="fa fa-plus"></i> Add question
                </div>
                <div data-id="import_questions" class="agent_que_action_btn">
                    <select class="agent_que_import">
                        <option value="" selected disabled>Import Questions From</option>
                        @foreach($creativeBriefs as $brief)
                            @if($brief->title != $creativeBrief->title)
                                <option value="{{$brief->id}}" data-brief-title="{{$brief->title}}">{{$brief->title}}</option>
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
                                <textarea class="ques_field_textarea genHeight h-90" placeholder="Type your question" name="question[]">{{$question->value}}</textarea>
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
                            <textarea class="ques_field_textarea genHeight h-90" placeholder="Type your question" name="question[]"></textarea>
                        </div>
                    </div>
                @endif
            </div>

            <div class="clearfix save_questionnaire_outer edit_profile_btn_1">
                <a href="javascript:void(0)">Save </a>
            </div>
        </form>
    </div>
</div>
<script>

    $('document').ready(function(){

        $('.agent_que_action_btn').click(function(){

            var thiss = $(this);
            if(thiss.attr('data-id') == 'add_question_btn'){

                var element = $('#question_sample');
                thiss.closest('form').find('.element_container').append(element.html());
                thiss.closest('form').find('.element_container .port_each_field:last-child').addClass('port_field_checked');
            }
        });

        $('.save_questionnaire_outer').click(function(){

            $(this).closest('form').submit();
        });

        $('.agent_que_import').change(function(){

            var from = $(this).val();
            const selectedOption = this.options[this.selectedIndex];
            const briefTitle = selectedOption.dataset.briefTitle;

            var toElem = $(this).closest('form').find('.element_container');
            if(confirm('This action will import questions from ' + briefTitle)){
                var fromElem = $('.other-questionnaires .each-other-questionnaire[data-brief-id="'+from+'"]');
                if(fromElem.length && toElem.length){
                    var clone = fromElem[0].innerHTML;
                    toElem.append(clone);
                }
            } else {
                this.value = '';
            }
        });

    });

    $('body').delegate('.port_field_remove', 'click', function(e){

        if(confirm('Are you sure?')){

            $(this).closest('.port_field_checked').remove();
        }
    });

</script>
