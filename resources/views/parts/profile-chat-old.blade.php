
@if(Session::has('pagecontentopener'))
    <script>
        var ses = "{{Session::get('pagecontentopener')}}";
        sessionStorage.setItem('pagecontentopener', ses);
    </script>
@endif

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
            var to = $('#profile_tab_14 .agent_questionnaire_outer .orders_bottom_arrow.opened').first().closest('.my_sub_sec').attr('data-skill');
            if(from != ''){

                if(confirm('This action will append questions from '+ from +' into ' + to)){

                    var fromElem = $('.agent_questionnaire_outer .my_sub_sec[data-skill="'+from+'"]');
                    var toElem = $('.agent_questionnaire_outer .my_sub_sec[data-skill="'+to+'"]');
                    if(fromElem.length && toElem.length){

                        var elements = fromElem.find('.profile_orders_slide_win .port_each_field.port_field_checked');
                        if(elements.length){
                            elements.each(function(){
                                var clone = $(this)[0].outerHTML;
                                toElem.find('.profile_orders_slide_win .element_container').append(clone);
                            });
                        }
                    }
                }
            }
        });

    });

</script>
<?php

$display = 'display: block;';
if($page != 'chat')
    $display = 'display: none;';
?>
<div id="profile_tab_14" class="pro_pg_tb_det" style="{{$display}}">
    <div class="pro_pg_tb_det_inner">

        <div id="questionnaire_section" class="sub_cat_data {{$subTab == 'questionnaires' ? '' : 'instant_hide'}}">
            <div class="pro_main_tray">
                <div class="pro_tray_title">Manage Questionnaires</div>
            </div>
            <div class="pro_music_search pro_music_info no_border">
                <div class="pro_note">
                    <ul>
                        <li>Here you can manage your questionnaire for each skill listed below</li>
                        <li>You can add/remove questions from a questionnaire</li>
                        <li>The questionnaire can be attached to a contact in edit contact section. The contact person will get a link to that questionnaire in email, can fill it up and when the contact submits, you will get notified</li>
                        <li>Questionnaire submission by a contact can be seen individually or a spreadsheet containing all of them can be downloaded</li>
                    </ul>
                </div>
            </div>
            <div class="agent_questionnaire_outer">

                @php $skills = \App\Models\Skill::all() @endphp

                @foreach($skills as $skill)
                @endforeach
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{asset('css/profile.chat-old.css?v=1.5')}}">
