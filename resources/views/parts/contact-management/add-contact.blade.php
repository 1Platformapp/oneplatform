
<div class="mt-12 each-stage-det" data-stage-ref="add-contact">
    <div class="hidden pro_music_search pro_music_info no_border">
        <div class="pro_note">
            <ul>
                <li>Create a new contact in your network</li>
                <li>Enter the name, email, commission (if any) and terms (if any). The contact person will be offered to accept or decline this agreement. If its accepted the contact person becomes a 1platform user and can login with your given credentials and can connect a bank account and start selling or providing any services</li>
                <li>You will get a commission (if you have provided one) for each sale your contact person will receive through you</li>
                <li>After you have created a new contact, you can EDIT and set up an account</li>
                <li>After you have set up your contact's account, commission amount and terms, go to edit contact, enter the email and submit. This will send out an email to your contact person and will ask for the approval</li>
            </ul>
        </div>
    </div>
    <form id="add-contact-form" action="{{route('agent.contact.create')}}" method="POST">
        {{ csrf_field() }}
        <div class="pro_stream_input_outer">
            <div class="pro_stream_input_each">
                <input placeholder="Name" type="text" class="pro_stream_input" name="pro_contact_name" />
            </div>
            <div class="pro_stream_input_row">
                <div class="pro_stream_input_each">
                    <div class="stream_sec_opt_outer">
                        <select name="pro_contact_already_user">
                            <option value="">Is this person already registered at 1Platform?</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
                <div class="pro_stream_input_each">
                    <input disabled="" placeholder="Email of user registered at 1Platform" type="text" class="pro_stream_input" name="pro_contact_already_user_email">
                </div>
            </div><br><br>
            <div class="pro_m_chech_outer flex">
                <button type="button" class="add-contact-submit w-full md:w-auto ml-auto bg-white shadow-custom md:shadow-lg hover:shadow-custom rounded-md text-md font-semibold text-gray-600 px-10 py-2 cursor-pointer text-center">
                    Submit
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    $('document').ready(function(){

        $('select[name="pro_contact_already_user"]').change(function(){

            if($(this).val() == '1'){

                $('input[name="pro_contact_already_user_email"]').prop('disabled', false).focus();
            }else{

                $('input[name="pro_contact_already_user_email"]').val('').prop('disabled', true);
            }
        });

        $('.add-contact-submit').click(function(e){

            e.preventDefault();
            var thiss = $(this);
            var error = 0;

            var form = $('#add-contact-form');
            form.find('.pro_stream_input_each.has-danger').removeClass('has-danger');

            var name = form.find('input[name=pro_contact_name]');
            var alreadyUser = form.find('select[name="pro_contact_already_user"]');
            var alreadyUserEmail = form.find('input[name="pro_contact_already_user_email"]');

            if( name.val() == '' ){ error = 1; name.closest('.pro_stream_input_each').addClass('has-danger'); }
            if(alreadyUser.val() == '1' && alreadyUserEmail.val() == ''){

                error = 1;
                alreadyUserEmail.closest('.pro_stream_input_each').addClass('has-danger');
            }

            var browserWidth = $( window ).width();

            if( browserWidth <= 767 ) { var margin = 50; }
            else { var margin = 30+44; }

            if(!error){

                form.submit();
            }
        });
    });
</script>
