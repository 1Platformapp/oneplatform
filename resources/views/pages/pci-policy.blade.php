@extends('templates.basic-template')

<!-- Page Level CSS !-->
@section('page-level-css')
    <style>
        
        .faq_main_outer h3 { font-size: 17px; margin-top: 22px;  margin-bottom: 8px;}
        .faq_main_outer p { font-size: 13px; line-height: 20px; color: #818181; }
        .faq_main_outer { width: 100%; padding: 40px 85px; font-family: Open sans, sans-serif; }

        @media (min-width:320px) and (max-width: 767px) {

        	.faq_main_outer { padding: 40px 20px !important; }
        	.faq_main_outer p { font-size: 12px; }
        	.faq_main_outer h3 { font-size: 15px; line-height: 23px; }
        }

        .pci-list li { list-style: disc; line-height: 25px; }
        h4 { line-height: 25px; }
        .each_card { max-width: 50px; margin: 0 3px; display: inline-block; }
    </style>
@stop

<!-- Page Level Javascript !-->
@section('page-level-js')

    <!--  initialize horizontal scroller  !-->
    <script src="/js/horizontal-slider.js" type="application/javascript"></script>
@stop

<!-- Page Header !-->
@section('header')

    @include('parts.header')
@stop

<!-- facebook/twitter share Login !-->
@section('social-media-html')


@stop


@section('page-content')
<div class="faq_main_outer">
	<h2 style="text-align: center; margin-bottom: 40px; font-size: 27px;">1 Platform PCI DSS Policy</h2>
        
    <h4><b>Issue Date:</b> 29-04-2020</h4>
    <h4><b>Reviewed:</b> 29-04-2020</h4><br>
    <h4><b>Company:</b> 1 Platform TV managed by Cotyso Studios</h4>
    <h4><b>Address:</b> 1394 Ashton Old Road Manchester, Greater Manchester, United kingdom</h4>
    <h4><b>Contact Email:</b> oneplatformtv@gmail.com</h4>

    <br><br>
    <ul class="pci-list">
        <li>
            We accept the following credit cards for payment.<br>
            <img class="each_card" src="https://cdn3.iconfinder.com/data/icons/credit-cards-pos/900/visa-512.png" />
            <img class="each_card" src="https://singingexperience.co.uk/_assets/images/site/basket/master-card-icon.png" />
            <img class="each_card" src="https://cdn3.iconfinder.com/data/icons/payment-method/480/maestro_card_payment-512.png" />
            <img class="each_card" src="https://cdn3.iconfinder.com/data/icons/payment-method/480/jcb_card_payment-512.png" />
        </li>
        <li>
            All card processing activities and related technologies comply with the Payment Card Industry Data Security Standard (PCI-DSS) in its entirety. Card processing activities are conducted as described herein and in accordance with the standards and procedures listed in the Related Documents section of this Policy. No activity is conducted nor any technology employed that might obstruct compliance with any portion of the PCI-DSS.
        </li>
        <li>
            This policy is reviewed at least annually and updated as needed to reflect changes to business objectives or the risk environment.
        </li>
        <li>
            All pur employess are subjected to compay with this policy. Relevant sections of this policy apply to vendors, contractors, and business partners. The most current version of this policy is available.
        </li>
        <li>
            Configuration standards are maintained for applications, network components, critical servers, and wireless access points. These standards are consistent with industry-accepted hardening standards as defined, for example, by SysAdmin Assessment Network Security Network (SANS), National Institute of Standards Technology (NIST), and Center for Internet Security (CIS).
        </li>
        <li>
            For our refund policy, click <a href="{{route('faq')}}">here</a>
        </li>
    </ul>
    <h3>Handling of Card Holder Data</h3>
    <ul class="pci-list">
        <li>
            Distribution, maintenance, and storage of media containing cardholder data, is controlled, including that distributed to individuals. Standard procedures followed by each department are as follows
        </li>
        <li>
            It includes legal, regulatory, and business requirements for data retention, including specific requirements for retention of cardholder data
        </li>
        <li>
            It includes provisions for disposal of data when no longer needed for legal, regulatory, or business reasons, including disposal of cardholder data
        </li>
        <li>
            It includes a programmatic (automatic) process to remove, at least on a quarterly basis, stored cardholder data that exceeds business retention requirements, or, alternatively, an audit process, conducted at least on a quarterly basis, to verify that stored cardholder data does not exceed business retention requirements
        </li>
        <li>
            It includes destruction of media when it is no longer needed for business or legal reasons as follows: cross-cut shred, incinerate, or pulp hardcopy materials◦purge, degauss, shred, or otherwise destroy electronic media such that data cannot be reconstructed
        </li>
        <li>
            Credit card numbers is masked when displaying cardholder data. Those with a need to see full credit card numbers must request an exception to this policy using the exception process.
        </li>
        <li>
            Unencrypted Primary Account Numbers are not sent via email
        </li>
        <li>
            The chief securty officer (CSO) or equivalent maintains weekly operational security procedures consistent with this the PCI-DSS, including administrative and technical procedures for each of the requirements
        </li>
        <li>
            CSO (or equivalent) is responsible for overseeing all aspects of information security, including but not limited to :1- creating and distributing security policies and procedures. 2- monitoring and analyzing security alerts and distributing. 3- creating and distributing security incident response and escalation procedures. 4- a process for evolving the incident response plan according to lessons learned and in response to industry developments. 5-  maintaining a formal security awareness program for all employees that providesmultiple methods of communicating awareness and educating employees (for example, posters, letters, meetings). 6- review security logs at least daily and follow-up on exceptions.
        </li>
        <li>
            The Human Resources Office (or equivalent) is responsible for tracking employee participation in the security awareness program, including: 1- facilitating participation upon hire and at least annually. 2- ensuring that employees acknowledge in writing that they have read and understand the company's information security policy. 3- screen potential employees  to minimize the risk of attacks from internal sources.
        </li>
        <li>
            Internal Audit (or equivalent) is responsible for executing a risk assessment process that identifies threats, vulnerabilities, and results in a formal risk assessment.
        </li>
        <li>
            General Counsel (or equivalent) will ensure that for service providers with whom cardholder information is shared: 1- contracts require adherence to PCI-DSS by the service provider. 2- contracts include acknowledgement or responsibility for the security of cardholder data by the service provider
        </li>

    </ul>
</div>
    @stop