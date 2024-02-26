@extends('templates.basic-template')


@section('pagetitle') Terms and Conditions | 1Platform TV @endsection


<!-- Page Level CSS !-->
@section('page-level-css')
    <link rel="stylesheet" href="{{asset('fontawesome/css/all.min.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <style>
        .pg_back { 
            background-image: url(https://www.1platformtvdev.singingexperience.co.uk/images/expert_back_03.jpg);
            content: "";
            position: fixed;
            top: 0;
            left: 0px;
            width: 100%;
            background-size: cover;
            height: calc(100%) !important;
            background-position: top center;
            background-repeat: no-repeat;
        }
        .heading { font-family: 'Montserrat', sans-serif; text-align: center; margin-bottom: 40px; font-size: 23px; background-color: #000; padding: 5px 10px; color: #fff; margin: 26px auto 0 auto; position: relative; width: 85%; }
        .heading .main_tab { color: #ffc107; text-decoration: none; float: left; font-size: 14px; display: flex; align-items: center; justify-content: center; height: 28px; }
        .each_tab { color: #fff; float: right; cursor: pointer; font-size: 12px; background: #333; margin-left: 5px; padding: 4px; display: flex; align-items: center; justify-content: center; height: 28px; }
        .each_sub_head { font-size: 12px; color: #fff; background: #444; padding: 5px; margin-bottom: 10px; }
        .terms_outer { position: relative; width: 85%; margin: 215px auto 0 auto; padding: 40px 85px; font-family: 'Montserrat', sans-serif; background: #000; color: #fff; }
        .terms_outer .head_one { font-size: 33px; line-height: 33px; font-weight: 700; margin-bottom: 45px; }
        .terms_outer .normal { font-weight: normal; font-size: 13px; margin: 0 0 20px; line-height: 23px; text-align: justify; }
        .terms_outer ul.normal { margin: 0 40px 20px 40px; }
        .terms_outer ul.normal li { list-style: disc; }
        .terms_outer .head_two { font-size: 24px; line-height: 24px; margin: 30px 0 30px; padding: 0; }
        .each_head { font-size: 19px; color: #ffc107; margin-bottom: 10px; }
        header { display: none; }

        @media (min-width:320px) and (max-width: 767px) {
            .terms_outer { padding: 70px 20px; }
            .terms_outer ul.normal { margin: 0 20px; }
            .heading { padding: 5px 0;  margin: 90px auto 0 auto; width: 100%; display: flex; justify-content: center; }
            .each_tab { font-size: 10px; }
            .heading .main_tab, .heading .main_text { display: none; }
            .terms_outer .normal { font-size: 12px; }
            .each_head { font-size: 16px; }
        }
    </style>

    @if(Config('constants.primaryDomain') != $_SERVER['SERVER_NAME'])
    <meta name="robots" content="noindex, nofollow" />
    @endif
@stop

<!-- Page Level Javascript !-->
@section('page-level-js')

    <!--  initialize horizontal scroller  !-->
    <script src="/js/horizontal-slider.js" type="application/javascript"></script>
@stop

<!-- Page Header !-->
@section('header')

    
@stop

<!-- facebook/twitter share Login !-->
@section('social-media-html')


@stop


@section('page-content')

    <div class="pg_back active"></div>
    <h2 class="heading">
        <a class="main_tab" href="#">
            <span>
                <i class="fa fa-home"></i>&nbsp;&nbsp;Home
            </span>
        </a>
        <span class="main_text">
            Terms and Conditions  
        </span>
        <a href="{{route('bespoke.license.terms')}}" class="each_tab">Bespoke License</a>
        <a href="{{route('agency.terms')}}" class="each_tab">Agency</a>
        <a href="{{route('disclaimer')}}" class="each_tab">Disclaimer</a>
        <a href="{{route('privacy.policy')}}" class="each_tab">Privacy</a>
        <a href="{{route('cookies.policy')}}" class="each_tab">Cookie</a>
        <a href="{{route('tc')}}" class="each_tab">General</a>
    </h2>
    <div class="terms_outer">
        <p class="normal">Date of Last Revision: ({{date('d/m/Y')}})</p>
        @if($type == 'general')
        <div class="each_head">1- General</div>
        <div class="each_sub_head">1.1 AGREEMENT TO TERMS</div>
        <p class="normal">
            These Terms of Use constitute a legally binding agreement made between you, whether personally or on behalf of an entity (“you”) and 1Platform ("Company", “we”, “us”, or “our”), concerning your access to and use of the https://{{Config('constants.primaryDomain')}}/ website as well as any other media form, media channel, mobile website or mobile application related, linked, or otherwise connected thereto (collectively, the “Site”). You agree that by accessing the Site, you have read, understood, and agreed to be bound by all of these Terms of Use. IF YOU DO NOT AGREE WITH ALL OF THESE TERMS OF USE, THEN YOU ARE EXPRESSLY PROHIBITED FROM USING THE SITE AND YOU MUST DISCONTINUE USE IMMEDIATELY.
        </p>
        <p class="normal">
            Supplemental terms and conditions or documents that may be posted on the site from time to time are hereby expressly incorporated herein by reference. We reserve the right, in our sole discretion, to make changes or modifications to these Terms of Use at any time and for any reason. We will alert you about any changes by updating the “Last updated” date of these Terms of Use, and you waive any right to receive specific notice of each such change. It is your responsibility to periodically review these Terms of Use to stay informed of updates. You will be subject to, and will be deemed to have been made aware of and to have accepted, the changes in any revised Terms of Use by your continued use of the Site after the date such revised Terms of Use are posted.
        </p>
        <p class="normal">
            The information provided on the Site is not intended for distribution to or use by any person or entity in any jurisdiction or country where such distribution or use would be contrary to law or regulation or which would subject us to any registration requirement within such jurisdiction or country. Accordingly, those persons who choose to access the Site from other locations do so on their own initiative and are solely responsible for compliance with local laws, if and to the extent local laws are applicable.
        </p>
        <p class="normal">
            The Site is not tailored to comply with industry-specific regulations (Health Insurance Portability and Accountability Act (HIPAA), Federal Information Security Management Act (FISMA), etc.), so if your interactions would be subjected to such laws, you may not use this Site. You may not use the Site in a way that would violate the Gramm-Leach-Bliley Act (GLBA).
        </p>
        <p class="normal">
            The Site is intended for users who are at least 13 years of age. All users who are minors in the jurisdiction in which they reside (generally under the age of 18) must have the permission of, and be directly supervised by, their parent or guardian to use the Site. If you are a minor, you must have your parent or guardian read and agree to these Terms of Use prior to you using the Site.
        </p>
        <div class="each_sub_head">1.2 INTELLECTUAL PROPERTY RIGHTS</div>
        <p class="normal">
            Unless otherwise indicated, the Site is our proprietary property and all source code, databases, functionality, software, website designs, audio, video, text, photographs, and graphics on the Site (collectively, the “Content”) and the trademarks, service marks, and logos contained therein (the “Marks”) are owned or controlled by us or licensed to us, and are protected by copyright and trademark laws and various other intellectual property rights and unfair competition laws of the United States, international copyright laws, and international conventions. The Content and the Marks are provided on the Site “AS IS” for your information and personal use only. Except as expressly provided in these Terms of Use, no part of the Site and no Content or Marks may be copied, reproduced, aggregated, republished, uploaded, posted, publicly displayed, encoded, translated, transmitted, distributed, sold, licensed, or otherwise exploited for any commercial purpose whatsoever, without our express prior written permission.
        </p>

        <p class="normal">
            Provided that you are eligible to use the Site, you are granted a limited license to access and use the Site and to download or print a copy of any portion of the Content to which you have properly gained access solely for your personal, non-commercial use. We reserve all rights not expressly granted to you in and to the Site, the Content and the Marks.
        </p>
        <div class="each_head">2- User Representations</div>
        <p class="normal">
            By using the Site, you represent and warrant that: (1) all registration information you submit will be true, accurate, current, and complete; (2) you will maintain the accuracy of such information and promptly update such registration information as necessary; (3) you have the legal capacity and you agree to comply with these Terms of Use; (4) you are not under the age of 13; (5) you are not a minor in the jurisdiction in which you reside, or if a minor, you have received parental permission to use the Site; (6) you will not access the Site through automated or non-human means, whether through a bot, script, or otherwise; (7) you will not use the Site for any illegal or unauthorized purpose; and (8) your use of the Site will not violate any applicable law or regulation.
        </p>

        <p class="normal">
            If you provide any information that is untrue, inaccurate, not current, or incomplete, we have the right to suspend or terminate your account and refuse any and all current or future use of the Site (or any portion thereof).
        </p>
        <div class="each_sub_head">2.1 USER REGISTRATION</div>
        <p class="normal">
            You may be required to register with the Site. You agree to keep your password confidential and will be responsible for all use of your account and password. We reserve the right to remove, reclaim, or change a username you select if we determine, in our sole discretion, that such username is inappropriate, obscene, or otherwise objectionable.
        </p>
        <div class="each_sub_head">2.2 Payment</div>
        <p class="normal">
            In regards to paid services provided by 1Platform (Certain services on the platform have a cost) we will advise you of the cost prior to the purchasing of said service. 
        </p>
        <p class="normal">
            1Platform reserves the rights to change the cost of its fees and subscriptions at any moment, providing notice to any users that the updates may effect.
        </p>
        <p class="normal">
            1Platform fees shall be in Great British Pounds (GBP), unless stated otherwise by 1Platform.
        </p>
        <p class="normal">
            All fees are exclusive of all tax which includes value added tax, sales tax, goods and services tax, etc. This includes levies and duties imposed by respective taxing authorities, The user shall be responsible for any and all payments of all applicable taxes/duties related to use of 1Platform. This also includes any third party costs.
        </p>
        <div class="each_sub_head">2.3 Invoices</div>
        <p class="normal">
            1Platform and all affiliates will issue an invoice for any payment, fees and refunds (transactions) made on the website. It will be issued electronically and a copy can also be found in your profile / account. This will be addressed to the details you provided. you may be required to furnish certain Personal Information (defined by our Privacy Policy) in order to comply with local laws. Please note that the Invoice presented in your User Account may not match local law requirements, and in such case may be used for pro forma purposes only. 
        </p>
        <div class="each_sub_head">2.4 Subscription payments</div>
        <p class="normal">
            Due to subscription payments being monthly - we employ recurring Payments to your account. Meaning that on you will be charged at the end of your subscription period for the following period. (Whether this is monthly or yearly)
        </p>
        <p class="normal">
            1Platform can charge the card provided up to 2 weeks before the end of this period. Should we be unable to collect the fees we can (should we choose to) with sole discretion, attempt to recollect the fee.
        </p>
        <p class="normal">
            In the event of failure to pay for the subscription will result in suspension of the services provided.
        </p>
        <p class="normal">
            By entering an agreement for 1Platform for a subscription, you acknowledge that you agree for a recurring payment to take place and all subsequent conditions.
        </p>
        <div class="each_sub_head">2.5 Prohibited Activities</div>
        <p class="normal">
            You may not access or use the Site for any purpose other than that for which we make the Site available. The Site may not be used in connection with any commercial endeavors except those that are specifically endorsed or approved by us.
        </p>
        <p class="normal">
            As a user of the Site, you agree not to:
        </p>
        <ul class="normal">
            <li>
                Systematically retrieve data or other content from the Site to create or compile, directly or indirectly, a collection, compilation, database, or directory without written permission from us.
            </li>
            <li>
                Trick, defraud, or mislead us and other users, especially in any attempt to learn sensitive account information such as user passwords.
            </li>
            <li>
                Circumvent, disable, or otherwise interfere with security-related features of the Site, including features that prevent or restrict the use or copying of any Content or enforce limitations on the use of the Site and/or the Content contained therein.
            </li>
            <li>
                Disparage, tarnish, or otherwise harm, in our opinion, us and/or the Site.
            </li>
            <li>
                Use any information obtained from the Site in order to harass, abuse, or harm another person.
            </li>
            <li>
                Make improper use of our support services or submit false reports of abuse or misconduct.
            </li>
            <li>
                Use the Site in a manner inconsistent with any applicable laws or regulations.
            </li>
            <li>
                Upload or transmit (or attempt to upload or to transmit) viruses, Trojan horses, or other material, including excessive use of capital letters and spamming (continuous posting of repetitive text), that interferes with any party’s uninterrupted use and enjoyment of the Site or modifies, impairs, disrupts, alters, or interferes with the use, features, functions, operation, or maintenance of the Site.
            </li>
            <li>
                Engage in any automated use of the system, such as using scripts to send comments or messages, or using any data mining, robots, or similar data gathering and extraction tools.
            </li>
            <li>
                Delete the copyright or other proprietary rights notice from any Content.
            </li>
            <li>
                Attempt to impersonate another user or person or use the username of another user.
            </li>
            <li>
                Sell or otherwise transfer your profile.
            </li>
            <li>
                Upload or transmit (or attempt to upload or to transmit) any material that acts as a passive or active information collection or transmission mechanism, including without limitation, clear graphics interchange formats (“gifs”), 1×1 pixels, web bugs, cookies, or other similar devices (sometimes referred to as “spyware” or “passive collection mechanisms” or “pcms”).
            </li>
            <li>
                Interfere with, disrupt, or create an undue burden on the Site or the networks or services connected to the Site.
            </li>
            <li>
                Harass, annoy, intimidate, or threaten any of our employees or agents engaged in providing any portion of the Site to you.
            </li>
            <li>
                Attempt to bypass any measures of the Site designed to prevent or restrict access to the Site, or any portion of the Site.
            </li>
            <li>
                Copy or adapt the Site’s software, including but not limited to Flash, PHP, HTML, JavaScript, or other code.
            </li>
            <li>
                Decipher, decompile, disassemble, or reverse engineer any of the software comprising or in any way making up a part of the Site.
            </li>
            <li>
                Except as may be the result of standard search engine or Internet browser usage, use, launch, develop, or distribute any automated system, including without limitation, any spider, robot, cheat utility, scraper, or offline reader that accesses the Site, or using or launching any unauthorized script or other software.
            </li>
            <li>
                Use a buying agent or purchasing agent to make purchases on the Site.
            </li>
            <li>
                Make any unauthorized use of the Site, including collecting usernames and/or email addresses of users by electronic or other means for the purpose of sending unsolicited email, or creating user accounts by automated means or under false pretenses.
            </li>
            <li>
                Use the Site as part of any effort to compete with us or otherwise use the Site and/or the Content for any revenue-generating endeavor or commercial enterprise.
            </li>
            <li>
                Sell Illegal or otherwise prohibited items on the site. These are items that either go against our terms or are tracks that violate any law or regulation.
            </li>
        </ul>
        <div class="each_head">3- User Generated Contributions</div>
        <p class="normal">
            The Site may invite you to chat, contribute to, or participate in blogs, message boards, online forums, and other functionality, and may provide you with the opportunity to create, submit, post, display, transmit, perform, publish, distribute, or broadcast content and materials to us or on the Site, including but not limited to text, writings, video, audio, photographs, graphics, comments, suggestions, or personal information or other material (collectively, "Contributions"). Contributions may be viewable by other users of the Site and through third-party websites. As such, any Contributions you transmit may be treated as non-confidential and non-proprietary. When you create or make available any Contributions, you thereby represent and warrant that:
        </p>
        <ul class="normal">
            <li>
                The creation, distribution, transmission, public display, or performance, and the accessing, downloading, or copying of your Contributions do not and will not infringe the proprietary rights, including but not limited to the copyright, patent, trademark, trade secret, or moral rights of any third party.
            </li>
            <li>
                You are the creator and owner of or have the necessary licenses, rights, consents, releases, and permissions to use and to authorize us, the Site, and other users of the Site to use your Contributions in any manner contemplated by the Site and these Terms of Use.
            </li>
            <li>
                You have the written consent, release, and/or permission of each and every identifiable individual person in your Contributions to use the name or likeness of each and every such identifiable individual person to enable inclusion and use of your Contributions in any manner contemplated by the Site and these Terms of Use.
            </li>
            <li>
                Your Contributions are not false, inaccurate, or misleading.
            </li>
            <li>
                Your Contributions are not unsolicited or unauthorized advertising, promotional materials, pyramid schemes, chain letters, spam, mass mailings, or other forms of solicitation.
            </li>
            <li>
                Your Contributions are not obscene, lewd, lascivious, filthy, violent, harassing, libelous, slanderous, or otherwise objectionable (as determined by us).
            </li>
            <li>
                Your Contributions do not ridicule, mock, disparage, intimidate, or abuse anyone.
            </li>
            <li>
                Your Contributions do not advocate the violent overthrow of any government or incite, encourage, or threaten physical harm against another.
            </li>
            <li>
                Your Contributions do not violate any applicable law, regulation, or rule.
            </li>
            <li>
                Your Contributions do not violate the privacy or publicity rights of any third party.
            </li>
            <li>
                Your Contributions do not contain any material that solicits personal information from anyone under the age of 18 or exploits people under the age of 18 in a sexual or violent manner.
            </li>
            <li>
                Your Contributions do not violate any applicable law concerning child pornography, or otherwise intended to protect the health or well-being of minors.
            </li>
            <li>
                Your Contributions do not include any offensive comments that are connected to race, national origin, gender, sexual preference, or physical handicap.
            </li>
            <li>
                Your Contributions do not otherwise violate, or link to material that violates, any provision of these Terms of Use, or any applicable law or regulation.
            </li>
        </ul>
        <p class="normal">
            Any use of the Site in violation of the foregoing violates these Terms of Use and may result in, among other things, termination or suspension of your rights to use the Site.
        </p>
        <div class="each_sub_head">3.1 Contribution License</div>
        <p class="normal">
            By posting your Contributions to any part of the Site or making Contributions accessible to the Site by linking your account from the Site to any of your social networking accounts, you automatically grant, and you represent and warrant that you have the right to grant, to us an unrestricted, unlimited, irrevocable, perpetual, non-exclusive, transferable, royalty-free, fully-paid, worldwide right, and license to host, use, copy, reproduce, disclose, sell, resell, publish, broadcast, retitle, archive, store, cache, publicly perform, publicly display, reformat, translate, transmit, excerpt (in whole or in part), and distribute such Contributions (including, without limitation, your image and voice) for any purpose, commercial, advertising, or otherwise, and to prepare derivative works of, or incorporate into other works, such Contributions, and grant and authorize sublicenses of the foregoing. The use and distribution may occur in any media formats and through any media channels.
        </p>
        <p class="normal">
            This license will apply to any form, media, or technology now known or hereafter developed, and includes our use of your name, company name, and franchise name, as applicable, and any of the trademarks, service marks, trade names, logos, and personal and commercial images you provide. You waive all moral rights in your Contributions, and you warrant that moral rights have not otherwise been asserted in your Contributions.
        </p>
        <p class="normal">
            We do not assert any ownership over your Contributions. You retain full ownership of all of your Contributions and any intellectual property rights or other proprietary rights associated with your Contributions. We are not liable for any statements or representations in your Contributions provided by you in any area on the Site. You are solely responsible for your Contributions to the Site and you expressly agree to exonerate us from any and all responsibility and to refrain from any legal action against us regarding your Contributions.
        </p>
        <p class="normal">
            We have the right, in our sole and absolute discretion, (1) to edit, redact, or otherwise change any Contributions; (2) to re-categorize any Contributions to place them in more appropriate locations on the Site; and (3) to pre-screen or delete any Contributions at any time and for any reason, without notice. We have no obligation to monitor your Contributions.
        </p>
        <div class="each_head">4- Guidelines for Reviews</div>
        <p class="normal">
            We may provide you areas on the Site to leave reviews or ratings. When posting a review, you must comply with the following criteria: (1) you should have firsthand experience with the person/entity being reviewed; (2) your reviews should not contain offensive profanity, or abusive, racist, offensive, or hate language; (3) your reviews should not contain discriminatory references based on religion, race, gender, national origin, age, marital status, sexual orientation, or disability; (4) your reviews should not contain references to illegal activity; (5) you should not be affiliated with competitors if posting negative reviews; (6) you should not make any conclusions as to the legality of conduct; (7) you may not post any false or misleading statements; and (8) you may not organize a campaign encouraging others to post reviews, whether positive or negative.
        </p>
        <p class="normal">
            We may accept, reject, or remove reviews in our sole discretion. We have absolutely no obligation to screen reviews or to delete reviews, even if anyone considers reviews objectionable or inaccurate. Reviews are not endorsed by us, and do not necessarily represent our opinions or the views of any of our affiliates or partners. We do not assume liability for any review or for any claims, liabilities, or losses resulting from any review. By posting a review, you hereby grant to us a perpetual, non-exclusive, worldwide, royalty-free, fully-paid, assignable, and sublicensable right and license to reproduce, modify, translate, transmit by any means, display, perform, and/or distribute all content relating to reviews.
        </p>
        <div class="each_head">5- Mobile Application License</div>
        <div class="each_sub_head">5.1 Use License</div>
        <p class="normal">
            If you access the Site via a mobile application, then we grant you a revocable, non-exclusive, non-transferable, limited right to install and use the mobile application on wireless electronic devices owned or controlled by you, and to access and use the mobile application on such devices strictly in accordance with the terms and conditions of this mobile application license contained in these Terms of Use. You shall not: (1) decompile, reverse engineer, disassemble, attempt to derive the source code of, or decrypt the application; (2) make any modification, adaptation, improvement, enhancement, translation, or derivative work from the application; (3) violate any applicable laws, rules, or regulations in connection with your access or use of the application; (4) remove, alter, or obscure any proprietary notice (including any notice of copyright or trademark) posted by us or the licensors of the application; (5) use the application for any revenue generating endeavor, commercial enterprise, or other purpose for which it is not designed or intended; (6) make the application available over a network or other environment permitting access or use by multiple devices or users at the same time; (7) use the application for creating a product, service, or software that is, directly or indirectly, competitive with or in any way a substitute for the application; (8) use the application to send automated queries to any website or to send any unsolicited commercial e-mail; or (9) use any proprietary information or any of our interfaces or our other intellectual property in the design, development, manufacture, licensing, or distribution of any applications, accessories, or devices for use with the application.
        </p>
        <div class="each_sub_head">5.2 Apple and Android Devices</div>
        <p class="normal">
            The following terms apply when you use a mobile application obtained from either the Apple Store or Google Play (each an “App Distributor”) to access the Site: (1) the license granted to you for our mobile application is limited to a non-transferable license to use the application on a device that utilizes the Apple iOS or Android operating systems, as applicable, and in accordance with the usage rules set forth in the applicable App Distributor’s terms of service; (2) we are responsible for providing any maintenance and support services with respect to the mobile application as specified in the terms and conditions of this mobile application license contained in these Terms of Use or as otherwise required under applicable law, and you acknowledge that each App Distributor has no obligation whatsoever to furnish any maintenance and support services with respect to the mobile application; (3) in the event of any failure of the mobile application to conform to any applicable warranty, you may notify the applicable App Distributor, and the App Distributor, in accordance with its terms and policies, may refund the purchase price, if any, paid for the mobile application, and to the maximum extent permitted by applicable law, the App Distributor will have no other warranty obligation whatsoever with respect to the mobile application; (4) you represent and warrant that (i) you are not located in a country that is subject to a U.S. government embargo, or that has been designated by the U.S. government as a “terrorist supporting” country and (ii) you are not listed on any U.S. government list of prohibited or restricted parties; (5) you must comply with applicable third-party terms of agreement when using the mobile application, e.g., if you have a VoIP application, then you must not be in violation of their wireless data service agreement when using the mobile application; and (6) you acknowledge and agree that the App Distributors are third-party beneficiaries of the terms and conditions in this mobile application license contained in these Terms of Use, and that each App Distributor will have the right (and will be deemed to have accepted the right) to enforce the terms and conditions in this mobile application license contained in these Terms of Use against you as a third-party beneficiary thereof.
        </p>
        <div class="each_head">6- Social Media</div>
        <p class="normal">
            As part of the functionality of the Site, you may link your account with online accounts you have with third-party service providers (each such account, a “Third-Party Account”) by either: (1) providing your Third-Party Account login information through the Site; or (2) allowing us to access your Third-Party Account, as is permitted under the applicable terms and conditions that govern your use of each Third-Party Account. You represent and warrant that you are entitled to disclose your Third-Party Account login information to us and/or grant us access to your Third-Party Account, without breach by you of any of the terms and conditions that govern your use of the applicable Third-Party Account, and without obligating us to pay any fees or making us subject to any usage limitations imposed by the third-party service provider of the Third-Party Account. By granting us access to any Third-Party Accounts, you understand that (1) we may access, make available, and store (if applicable) any content that you have provided to and stored in your Third-Party Account (the “Social Network Content”) so that it is available on and through the Site via your account, including without limitation any friend lists and (2) we may submit to and receive from your Third-Party Account additional information to the extent you are notified when you link your account with the Third-Party Account. Depending on the Third-Party Accounts you choose and subject to the privacy settings that you have set in such Third-Party Accounts, personally identifiable information that you post to your Third-Party Accounts may be available on and through your account on the Site. Please note that if a Third-Party Account or associated service becomes unavailable or our access to such Third Party Account is terminated by the third-party service provider, then Social Network Content may no longer be available on and through the Site. You will have the ability to disable the connection between your account on the Site and your Third-Party Accounts at any time. PLEASE NOTE THAT YOUR RELATIONSHIP WITH THE THIRD-PARTY SERVICE PROVIDERS ASSOCIATED WITH YOUR THIRD-PARTY ACCOUNTS IS GOVERNED SOLELY BY YOUR AGREEMENT(S) WITH SUCH THIRD-PARTY SERVICE PROVIDERS. We make no effort to review any Social Network Content for any purpose, including but not limited to, for accuracy, legality, or non-infringement, and we are not responsible for any Social Network Content. You acknowledge and agree that we may access your email address book associated with a Third-Party Account and your contacts list stored on your mobile device or tablet computer solely for purposes of identifying and informing you of those contacts who have also registered to use the Site. You can deactivate the connection between the Site and your Third-Party Account by contacting us using the contact information below or through your account settings (if applicable). We will attempt to delete any information stored on our servers that was obtained through such Third-Party Account, except the username and profile picture that become associated with your account.
        </p>
        <div class="each_head">7- Submissions</div>
        <p class="normal">
            You acknowledge and agree that any questions, comments, suggestions, ideas, feedback, or other information regarding the Site ("Submissions") provided by you to us are non-confidential and shall become our sole property. We shall own exclusive rights, including all intellectual property rights, and shall be entitled to the unrestricted use and dissemination of these Submissions for any lawful purpose, commercial or otherwise, without acknowledgment or compensation to you. You hereby waive all moral rights to any such Submissions, and you hereby warrant that any such Submissions are original with you or that you have the right to submit such Submissions. You agree there shall be no recourse against us for any alleged or actual infringement or misappropriation of any proprietary right in your Submissions.
        </p>
        <div class="each_head">8- Third Party Content and Website</div>
        <p class="normal">
            The Site may contain (or you may be sent via the Site) links to other websites ("Third-Party Websites") as well as articles, photographs, text, graphics, pictures, designs, music, sound, video, information, applications, software, and other content or items belonging to or originating from third parties ("Third-Party Content"). Such Third-Party Websites and Third-Party Content are not investigated, monitored, or checked for accuracy, appropriateness, or completeness by us, and we are not responsible for any Third-Party Websites accessed through the Site or any Third-Party Content posted on, available through, or installed from the Site, including the content, accuracy, offensiveness, opinions, reliability, privacy practices, or other policies of or contained in the Third-Party Websites or the Third-Party Content. Inclusion of, linking to, or permitting the use or installation of any Third-Party Websites or any Third-Party Content does not imply approval or endorsement thereof by us. If you decide to leave the Site and access the Third-Party Websites or to use or install any Third-Party Content, you do so at your own risk, and you should be aware these Terms of Use no longer govern. You should review the applicable terms and policies, including privacy and data gathering practices, of any website to which you navigate from the Site or relating to any applications you use or install from the Site. Any purchases you make through Third-Party Websites will be through other websites and from other companies, and we take no responsibility whatsoever in relation to such purchases which are exclusively between you and the applicable third party. You agree and acknowledge that we do not endorse the products or services offered on Third-Party Websites and you shall hold us harmless from any harm caused by your purchase of such products or services. Additionally, you shall hold us harmless from any losses sustained by you or harm caused to you relating to or resulting in any way from any Third-Party Content or any contact with Third-Party Websites.
        </p>
        <div class="each_head">9- Advertisers</div>
        <p class="normal">
            We allow advertisers to display their advertisements and other information in certain areas of the Site, such as sidebar advertisements or banner advertisements. If you are an advertiser, you shall take full responsibility for any advertisements you place on the Site and any services provided on the Site or products sold through those advertisements. Further, as an advertiser, you warrant and represent that you possess all rights and authority to place advertisements on the Site, including, but not limited to, intellectual property rights, publicity rights, and contractual rights. We simply provide the space to place such advertisements, and we have no other relationship with advertisers.
        </p>
        <div class="each_head">10- Site Management</div>
        <p class="normal">
            We reserve the right, but not the obligation, to: (1) monitor the Site for violations of these Terms of Use; (2) take appropriate legal action against anyone who, in our sole discretion, violates the law or these Terms of Use, including without limitation, reporting such user to law enforcement authorities; (3) in our sole discretion and without limitation, refuse, restrict access to, limit the availability of, or disable (to the extent technologically feasible) any of your Contributions or any portion thereof; (4) in our sole discretion and without limitation, notice, or liability, to remove from the Site or otherwise disable all files and content that are excessive in size or are in any way burdensome to our systems; and (5) otherwise manage the Site in a manner designed to protect our rights and property and to facilitate the proper functioning of the Site.
        </p>
        <div class="each_head">12- Copyright Infringements</div>
        <p class="normal">
            We respect the intellectual property rights of others. If you believe that any material available on or through the Site infringes upon any copyright you own or control, please immediately notify us using the contact information provided below (a “Notification”). A copy of your Notification will be sent to the person who posted or stored the material addressed in the Notification. Please be advised that pursuant to applicable law you may be held liable for damages if you make material misrepresentations in a Notification. Thus, if you are not sure that material located on or linked to by the Site infringes your copyright, you should consider first contacting an attorney.
        </p>
        <div class="each_head">13- Term and Termination</div>
        <p class="normal">
            These Terms of Use shall remain in full force and effect while you use the Site. WITHOUT LIMITING ANY OTHER PROVISION OF THESE TERMS OF USE, WE RESERVE THE RIGHT TO, IN OUR SOLE DISCRETION AND WITHOUT NOTICE OR LIABILITY, DENY ACCESS TO AND USE OF THE SITE (INCLUDING BLOCKING CERTAIN IP ADDRESSES), TO ANY PERSON FOR ANY REASON OR FOR NO REASON, INCLUDING WITHOUT LIMITATION FOR BREACH OF ANY REPRESENTATION, WARRANTY, OR COVENANT CONTAINED IN THESE TERMS OF USE OR OF ANY APPLICABLE LAW OR REGULATION. WE MAY TERMINATE YOUR USE OR PARTICIPATION IN THE SITE OR DELETE YOUR ACCOUNT AND ANY CONTENT OR INFORMATION THAT YOU POSTED AT ANY TIME, WITHOUT WARNING, IN OUR SOLE DISCRETION.
        </p>
        <p class="normal">
            If we terminate or suspend your account for any reason, you are prohibited from registering and creating a new account under your name, a fake or borrowed name, or the name of any third party, even if you may be acting on behalf of the third party. In addition to terminating or suspending your account, we reserve the right to take appropriate legal action, including without limitation pursuing civil, criminal, and injunctive redress.
        </p>
        <div class="each_head">14- Modifications and Interuptions</div>
        <p class="normal">
            We reserve the right to change, modify, or remove the contents of the Site at any time or for any reason at our sole discretion without notice. However, we have no obligation to update any information on our Site. We also reserve the right to modify or discontinue all or part of the Site without notice at any time. We will not be liable to you or any third party for any modification, price change, suspension, or discontinuance of the Site.
        </p>
        <p class="normal">
            We cannot guarantee the Site will be available at all times. We may experience hardware, software, or other problems or need to perform maintenance related to the Site, resulting in interruptions, delays, or errors. We reserve the right to change, revise, update, suspend, discontinue, or otherwise modify the Site at any time or for any reason without notice to you. You agree that we have no liability whatsoever for any loss, damage, or inconvenience caused by your inability to access or use the Site during any downtime or discontinuance of the Site. Nothing in these Terms of Use will be construed to obligate us to maintain and support the Site or to supply any corrections, updates, or releases in connection therewith.
        </p>
        <div class="each_head">15- Governing Law</div>
        <p class="normal">
            These conditions are governed by and interpreted following the laws of the United Kingdom, and the use of the United Nations Convention of Contracts for the International Sale of Goods is expressly excluded. If your habitual residence is in the EU, and you are a consumer, you additionally possess the protection provided to you by obligatory provisions of the law of your country of residence. 1Platform and yourself both agree to submit to the non-exclusive jurisdiction of the courts of Manchester, which means that you may make a claim to defend your consumer protection rights in regards to these Conditions of Use in the United Kingdom, or in the EU country in which you reside.
        </p>
        <div class="each_head">16- Dispute Resolution</div>
        <div class="each_sub_head">16.1 Informal Negotiations</div>
        <p class="normal">
            To expedite resolution and control the cost of any dispute, controversy, or claim related to these Terms of Use (each a "Dispute" and collectively, the “Disputes”) brought by either you or us (individually, a “Party” and collectively, the “Parties”), the Parties agree to first attempt to negotiate any Dispute (except those Disputes expressly provided below) informally for at least fifteen (15) days before initiating arbitration. Such informal negotiations commence upon written notice from one Party to the other Party.
        </p>
        <div class="each_sub_head">16.2 Binding Arbitration</div>
        <p class="normal">
            Any dispute arising from the relationships between the Parties to this contract shall be determined by one arbitrator who will be chosen in accordance with the Arbitration and Internal Rules of the European Court of Arbitration being part of the European Centre of Arbitration having its seat in Strasbourg, and which are in force at the time the application for arbitration is filed, and of which adoption of this clause constitutes acceptance. The seat of arbitration shall be Manchester, United Kingdom. The language of the proceedings shall be English. Applicable rules of substantive law shall be the law of the United Kingdom.
        </p>
        <div class="each_sub_head">16.3 Restrictions</div>
        <p class="normal">
            The Parties agree that any arbitration shall be limited to the Dispute between the Parties individually. To the full extent permitted by law, (a) no arbitration shall be joined with any other proceeding; (b) there is no right or authority for any Dispute to be arbitrated on a class-action basis or to utilize class action procedures; and (c) there is no right or authority for any Dispute to be brought in a purported representative capacity on behalf of the general public or any other persons.
        </p>
        <div class="each_sub_head">16.4 Exceptions to Informal Negotiations and Arbitration</div>
        <p class="normal">
            The Parties agree that the following Disputes are not subject to the above provisions concerning informal negotiations and binding arbitration: (a) any Disputes seeking to enforce or protect, or concerning the validity of, any of the intellectual property rights of a Party; (b) any Dispute related to, or arising from, allegations of theft, piracy, invasion of privacy, or unauthorized use; and (c) any claim for injunctive relief. If this provision is found to be illegal or unenforceable, then neither Party will elect to arbitrate any Dispute falling within that portion of this provision found to be illegal or unenforceable and such Dispute shall be decided by a court of competent jurisdiction within the courts listed for jurisdiction above, and the Parties agree to submit to the personal jurisdiction of that court.
        </p>
        <div class="each_sub_head">16.5 Corrections</div>
        <p class="normal">
            There may be information on the Site that contains typographical errors, inaccuracies, or omissions, including descriptions, pricing, availability, and various other information. We reserve the right to correct any errors, inaccuracies, or omissions and to change or update the information on the Site at any time, without prior notice.
        </p>
        <div class="each_head">18- Limitations of Liability</div>
        <p class="normal">
            In no event will we or our directors, employees, or agents be liable to you or any third party for any direct, indirect, consequential, exemplary, incidental, special, or punitive damages, including lost profit, lost revenue, loss of data, or other damages arising from your use of the site, even if we have been advised of the possibility of such damages. Notwithstanding anything to the contrary contained herein, our liability to you for any cause whatsoever and regardless of the form of the action, will at all times be limited to the lesser of the amount paid, if any, by you to us during the one (1) month period prior to any cause of action arising or £500.00 gbp. Certain international laws do not allow limitations on implied warranties or the exclusion or limitation of certain damages. If these laws apply to you, some or all of the above disclaimers or limitations may not apply to you, and you may have additional rights.
        </p>
        <div class="each_head">19- Indemnification</div>
        <p class="normal">
            You agree to defend, indemnify, and hold us harmless, including our subsidiaries, affiliates, and all of our respective officers, agents, partners, and employees, from and against any loss, damage, liability, claim, or demand, including reasonable attorneys’ fees and expenses, made by any third party due to or arising out of: (1) your Contributions; (2) use of the Site; (3) breach of these Terms of Use; (4) any breach of your representations and warranties set forth in these Terms of Use; (5) your violation of the rights of a third party, including but not limited to intellectual property rights; or (6) any overt harmful act toward any other user of the Site with whom you connected via the Site. Notwithstanding the foregoing, we reserve the right, at your expense, to assume the exclusive defense and control of any matter for which you are required to indemnify us, and you agree to cooperate, at your expense, with our defense of such claims. We will use reasonable efforts to notify you of any such claim, action, or proceeding which is subject to this indemnification upon becoming aware of it.
        </p>
        <div class="each_head">20- User Data</div>
        <p class="normal">
            We will maintain certain data that you transmit to the Site for the purpose of managing the performance of the Site, as well as data relating to your use of the Site. Although we perform regular routine backups of data, you are solely responsible for all data that you transmit or that relates to any activity you have undertaken using the Site. You agree that we shall have no liability to you for any loss or corruption of any such data, and you hereby waive any right of action against us arising from any such loss or corruption of such data.
        </p>
        <div class="each_head">21- Electronic Communications, Transactions and Signatures</div>
        <p class="normal">
            Visiting the Site, sending us emails, and completing online forms constitute electronic communications. You consent to receive electronic communications, and you agree that all agreements, notices, disclosures, and other communications we provide to you electronically, via email and on the Site, satisfy any legal requirement that such communication be in writing. YOU HEREBY AGREE TO THE USE OF ELECTRONIC SIGNATURES, CONTRACTS, ORDERS, AND OTHER RECORDS, AND TO ELECTRONIC DELIVERY OF NOTICES, POLICIES, AND RECORDS OF TRANSACTIONS INITIATED OR COMPLETED BY US OR VIA THE SITE. You hereby waive any rights or requirements under any statutes, regulations, rules, ordinances, or other laws in any jurisdiction which require an original signature or delivery or retention of non-electronic records, or to payments or the granting of credits by any means other than electronic means.
        </p>
        <div class="each_head">22- Miscellaneous</div>
        <p class="normal">
            These Terms of Use and any policies or operating rules posted by us on the Site or in respect to the Site constitute the entire agreement and understanding between you and us. Our failure to exercise or enforce any right or provision of these Terms of Use shall not operate as a waiver of such right or provision. These Terms of Use operate to the fullest extent permissible by law. We may assign any or all of our rights and obligations to others at any time. We shall not be responsible or liable for any loss, damage, delay, or failure to act caused by any cause beyond our reasonable control. If any provision or part of a provision of these Terms of Use is determined to be unlawful, void, or unenforceable, that provision or part of the provision is deemed severable from these Terms of Use and does not affect the validity and enforceability of any remaining provisions. There is no joint venture, partnership, employment or agency relationship created between you and us as a result of these Terms of Use or use of the Site. You agree that these Terms of Use will not be construed against us by virtue of having drafted them. You hereby waive any and all defenses you may have based on the electronic form of these Terms of Use and the lack of signing by the parties hereto to execute these Terms of Use.
        </p>
        <div class="each_head">23- Online Store</div>
        <p class="normal">
            The Site and Services are provided on an as-is and as-available basis. You agree that your use of the Site and/or Services will be at your sole risk except as expressly set out in these Terms and Conditions. All warranties, terms, conditions and undertakings, express or implied (including by statute, custom or usage, a course of dealing, or common law) in connection with the Site and Services and your use thereof including, without limitation, the implied warranties of satisfactory quality, fitness for a particular purpose and non-infringement are excluded to the fullest extent permitted by applicable law.
        </p>
        <div class="each_sub_head">23.1 Our Responsiblity For Loss or Damage Suffered by You</div>
        <p class="normal">
            Whether you are a consumer or a business user:
        </p>
        <ul class="normal">
            <li>
                We do not exclude or limit in any way our liability to you where it would be unlawful to do so. This includes liability for death or personal injury caused by our negligence or the negligence of our employees, agents or subcontractors and for fraud or fraudulent misrepresentation.
            </li>
            <li>
                If we fail to comply with these Terms and Conditions, we will be responsible for loss or damage you suffer that is a foreseeable result of our breach of these Terms and Conditions, but we would not be responsible for any loss or damage that were not foreseeable at the time you started using the Site/Services.
            </li>
        </ul>
        <p class="normal">
            Notwithstanding anything to the contrary contained in the Disclaimer/Limitation of Liability section, our liability to you for any cause whatsoever and regardless of the form of the action, will at all times be limited to a total aggregate amount equal to the greater of (a) the sum of £5000 or (b) the amount paid, if any, by you to us for the Services/Site during the six (6) month period prior to any cause of action arising. Different limitations and exclusions of liability will apply to liability arising as a result of the supply of any products to you.
        </p>
        <p class="normal">
            If you are a business user, we will not be liable to you for any loss or damage, whether in contract, tort (including negligence), breach of statutory duty, or otherwise, even if foreseeable, arising under or in connection with:: 
        </p>
        <ul class="normal">
            <li>
                Use of, or inability to use, our Site/Services; or
            </li>
            <li>
                Use of or reliance on any content displayed on our Site
            </li>
        </ul>
        <p class="normal">
            In particular, we will not be liable for: 
        </p>
        <ul class="normal">
            <li>
                Loss of profits, sales, business, or revenue;
            </li>
            <li>
                Business interruption;
            </li>
            <li>
                Loss of anticipated savings;  
            </li>
            <li>
                Loss of business opportunity, goodwill or reputation; or
            </li>
            <li>
                Any indirect or consequential loss or damage
            </li>
        </ul>
        <p class="normal">
            If you are a consumer user:
        </p>
        <ul class="normal">
            <li>
                Please note that we only provide our Site for domestic and private use. You agree not to use our Site for any commercial or business purposes, and we have no liability to you for any loss of profit, loss of business, business interruption, or loss of business opportunity.
            </li>
            <li>
                If defective digital content that we have supplied, damages a device or digital content belonging to you and this is caused by our failure to use reasonable care and skill, we will either repair the damage or pay you compensation.
            </li>
            <li>
                You have legal rights in relation to goods that are faulty or not as described. Advice about your legal rights is available from your local Citizens' Advice Bureau or Trading Standards office. Nothing in these Terms and Conditions will affect these legal rights.
            </li>
        </ul>
        <div class="each_sub_head">23.2 1Platform Will Take a Fee From Each Transaction Made Through Online Store</div>
        <div class="each_sub_head">23.3 Refunds</div>
        <p class="normal">
            1Platform is not associated or partnered with the users and / or sellers on the site as such if you need a refund or change to your order you will need to contact the owner of the store ( the seller ) directly
        </p>
        <div class="each_head">24- Crowdfunding</div>
        <p class="normal">
            When you support a Crowdfunding campaign you are not charged immediately - the charge will be saved for the date the crowdfunder ends. If the fundraiser is successful you will be charged, if not you will only be charged if it is a charity/flexible campaign.
        </p>
        <p class="normal">
            Delivery is estimated by the creator and will be handled by the creator. 1Platform is not responsible for shipping, cost or delivery.
        </p>
        <p class="normal">
            Information such as email, contact and delivery address will need to be passed on to the creator so they can handle your order. By supporting a crowdfunder you agree this information can be passed on to the campaign creator.
        </p>
        <p class="normal">
            Platform does not provide refunds, responsibility for projects lies solely with the project organiser.
        </p>
        <p class="normal">
            Platform will charge fees before depositing the funds into the account - Funds cannot always be delivered immediately or certain charges may take time to process so the full amount cannot always be sent immediately. Please be patient and do not assume funds will be transferred the moment the project ends.
        </p>
        <p class="normal">
            Project creators can refund certain backers if they choose to - this will close any agreement between both parties. Should a project backer wish to change there order or have it refunded they can contact the crowdfunder creator through 1Platform.
        </p>
        <p class="normal">
            1Platform is not responsible for any project or liable for any damages or losses from the use of our service - we do not oversee campaigns and what they deliver. By using 1Platform you release us from any claims, damages, and demands of every kind—known or unknown, suspected or unsuspected, disclosed or undisclosed. Content accessed through the site is at your own risk and you are responsible for yourself on the site and any damages or losses incurred as a result.
        </p>
        <p class="normal">
            1Platform reserves the right to stop any projects as it see fit.
        </p>
        <p class="normal">
            1Platform does not provide advice (legal, financial or otherwise to any users).
        </p>
        <p class="normal">
            1Platform will take a fee from every crowdfunder successfully raised
         </p>
        <div class="each_head">25- Payment Processing</div>
        <p class="normal">
            Payment on 1Platform is processed by Stripe - by using 1Platform you also agree to the terms and conditions of Stripe regardless of where it is used - including but not limited to - Users online stores - users crowdfunders and receiving payments.
        </p>
        <div class="each_head">26- Accounts</div>
        <p class="normal">
            You may change your account to a free account if you choose to, but accounts cannot be deleted as 1Platform needs to retain certain information as is required for any agreements or content submitted during your time on the platform shall remain in place.
        </p> 
        @endif
        @if($type == 'disclaimer')
        <div class="each_head">17- Disclaimer</div> 
        <p class="normal">
            The site is provided on an as-is and as-available basis. You agree that your use of the site and our services will be at your sole risk. To the fullest extent permitted by law, we disclaim all warranties, express or implied, in connection with the site and your use thereof, including, without limitation, the implied warranties of merchantability, fitness for a particular purpose, and non-infringement. We make no warranties or representations about the accuracy or completeness of the site’s content or the content of any websites linked to the site and we will assume no liability or responsibility for any (1) errors, mistakes, or inaccuracies of content and materials, (2) personal injury or property damage, of any nature whatsoever, resulting from your access to and use of the site, (3) any unauthorized access to or use of our secure servers and/or any and all personal information and/or financial information stored therein, (4) any interruption or cessation of transmission to or from the site, (5) any bugs, viruses, trojan horses, or the like which may be transmitted to or through the site by any third party, and/or (6) any errors or omissions in any content and materials or for any loss or damage of any kind incurred as a result of the use of any content posted, transmitted, or otherwise made available via the site. We do not warrant, endorse, guarantee, or assume responsibility for any product or service advertised or offered by a third party through the site, any hyperlinked website, or any website or mobile application featured in any banner or other advertising, and we will not be a party to or in any way be responsible for monitoring any transaction between you and any third-party providers of products or services. As with the purchase of a product or service through any medium or in any environment, you should use your best judgment and exercise caution where appropriate.
        </p>
        <div class="each_sub_head">17.1 Website disclaimer</div>
        <p class="normal">
            The information provided by 1Platform (“we,” “us” or “our”) on https://{{Config('constants.primaryDomain')}}/ (the “site”) and our mobile application is for general informational purposes only. All information on the site and our mobile application is provided in good faith, however we make no representation or warranty of any kind, express or implied, regarding the accuracy, adequacy, validity, reliability, availability or completeness of any information on the site or our mobile application. Under no circumstance shall we have any liability to you for any loss or damage of any kind incurred as a result of the use of the site or our mobile application or reliance on any information provided on the site and our mobile application. Your use of the site and our mobile application and your reliance on any information on the site and our mobile application is solely at your own risk.
        </p>
        <div class="each_sub_head">17.2 External links disclaimer</div>
        <p class="normal">
            External links disclaimerthe site and our mobile application may contain (or you may be sent through the site or our mobile application) links to other websites or content belonging to or originating from third parties or links to websites and features in banners or other advertising. Such external links are not investigated, monitored, or checked for accuracy, adequacy, validity, reliability, availability or completeness by us. We do not warrant, endorse, guarantee, or assume responsibility for the accuracy or reliability of any information offered by third-party websites linked through the site or any website or feature linked in any banner or other advertising. We will not be a party to or in any way be responsible for monitoring any transaction between you and third-party providers of products or services.
        </p>
        <div class="each_sub_head">17.3 Professional disclaimer</div>
        <p class="normal">
            The site cannot and does not contain creative advice. The creative information is provided for general informational and educational purposes only and is not a substitute for professional advice. Accordingly, before taking any actions based upon such information, we encourage you to consult with the appropriate professionals. We do not provide any kind of creative advice. The use or reliance of any information contained on this site or our mobile application is solely at your own risk.
        </p>
        <div class="each_sub_head">17.4 Affiliates disclaimer</div>
        <p class="normal">
            The Site and our mobile application may contain links to affiliate websites, and we receive an affiliate commission for any purchases made by you on the affiliate website using such links. Our affiliates include the following:
        </p>
        <ul class="normal">
            <li>
                Stripe
            </li>   
        </ul>
        @endif
        @if($type == 'cookies')   
        <div class="each_head">27- Cookies</div> 
        <p class="normal">
            This Cookie Policy explains how 1Platform ("Company", "we", "us", and "our") uses cookies and similar technologies to recognize you when you visit our websites at https://{{Config('constants.primaryDomain')}}/, ("Websites"). It explains what these technologies are and why we use them, as well as your rights to control our use of them. In some cases we may use cookies to collect personal information, or that becomes personal information if we combine it with other information.
        </p>
        <div class="each_sub_head">27.1 What are cookies?</div>
        <p class="normal">
            Cookies are small data files that are placed on your computer or mobile device when you visit a website. Cookies are widely used by website owners in order to make their websites work, or to work more efficiently, as well as to provide reporting information.
        </p>
        <p class="normal">
            Cookies set by the website owner (in this case, 1Platform ) are called "first party cookies". Cookies set by parties other than the website owner are called "third party cookies". Third party cookies enable third party features or functionality to be provided on or through the website (e.g. like advertising, interactive content and analytics). The parties that set these third party cookies can recognize your computer both when it visits the website in question and also when it visits certain other websites.
        </p>
        <div class="each_sub_head">27.2 Why do we use cookies?</div>
        <p class="normal">
            We use first and third party cookies for several reasons. Some cookies are required for technical reasons in order for our Websites to operate, and we refer to these as "essential" or "strictly necessary" cookies. Other cookies also enable us to track and target the interests of our users to enhance the experience on our Online Properties. Third parties serve cookies through our Websites for advertising, analytics and other purposes. This is described in more detail below.
        </p>
        <p class="normal">
            The specific types of first and third party cookies served through our Websites and the purposes they perform are described below (please note that the specific cookies served may vary depending on the specific Online Properties you visit):
        </p>
        <div class="each_sub_head">27.3 How can I control cookies?</div>
        <p class="normal">
            You have the right to decide whether to accept or reject cookies. You can exercise your cookie rights by setting your preferences in the Cookie Consent Manager. The Cookie Consent Manager allows you to select which categories of cookies you accept or reject. Essential cookies cannot be rejected as they are strictly necessary to provide you with services.
        </p>
        <p class="normal">
            The Cookie Consent Manager can be found in the notification banner and on our website. If you choose to reject cookies, you may still use our website though your access to some functionality and areas of our website may be restricted. You may also set or amend your web browser controls to accept or refuse cookies. As the means by which you can refuse cookies through your web browser controls vary from browser-to-browser, you should visit your browser's help menu for more information.
        </p>
        <p class="normal">
            In addition, most advertising networks offer you a way to opt out of targeted advertising. If you would like to find out more information, please visit http://www.aboutads.info/choices/ or http://www.youronlinechoices.com.
        </p>
        <p class="normal">
            The specific types of first and third party cookies served through our Websites and the purposes they perform are described in the table below (please note that the specific cookies served may vary depending on the specific Online Properties you visit):
        </p>
        <div class="each_sub_head">27.4 Essential Website Cookies</div>
        <p class="normal">
            These cookies are strictly necessary to provide you with services available through our Websites and to use some of its features, such as access to secure areas.
        </p><br>
        <ul class="normal">
            <li>
                Name: __tlbcpv<br>
                Purpose: Used to record unique visitor views of the consent banner<br>
                Provider: .termly.io
                Service: Termly View Service Privacy Policy<br> 
                Country: United States<br>
                Type: http_cookie<br>
                Expires in: 1 year<br>
            </li>
            <li>  
                Name: PHPSESSID#<br>
                Purpose: Used by PHP to identify a current user's session. Its activity expires when a session is ended<br>
                Provider: {{Config('constants.primaryDomain')}}<br>
                Service: PHP View Service Privacy Policy  <br>
                Country: United States<br>
                Type: http_cookie<br>
                Expires in: session<br>
            </li>
            <li> 
                Name: __cfduid<br>
                Purpose: Used by Cloudflare to identify individual clients behind a shared IP address, and apply security settings on a per-client basis. This is a HTTP type cookie that expires after 1 year<br>
                Provider: www.tawk.to<br>
                Service: CloudFlare View Service Privacy Policy  <br>
                Country: United States<br>
                Type: server_cookie<br>
                Expires in: 30 days<br>
            </li>
        </ul>
        <br><p class="normal">
            These cookies collect information that is used either in aggregate form to help us understand how our Websites are being used or how effective our marketing campaigns are, or to help us customize our Websites for you.
        </p><br>
        <ul class="normal">
            <li>
                Name: _ga<br>
                Purpose: It records a particular ID used to come up with data about website usage by the user. It is a HTTP cookie that expires after 2 years<br>
                Provider:  {{Config('constants.primaryDomain')}}<br>
                Service: Google Analytics View Service Privacy Policy <br> 
                Country: United States<br>
                Type: http_cookie<br>
                Expires in: 1 year 11 months 29 days<br>
            </li>
            <li> 
                Name: _gid<br>
                Purpose: Keeps an entry of unique ID which is then used to come up with statistical data on website usage by visitors. It is a HTTP cookie type and expires after a browsing session<br>
                Provider: {{Config('constants.primaryDomain')}}<br>
                Service: Google Analytics View Service Privacy Policy  <br>
                Country: United States<br>
                Type: http_cookie<br>
                Expires in: 1 day<br>
            </li>
            <li>  
                Name: #collect<br>
                Purpose: Sends data such as visitor’s behavior and device to Google Analytics. It is able to keep track of the visitor across marketing channels and devices. It is a pixel tracker type cookie whose activity lasts within the browsing session<br>
                Provider: {{Config('constants.primaryDomain')}}<br>
                Service: Google Analytics View Service Privacy Policy  <br>
                Country: United States<br>
                Type: pixel_tracker<br>
                Expires in: session<br>
            </li>
            <li>  
                Name: _gat#<br>
                Purpose: Enables Google Analytics regulate the rate of requesting. It is a HTTP cookie type that lasts for a session<br>
                Provider: {{Config('constants.primaryDomain')}}<br>
                Service: Google Analytics View Service Privacy Policy <br> 
                Country: United States<br>
                Type: http_cookie<br>
                Expires in: 1 minute<br>
            </li>
        </ul>
        <br><p class="normal">
            These cookies are used to make advertising messages more relevant to you. They perform functions like preventing the same ad from continuously reappearing, ensuring that ads are properly displayed for advertisers, and in some cases selecting advertisements that are based on your interests.
        </p><br>
        <ul class="normal">
            <li> 
                Name: ga-audiences<br>
                Purpose: Used by Google AdWords to re-engage visitors that are likely to convert to customers based on the visitor's online behaviour across websites<br>
                Provider: {{Config('constants.primaryDomain')}}<br>
                Service: AdWords View Service Privacy Policy  <br>
                Country: United States<br>
                Type: pixel_tracker<br>
                Expires in: session<br>
            </li>
        </ul>
        <br><p class="normal">
            These are cookies that have not yet been categorized. We are in the process of classifying these cookies with the help of their providers.
        </p><br>
        <ul class="normal">
            <li>  
                Name: __tawkuuid<br>
                Purpose: __________<br>
                Provider: {{Config('constants.primaryDomain')}}<br>
                Service: __________  <br>
                Country: United States<br>
                Type: http_cookie<br>
                Expires in: 5 months 27 days<br>
            </li>
            <li>
                Name: TawkWindowName<br>
                Purpose: __________<br>
                Provider: {{Config('constants.primaryDomain')}}<br>
                Service: __________  <br>
                Country: United States<br>
                Type: html_session_storage<br>
                Expires in: session<br>
            </li>
            <li> 
                Name: twk_5e282463daaca76c6fcf4621<br>
                Purpose: __________<br>
                Provider: {{Config('constants.primaryDomain')}}<br>
                Service: __________  <br>
                Country: United States<br>
                Type: html_local_storage<br>
                Expires in: persistent<br>
            </li>
            <li> 
                Name: laravel_session<br>
                Purpose: Provider: {{Config('constants.primaryDomain')}}<br>
                Service: __________  <br>
                Country: United States<br>
                Type: http_cookie<br>
                Expires in: 2 hours<br>
            </li>
            <li>  
                Name: ss<br>
                Purpose: __________<br>
                Provider: va.tawk.to<br>
                Service: __________  <br>
                Country: United States<br>
                Type: http_cookie<br>
                Expires in: session<br>
            </li>
            <li>  
                Name: XSRF-TOKEN<br>
                Purpose: Provider: {{Config('constants.primaryDomain')}}<br>
                Service: __________  <br>
                Country: United States<br>
                Type: server_cookie<br>
                Expires in: 2 hours<br>
            </li>
            <li>    
                Name: tawkUUID<br>
                Purpose: __________<br>
                Provider: va.tawk.to<br>
                Service: __________  <br>
                Country: United States<br>
                Type: http_cookie<br>
                Expires in: 5 months 27 days<br>
            </li>
            <li>    
                Name: TawkConnectionTime<br>
                Purpose: __________<br>
                Provider: {{Config('constants.primaryDomain')}}<br>
                Service: __________  <br>
                Country: United States<br>
                Type: http_cookie<br>
                Expires in: session<br>
            </li>
        </ul><br>
        <div class="each_sub_head">27.5 What About Other Tracking Technologies, Like Web Beacons?</div>
        <p class="normal">
            Cookies are not the only way to recognize or track visitors to a website. We may use other, similar technologies from time to time, like web beacons (sometimes called "tracking pixels" or "clear gifs"). These are tiny graphics files that contain a unique identifier that enable us to recognize when someone has visited our Websites or opened an e-mail including them. This allows us, for example, to monitor the traffic patterns of users from one page within a website to another, to deliver or communicate with cookies, to understand whether you have come to the website from an online advertisement displayed on a third-party website, to improve site performance, and to measure the success of e-mail marketing campaigns. In many instances, these technologies are reliant on cookies to function properly, and so declining cookies will impair their functioning.
        </p>
        <div class="each_sub_head">27.6 Do You Use Flash Cookies or Local Shared Objects?</div>
        <p class="normal">
            Websites may also use so-called "Flash Cookies" (also known as Local Shared Objects or "LSOs") to, among other things, collect and store information about your use of our services, fraud prevention and for other site operations.
        </p>
        <p class="normal">
            If you do not want Flash Cookies stored on your computer, you can adjust the settings of your Flash player to block Flash Cookies storage using the tools contained in the Website Storage Settings Panel. You can also control Flash Cookies by going to the Global Storage Settings Panel and following the instructions (which may include instructions that explain, for example, how to delete existing Flash Cookies (referred to "information" on the Macromedia site), how to prevent Flash LSOs from being placed on your computer without your being asked, and (for Flash Player 8 and later) how to block Flash Cookies that are not being delivered by the operator of the page you are on at the time).
        </p>
        <p class="normal">
            Please note that setting the Flash Player to restrict or limit acceptance of Flash Cookies may reduce or impede the functionality of some Flash applications, including, potentially, Flash applications used in connection with our services or online content.
        </p>
        <div class="each_sub_head">27.7 Do You Serve Targeted Advertising?</div>
        <p class="normal">
            Third parties may serve cookies on your computer or mobile device to serve advertising through our Websites. These companies may use information about your visits to this and other websites in order to provide relevant advertisements about goods and services that you may be interested in. They may also employ technology that is used to measure the effectiveness of advertisements. This can be accomplished by them using cookies or web beacons to collect information about your visits to this and other sites in order to provide relevant advertisements about goods and services of potential interest to you. The information collected through this process does not enable us or them to identify your name, contact details or other details that directly identify you unless you choose to provide these.
        </p>
        <div class="each_sub_head">27.8 How Often Will You Update This Cookie Policy?</div>
        <p class="normal">
            We may update this Cookie Policy from time to time in order to reflect, for example, changes to the cookies we use or for other operational, legal or regulatory reasons. Please therefore re-visit this Cookie Policy regularly to stay informed about our use of cookies and related technologies.
        </p>
        <div class="each_sub_head">27.9 Where Can I Get Further Information?</div>
        <p class="normal">
            If you have any questions about our use of cookies or other technologies, please email us at contact@1platform.tv
        </p>
        @endif
        @if($type == 'bespoke')
        <div class="each_head">28- Bespoke License</div>
        <p class="normal">
            1Platform is world's first bespoke licensing platform. Here a composer can meet a film maker, a sound engineer can do projects with production studio or a vocalist can team up with video creator. Everything happens on 1Platform using bespoke licensing.
        </p> 
        <div class="each_sub_head">28.1 Terms of Use</div> 
        <p class="normal">
            Both parties are completely responsible for your communication with each other in 1Platform. 1Platform will have no liability or obligation with respect. We reserve the right but have no commitment to become involved with disputes between yourself and other users of 1Platform.
        </p> 
        <p class="normal">
            This agreement becomes valid from the purchase date listed above and is binding to both parties. Any use of the work not expressed in this agreement shall constitute an infringement of the copyright. You hereby agree to accord credit to us wherever other material credits are given
        </p>
        <p class="normal">
            Both Parties represent and warrant that they have the full right, power and authority to enter into this agreement and to grant to you the rights herein set out upon the terms and conditions herein contained and in the event of any breach of this or any other warranty (express or implied) by us then in no event shall our total liability exceed the Fee paid by us hereunder.
        </p> 
        <p class="normal">
            In the event that either party or your assignees or sub-licensees are in breach of any of the terms of this agreement (and in the case of breaches that can be remedied, if such breach is not remedied within 15 (fifteen) days of written notice to remedy from us) then this agreement shall terminate and we shall be entitled to retain all monies heretofore paid to us without prejudice to any of our other rights or remedies.
        </p> 
        <p class="normal">
            Upon the expiration of the Term or other termination of this agreement all rights herein granted shall immediately terminate and no further exploitation of the work and or artist by you shall be permitted hereunder. This is a binding agreement between the two parties in regards to their agreement. This agreement does not bind 1Platform and its affiliates (beyond the point of the service that they are providing).
        </p>
        <div class="each_sub_head">28.2 Non Assignment</div> 
        <p class="normal">
            You may not assign or sub-license any of the rights granted hereunder to any third party without our prior written approval. No such transfer or assignment shall become effective unless and until the transferee or assignee shall deliver to us a written agreement assuming the further performance of your obligations hereunder, and no such transfer or assignment shall relieve you of any obligation hereunder. However, you may enter into sub-agreements within the Territory to the extent necessary to permit the exhibition of the Personal Use Only in accordance with this agreement.
        </p>
        <p class="normal">
            This agreement shall be governed by and construed in accordance with English Law and the parties hereby submit to the exclusive jurisdiction of the Courts of England and Wales.
        </p> 
        <p class="normal">
            This agreement contains all of the terms agreed between the parties and replaces any and all previous agreements, whether written or oral, concerning the subject matter hereof. This agreement shall not be modified or varied except by a written instrument signed by the parties.
        </p> 
        <p class="normal">
            With this agreement, you agree to the following points of conduct between yourself and other users or parties
        </p> 
        <div class="each_sub_head">28.3 Conduct</div> 
        <p class="normal">
            No action will be taken that breaks any laws, infringes rights, or breaches any legal contact you may have.
        </p> 
        <p class="normal">
            Do not knowingly submit any information that is incorrect, misleading or fraudulent.
        </p> 
        <p class="normal">
            Do not exchange any items that are illegal or in violation of our terms and conditions.
        </p> 
        <p class="normal">
            Victimisation, bullying, threatening, abusing or offensive treatment of another party (or any violation of there privacy, shall not be permitted)
        </p> 
        <p class="normal">
            Spam shall not be allowed, this includes any unsolicited or unauthorized advertising and promotion. Junk mail, auto-responders and spam shall not be used on 1Platform.
        </p> 
        <p class="normal">
            You will not knowingly harm or infect other parties devices. This includes viruses and harmful software.
        </p> 
        <p class="normal">
            Personal information of either party will not be shared, sold or otherwise distributed.
        </p> 
        <div class="each_sub_head">28.4 Site Security</div> 
        <p class="normal">
            You will not interfere with the 1Platform website or any of its services. This extends to security measures placed into the site.
        </p> 
        <p class="normal">
            Unauthorized access will not be permitted on any system. This includes access to data, passwords and any other relevant information.
        </p> 
        <p class="normal">
            Don't give out personal security information such as passwords.
        </p> 
        <p class="normal">
            Do not add unnecessary strain to the services provided by 1Platform or our third parties
        </p> 
        <p class="normal">
            Crawling or spidering the site is prohibited
        </p> 
        <p class="normal">
            Do not copy any source code or manipulate any aspect of 1Platform
        </p> 
        <div class="each_sub_head">28.5 Payment</div> 
        <p class="normal">
            On the instance that any terms of the license are violated the license shall be null
        </p> 
        <p class="normal">
            Should either party not deliver their part of the agreement then action can be taken to solve the dispute if the parties are unable to resolve on their own.
        </p> 
        <div class="each_sub_head">28.6 Platform Fee</div> 
        <p class="normal">
            To keep the site functional and operational the site will take a 6% fee from this transaction this fee will be split between both parties.
        </p> 
        <div class="each_sub_head">28.7 Confirmation of Agreement</div> 
        <p class="normal">
            This agreement and information is for the purpose of a transaction on 1Platform between two or more parties.
        </p> 
        <div class="each_sub_head">28.8 Intellectual Property</div> 
        <p class="normal">
            1Platform does not own any property or work created under this agreement, however certain licenses are required to perform the services that 1Platform provides
        </p> 
        <p class="normal">
            1Platform and our use of third parties will use your content and data with the intention of worldwide, non-exclusive, perpetual, irrevocable, royalty-free, sublicensable, transferable right to use, exercise, commercialize, and exploit the copyright, publicity, trademark, and database rights with respect to your content.
        </p> 
        <p class="normal">
            When using the content, you give us a right to modify, edit and change the respective content. It will not be submitted that you do not hold permission for or have not gained rights to use. This also includes third-party content. By submitting content to 1Platform you acknowledge it can be used without violating any rights or copyright. This includes privacy rights, publicity rights, copyrights, contract rights, or any other intellectual property or property rights.
        </p> 
        <p class="normal">
            1Platform is not responsible for what you post, and as such we are not liable for any mistakes or errors.
        </p> 
        <div class="each_sub_head">28.9 1Platform's Intellectual Property</div> 
        <p class="normal">
            1Platforms services, logos, patents, copyright, and trademarks are protected legally and remain property of 1Platform. They cannot be remixed and should not be used for derivative or slanderous content. Restrictions to information applied to the site as well as copyright should be respected and Content from 1Platform can be used for personal use only. Any commercial use can only be done with written permission from 1Platform.
        </p>
        @endif
        @if($type == 'agency')
        <div class="each_head">29- 1Platform Agency</div> 
        <div class="each_sub_head">29.1 Terms Between Agent and Buyer or Agent and Seller</div>
        <ul class="normal">
            <li>
                Both parties are completely responsible for their communication with each other in 1Platform.
            </li>
            <li>
                1Platform will have no liability or obligation with respect. We reserve the right but have no commitment to become involved with disputes between yourself and other users of 1Platform.
            </li>
            <li>
                This agreement becomes valid from the purchase date listed above and is binding to both parties.
            </li>
            <li>
                Any use of the work not expressed in this agreement shall constitute an infringement of the copyright, should the respective party wish to take an action.
            </li>
            <li>
                You hereby agree to accord credit to us wherever other material credits are given
            </li>
            <li>
                Both Parties represent and warrant that they have the full right, power and authority to enter into this agreement and to grant to you the rights herein set out upon the terms and conditions herein contained and in the event of any breach of this or any other warranty (express or implied) by us then in no event shall our total liability exceed the Fee paid by us hereunder.
            </li>
            <li>
                In the event that either party or your assignees or sub-licensees are in breach of any of the terms of this agreement (and in the case of breaches that can be remedied, if such breach is not remedied within 15 (fifteen) days of written notice to remedy from us) then this agreement shall terminate and we shall be entitled to retain all monies heretofore paid to us without prejudice to any of our other rights or remedies.
            </li>
            <li>
                Upon the expiration of the Term or other termination of this agreement all rights herein granted shall immediately terminate and no further exploitation of the work and or artist by you shall be permitted hereunder.
            </li>
            <li>
                This is a binding agreement between the two parties in regards to their agreement. This agreement does not bind 1Platform and its affiliates (beyond the point of the service that they are providing).

            </li>
        </ul> 
        <br>
        <div class="each_sub_head">29.1.1 Non Assignment</div>
        <p class="normal">
            You may not assign or sub-license any of the rights granted hereunder to any third party without our prior written approval. No such transfer or assignment shall become effective unless and until the transferee or assignee shall deliver to us a written agreement assuming the further performance of your obligations hereunder, and no such transfer or assignment shall relieve you of any obligation hereunder.
        </p>
        <p class="normal">
            However, you may enter into sub-agreements within the Territory to the extent necessary to permit the exhibition of the Personal Use Only in accordance with this agreement.
        </p>
        <p class="normal">
            This agreement shall be governed by and construed in accordance with English Law and the parties hereby submit to the exclusive jurisdiction of the Courts of England and Wales.
        </p>
        <p class="normal">
            This agreement contains all of the terms agreed between the parties and replaces any and all previous agreements, whether written or oral, concerning the subject matter hereof. This agreement shall not be modified or varied except by a written instrument signed by the parties.
        </p>
        <p class="normal">
            With this agreement, you agree to the following points of conduct between yourself and other users or parties
        </p>
        <div class="each_sub_head">29.1.2 Conduct</div>
        <ul class="normal">
            <li>
                No action will be taken that breaks any laws, infringes rights, or breaches any legal contact you may have.
            </li>
            <li>
                Do not knowingly submit any information that is incorrect, misleading or fraudulent.
            </li>
            <li>
                Do not exchange any items that are illegal or in violation of our terms and conditions.
            </li>
            <li>
                Victimisation, bullying, threatening, abusing or offensive treatment of another party (or any violation of there privacy, shall not be permitted)
            </li>
            <li>
                Spam shall not be allowed, this includes any unsolicited or unauthorized advertising and promotion. Junk mail, auto-responders and spam shall not be used on 1Platform.
            </li>
            <li>
                You will not knowingly harm or infect other parties devices. This includes viruses and harmful software.
            </li>
            <li>
                Personal information of either party will not be shared, sold or otherwise distributed.
            </li>
        </ul>
        <br>
        <div class="each_sub_head">29.1.3 Site Security</div>
        <ul class="normal">
            <li>
                You will not interfere with the 1Platform website or any of its services. This extends to security measures placed into the site.
            </li>
            <li>
                Unauthorized access will not be permitted on any system. This includes access to data, passwords and any other relevant information.
            </li>
            <li>
                Don't give out personal security information such as passwords.
            </li>
            <li>
                Do not add unnecessary strain to the services provided by 1Platform or our third parties.
            </li>
            <li>
                Crawling or spidering the site is prohibited
            </li>
            <li>
                Do not copy any source code or manipulate any aspect of 1Platform.
            </li>
        </ul>
        <br>
        <div class="each_sub_head">29.1.4 Payment</div>
        <ul class="normal">
            <li>
                On the instance that any terms of the license are violated the license shall be null.
            </li>
            <li>
                Should either party not deliver their part of the agreement then action can be taken to solve the dispute if the parties are unable to resolve on their own.
            </li>
        </ul>
        <br>
        <div class="each_sub_head">29.1.5 Platform Fee</div>
        <ul class="normal">
            <li>
                To keep the site functional and operational the site will take a fee from this transaction (Get Ahsan to insert fee here)- this fee will be split between both parties.
            </li>
        </ul>
        <br>
        <div class="each_sub_head">29.1.6 Confirmation of Agreement</div>
        <ul class="normal">
            <li>
                This agreement and information is for the purpose of a transaction on 1Platform between two or more parties.
            </li>
        </ul>
        <br>
        <div class="each_sub_head">29.1.7 Intellectual Property</div>
        <ul class="normal">
            <li>
                1Platform does not own any property or work created under this agreement. However certain licenses are required to perform the services that 1Platform provides
            </li>
            <li>
                1Platform and our use of third parties will use your content and data with the intention of worldwide, non-exclusive, perpetual, irrevocable, royalty-free, sublicensable, transferable right to use, exercise, commercialize, and exploit the copyright, publicity, trademark, and database rights with respect to your content.
            </li>
            <li>
                When using the content, you give us a right to modify, edit and change the respective content
            </li>
            <li>
                Content will not be submitted that you do not hold permission for or have not gained rights to use. This also includes third-party content.
            </li>
            <li>
                By submitting content to 1Platform you acknowledge it can be used without violating any rights or copyright. This includes privacy rights, publicity rights, copyrights, contract rights, or any other intellectual property or proprietary rights.
            </li>
            <li>
                1Platform is not responsible for what you post, and as such we are not liable for any mistakes or errors.
            </li>
        </ul>
        <br>
        <div class="each_sub_head">29.1.8 1Platform's Intellectual Property</div>
        <ul class="normal">
            <li>
                1Platforms services, logos, patents, copyright, and trademarks are protected legally and remain property of 1Platform. They cannot be remixed and should not be used for derivative or slanderous content.
            </li>
            <li>
                Restrictions to information applied to the site as well as copyright should be respected and 
                Content from 1Platform can be used for personal use only. Any commercial use can only be done with written permission from 1Platform.
            </li>
        </ul>
        <br>
        <div class="each_sub_head">29.2 Terms Between 1Platform and Agents</div>
        <p class="normal">
            1Platform will have no liability or obligation with respect. We reserve the right but have no commitment to become involved with disputes between yourself and your contacts. 
        </p>
        <p class="normal">
            You hereby agree to accord credit to us wherever other material credits are given
        </p>
        <p class="normal">
            You agree and accept that you have read through our terms and conditions, privacy policy and all other appropriate documentation and agreements.
        </p>
        <p class="normal">
            You as an agent accept that you can represent and warrant that you have the full right, power and authority to enter into this agreement and to grant to you the rights herein set out upon the terms and conditions herein contained and in the event of any breach of this or any other warranty (express or implied) by us then in no event shall our total liability exceed the Fee paid by us hereunder.
        </p>
        <p class="normal">
            Should you or your assignees be in breach of any of the terms of this agreement (and in the case of breaches that can be remedied, if such breach is not remedied within 15 (fifteen) days of written notice to remedy from us) then this agreement shall terminate and we shall be entitled to retain all monies heretofore paid to us without prejudice to any of our other rights or remedies.
        </p>
        <p class="normal">
            Upon the expiration of the Term or other termination of this agreement all rights herein granted shall immediately terminate.
        </p>
        <div class="each_sub_head">29.2.1 Non Assignment</div>
        <p class="normal">
            You may not assign or sub-license any of the rights granted hereunder to any third party without our prior written approval. No such transfer or assignment shall become effective unless and until the transferee or assignee shall deliver to us a written agreement assuming the further performance of your obligations hereunder, and no such transfer or assignment shall relieve you of any obligation hereunder.
        </p>
        <p class="normal">
            However, you may enter into sub-agreements within the Territory to the extent necessary to permit the exhibition of the Personal Use Only in accordance with this agreement.
        </p>
        <p class="normal">
            This agreement shall be governed by and construed in accordance with English Law and the parties hereby submit to the exclusive jurisdiction of the Courts of England and Wales.
        </p>
        <p class="normal">
            This agreement contains all of the terms agreed between the parties and replaces any and all previous agreements, whether written or oral, concerning the subject matter hereof. This agreement shall not be modified or varied except by a written instrument signed by the parties.
        </p>
        <p class="normal">
            With this agreement, you agree to the following points of conduct between yourself and other users or parties
        </p>
        <div class="each_sub_head">29.2.2 Conduct</div>
        <ul class="normal">
            <li>
                No action will be taken that breaks any laws, infringes rights, or breaches any legal contact you may have.
            </li>
            <li>
                Do not knowingly submit any information that is incorrect, misleading or fraudulent.
            </li>
            <li>
                Do not exchange any items that are illegal or in violation of our terms and conditions.
            </li>
            <li>
                Victimisation, bullying, threatening, abusing or offensive treatment of another party (or any violation of there privacy, shall not be permitted)
            </li>
            <li>
                Spam shall not be allowed, this includes any unsolicited or unauthorized advertising and promotion. Junk mail, auto-responders and spam shall not be used on 1Platform.
            </li>
            <li>
                You will not knowingly harm or infect other parties devices. This includes viruses and harmful software.
            </li>
            <li>
                Personal information of either party will not be shared, sold or otherwise distributed.
            </li>
            <li>
                You shall not list any of your work as partnered by 1Platform unless given written permission
            </li>
        </ul>
        <br>
        <div class="each_sub_head">29.2.3 Communication</div>
        <ul class="normal">
            <li>
                All agents are expected to communicate professionally and regularly with a contact.
            </li>
            <li>
                Agents are not to contact clients through any means other than 1Platform.
            </li>
        </ul>
        <br>
        <div class="each_sub_head">29.2.4 Payment</div>
        <ul class="normal">
            <li>
                All payment shall be processed through 1Platform.
            </li>
            <li>
                Agents are not to suggest or process any payment through any third party provider/bank etc.
            </li>
            <li>
                1Platform will take (insert percent from agreement here)  from each transaction between the agent and there respective contacts, as agreed with the agent prior to this agreement.
            </li>
        </ul>
        <br>
        <div class="each_sub_head">29.2.5 Non Disclosure</div>
        <ul class="normal">
            <li>
                The agent is not to disclose or discuss any points of this agreement to any party other than 1Platform during or after the agreement has been made.
            </li>
        </ul>
        <br>
        <div class="each_sub_head">29.2.6 Termination</div>
        <ul class="normal">
            <li>
                1Platform reserves the right to terminate this contact, should reason be given or should the agent break any terms stated in this agreement
            </li>
        </ul>
        <br>
        @endif
        @if($type == 'privacy')
        <div class="each_head">30- Privacy Policy</div> 
        <p class="normal">
            We care about data privacy and security. By using the Site, you agree to be bound by our Privacy Policy, which is incorporated into these Terms of Use. Please be advised the Site is hosted in the United Kingdom. If you access the Site from any other region of the world with laws or other requirements governing personal data collection, use, or disclosure that differ from applicable laws in the United Kingdom, then through your continued use of the Site, you are transferring your data to the United Kingdom, and you agree to have your data transferred to and processed in the United Kingdom. Further, we do not knowingly accept, request, or solicit information from children or knowingly market to children. Therefore, in accordance with the U.S. Children’s Online Privacy Protection Act, if we receive actual knowledge that anyone under the age of 13 has provided personal information to us without the requisite and verifiable parental consent, we will delete that information from the Site as quickly as is reasonably practical.
        </p>
        <p class="normal">
            When you visit our website {{route('site.home')}}, mobile application, and use our services, you trust us with your personal information. We take your privacy very seriously. In this privacy notice, we describe our privacy policy. We seek to explain to you in the clearest way possible what information we collect, how we use it and what rights you have in relation to it. We hope you take some time to read through it carefully, as it is important. If there are any terms in this privacy policy that you do not agree with, please discontinue use of our Sites or Apps and our services.
        </p>
        <p class="normal">
            This privacy policy applies to all information collected through our website (such as {{route('site.home')}}), mobile application, ("Apps"), and/or any related services, sales, marketing or events (we refer to them collectively in this privacy policy as the "Sites").
        </p>
        <p class="normal">
            Please read this privacy policy carefully as it will help you make informed decisions about sharing your personal information with us.
        </p>
        <div class="each_sub_head">30.1 What information do we collect?</div>
        <div class="each_sub_head">30.1.1 Personal Information You Disclose to Us</div>
        <p class="normal">
            In Short we collect personal information that you provide to us such as name, address, contact information, passwords and security data, payment information, and social media login data.
        </p>
        <p class="normal">
            We collect personal information that you voluntarily provide to us when registering at the Sites or Apps, expressing an interest in obtaining information about us or our products and services, when participating in activities on the Sites or Apps (such as posting messages in our online forums or entering competitions, contests or giveaways) or otherwise contacting us.
        </p>
        <p class="normal">
            The personal information that we collect depends on the context of your interactions with us and the Sites or Apps, the choices you make and the products and features you use. The personal information we collect can include the following:
        </p>
        <ul class="normal">
            <li>
                Name and Contact Data. We collect your first and last name, email address, postal address, phone number, and other similar contact data.
            </li>
            <li>
                Credentials. We collect passwords, password hints, and similar security information used for authentication and account access.
            </li>
            <li>
                Payment Data. We collect data necessary to process your payment if you make purchases, such as your payment instrument number (such as a credit card number), and the security code associated with your payment instrument. All payment data is stored by our payment processor and you should review its privacy policies and contact the payment processor directly to respond to your questions.
            </li>
            <li>
                Social Media Login Data. We provide you with the option to register using social media account details, like your Facebook, Twitter or other social media account. If you choose to register in this way, we will collect the Information described in the section called "HOW DO WE HANDLE YOUR SOCIAL LOGINS" below.
            </li>
        </ul>
        <p class="normal">
            All personal information that you provide to us must be true, complete and accurate, and you must notify us of any changes to such personal information.
        </p>
        <div class="each_sub_head">30.1.2 Information Automatically Collected</div>
        <p class="normal">
            In Short some information – such as IP address and/or browser and device characteristics – is collected automatically when you visit our Sites or Apps.
        </p>
        <p class="normal">
            We automatically collect certain information when you visit, use or navigate the Sites or Apps. This information does not reveal your specific identity (like your name or contact information) but may include device and usage information, such as your IP address, browser and device characteristics, operating system, language preferences, referring URLs, device name, country, location, information about how and when you use our Sites or Apps and other technical information. This information is primarily needed to maintain the security and operation of our Sites or Apps, and for our internal analytics and reporting purposes.
        </p>
        <p class="normal">
            Like many businesses, we also collect information through cookies and similar technologies.
        </p>
        <div class="each_sub_head">30.1.3 Information Collected Through our Apps</div>
        <p class="normal">
            In Short: We may collect information regarding your mobile device, push notifications, when you use our apps. If you use our Apps, we may also collect the following information:
        </p>
        <ul class="normal">
            <li>
                Mobile Device Access. We may request access or permission to certain features from your mobile device, including your mobile device’s camera, social media accounts, storage, and other features. If you wish to change our access or permissions, you may do so in your device’s settings.
            </li>
            <li>
                Mobile Device Data. We may automatically collect device information (such as your mobile device ID, model and manufacturer), operating system, version information and IP address.
            </li>
            <li>
                Push Notifications. We may request to send you push notifications regarding your account or the mobile application. If you wish to opt-out from receiving these types of communications, you may turn them off in your device’s settings. 
            </li>
        </ul>
        <div class="each_sub_head">30.1.4 Information Collected From Other Sources</div>
        <p class="normal">
            In Short: We may collect limited data from public databases, marketing partners, social media platforms, and other outside sources.
        </p>
        <p class="normal">
            We may obtain information about you from other sources, such as public databases, joint marketing partners, social media platforms (such as Facebook), as well as from other third parties. Examples of the information we receive from other sources include: social media profile information (your name, gender, birthday, email, current city, state and country, user identification numbers for your contacts, profile picture URL and any other information that you choose to make public); marketing leads and search results and links, including paid listings (such as sponsored links).
        </p>
        <div class="each_sub_head">30.2 How Do We Use Your Information?</div>
        <p class="normal">
            In Short: We process your information for purposes based on legitimate business interests, the fulfillment of our contract with you, compliance with our legal obligations, and/or your consent.
        </p>
        <p class="normal">
            We use personal information collected via our Sites or Apps for a variety of business purposes described below. We process your personal information for these purposes in reliance on our legitimate business interests ("Business Purposes"), in order to enter into or perform a contract with you ("Contractual"), with your consent ("Consent"), and/or for compliance with our legal obligations ("Legal Reasons"). We indicate the specific processing grounds we rely on next to each purpose listed below.
        </p>
        <p class="normal">
            We use the information we collect or receive:
        </p>
        <ul class="normal">
            <li>
                To facilitate account creation and logon process.If you choose to link your account with us to a third party account *(such as your Google or Facebook account), we use the information you allowed us to collect from those third parties to facilitate account creation and logon process. See the section below headed "HOW DO WE HANDLE YOUR SOCIAL LOGINS" for further information.
            </li>
            <li>
                To send you marketing and promotional communications. We and/or our third party marketing partners may use the personal information you send to us for our marketing purposes, if this is in accordance with your marketing preferences. You can opt-out of our marketing emails at any time (see the "WHAT ARE YOUR PRIVACY RIGHTS" below).
            </li>
            <li>
                To send administrative information to you. We may use your personal information to send you product, service and new feature information and/or information about changes to our terms, conditions, and policies.
            </li>
            <li>
                Fulfill and manage your orders. We may use your information to fulfill and manage your orders, payments, returns, and exchanges made through the Sites or Apps. 
            </li>
            <li>
                To protect our Sites. We may use your information as part of our efforts to keep our Sites or Apps safe and secure (for example, for fraud monitoring and prevention). 
            </li>
            <li>
                To enable user-to-user communications. We may use your information in order to enable user-to-user communications with each user's consent.
            </li>
            <li>
                To enforce our terms, conditions and policies.
            </li>
            <li>
                To respond to legal requests and prevent harm. If we receive a subpoena or other legal request, we may need to inspect the data we hold to determine how to respond. 
            </li>
            <li>
                For other Business Purposes. We may use your information for other Business Purposes, such as data analysis, identifying usage trends, determining the effectiveness of our promotional campaigns and to evaluate and improve our Sites or Apps, products, services, marketing and your experience. 
            </li>
        </ul>   
        <div class="each_sub_head">30.3 Will Your Information Be Shared With Anyone?</div>
        <p class="normal">
            In Short: We only share information with your consent, to comply with laws, to protect your rights, or to fulfill business obligations.
        </p>
        <p class="normal">
            We may process or share data based on the following legal basis:
        </p>
        <ul class="normal">
            <li>
                Consent: We may process your data if you have given us specific consent to use your personal information in a specific purpose.
            </li>
            <li>
                Legitimate Interests: We may process your data when it is reasonably necessary to achieve our legitimate business interests.
            </li>
            <li>
                Performance of a Contract: Where we have entered into a contract with you, we may process your personal information to fulfill the terms of our contract.
            </li>
            <li>
                Legal Obligations: We may disclose your information where we are legally required to do so in order to comply with applicable law, governmental requests, a judicial proceeding, court order, or legal process, such as in response to a court order or a subpoena (including in response to public authorities to meet national security or law enforcement requirements).
            </li>
            <li>
                Vital Interests: We may disclose your information where we believe it is necessary to investigate, prevent, or take action regarding potential violations of our policies, suspected fraud, situations involving potential threats to the safety of any person and illegal activities, or as evidence in litigation in which we are involved.
            </li>
        </ul>
        <p class="normal">
            More specifically, we may need to process your data or share your personal information in the following situations:
        </p>
        <ul class="normal">
            <li>
                Vendors, Consultants and Other Third-Party Service Providers. We may share your data with third party vendors, service providers, contractors or agents who perform services for us or on our behalf and require access to such information to do that work. Examples include: payment processing, data analysis, email delivery, hosting services, customer service and marketing efforts. We may allow selected third parties to use tracking technology on the Sites or Apps, which will enable them to collect data about how you interact with the Sites or Apps over time. This information may be used to, among other things, analyze and track data, determine the popularity of certain content and better understand online activity. Unless described in this Policy, we do not share, sell, rent or trade any of your information with third parties for their promotional purposes.
            </li>
            <li>
                Business Transfers. We may share or transfer your information in connection with, or during negotiations of, any merger, sale of company assets, financing, or acquisition of all or a portion of our business to another company.
            </li>
            <li>
                Other Users. When you share personal information (for example, by posting comments, contributions or other content to the Sites or Apps) or otherwise interact with public areas of the Sites or Apps, such personal information may be viewed by all users and may be publicly distributed outside the Sites or Apps in perpetuity. If you interact with other users of our Sites or Apps and register through a social network (such as Facebook), your contacts on the social network will see your name, profile photo, and descriptions of your activity. Similarly, other users will be able to view descriptions of your activity, communicate with you within our Sites or Apps, and view your profile.
            </li>
        </ul>
        <div class="each_sub_head">30.4 Who Will Your Information Be Shared With?</div>
        <p class="normal">
            In Short:  We only share information with the following third parties.
        </p>
        <p class="normal">
            We only share and disclose your information with the following third parties. We have categorized each party so that you may be easily understand the purpose of our data collection and processing practices. If we have processed your data based on your consent and you wish to revoke your consent, please contact us.
        </p>
        <ul class="normal">
            <li>
                Allow Users to Connect to their Third-Party Accounts, Facebook account, Google account, Instagram account, spotify account and Twitter account
            </li>
            <li>
                Content Optimisation Google Site Search and YouTube video embed
            </li>
            <li>
                Invoice and Billing Stripe
            </li>
            <li>
                User Account Registration and Authentication Facebook Login, Google Sign-In, twitter sign-in and Instagram Authentication
            </li>
        </ul>
        <div class="each_sub_head">30.5 Do We Use Cookies and Other Tracking Technologies?</div>
        <p class="normal">
            In Short: We may use cookies and other tracking technologies to collect and store your information.
        </p>
        <p class="normal">
            We may use cookies and similar tracking technologies (like web beacons and pixels) to access or store information. Specific information about how we use such technologies and how you can refuse certain cookies is set out in our Cookie Policy.
        </p>
        <div class="each_sub_head">30.6 How Do We Handle Your Social Logins?</div>
        <p class="normal">
            In Short: If you choose to register or log in to our websites using a social media account, we may have access to certain information about you.
        </p>
        <p class="normal">
            Our Sites or Apps offer you the ability to register and login using your third party social media account details (like your Facebook or Twitter logins). Where you choose to do this, we will receive certain profile information about you from your social media provider. The profile Information we receive may vary depending on the social media provider concerned, but will often include your name, e-mail address, friends list, profile picture as well as other information you choose to make public. 
        </p>
        <p class="normal">
            We will use the information we receive only for the purposes that are described in this privacy policy or that are otherwise made clear to you on the Sites or Apps. Please note that we do not control, and are not responsible for, other uses of your personal information by your third party social media provider. We recommend that you review their privacy policy to understand how they collect, use and share your personal information, and how you can set your privacy preferences on their sites and apps.
        </p>
        <div class="each_sub_head">30.7 How Long Do We Keep Your Information?</div>
        <p class="normal">
            In Short: We keep your information for as long as necessary to fulfill the purposes outlined in this privacy policy unless otherwise required by law.
        </p>
        <p class="normal">
            We will only keep your personal information for as long as it is necessary for the purposes set out in this privacy policy, unless a longer retention period is required or permitted by law (such as tax, accounting or other legal requirements). No purpose in this policy will require us keeping your personal information for longer than 6 months past the termination of the user's account.
        </p>
        <p class="normal">
            When we have no ongoing legitimate business need to process your personal information, we will either delete or anonymize it, or, if this is not possible (for example, because your personal information has been stored in backup archives), then we will securely store your personal information and isolate it from any further processing until deletion is possible.
        </p>
        <div class="each_sub_head">30.8 How Do We Keep Your Information Safe?</div>
        <p class="normal">
            In Short: We aim to protect your personal information through a system of organisational and technical security measures.
        </p>
        <p class="normal">
            We have implemented appropriate technical and organisational security measures designed to protect the security of any personal information we process. However, please also remember that we cannot guarantee that the internet itself is 100% secure. Although we will do our best to protect your personal information, transmission of personal information to and from our Sites or Apps is at your own risk. You should only access the services within a secure environment.
        </p>
        <div class="each_sub_head">30.9 Do we collect information from minors?</div>
        <p class="normal">
            In Short: We do not knowingly collect data from or market to children under 18 years of age.
        </p>
        <p class="normal">
            We do not knowingly solicit data from or market to children under 18 years of age. By using the Sites or Apps, you represent that you are at least 18 or that you are the parent or guardian of such a minor and consent to such minor dependent’s use of the Sites or Apps. If we learn that personal information from users less than 18 years of age has been collected, we will deactivate the account and take reasonable measures to promptly delete such data from our records. If you become aware of any data we have collected from children under age 18, please contact us at contact@1platform.tv.
        </p>
        <div class="each_sub_head">30.10 What Are Your Privacy Rights?</div>
        <p class="normal">
            In Short: In some regions, such as the European Economic Area, you have rights that allow you greater access to and control over your personal information. You may review, change, or terminate your account at any time.
        </p>
        <p class="normal">
            In some regions (like the European Economic Area), you have certain rights under applicable data protection laws. These may include the right (i) to request access and obtain a copy of your personal information, (ii) to request rectification or erasure; (iii) to restrict the processing of your personal information; and (iv) if applicable, to data portability. In certain circumstances, you may also have the right to object to the processing of your personal information. To make such a request, please use the contact details provided below. We will consider and act upon any request in accordance with applicable data protection laws.
        </p>
        <p class="normal">
            If we are relying on your consent to process your personal information, you have the right to withdraw your consent at any time. Please note however that this will not affect the lawfulness of the processing before its withdrawal.
        </p>
        <p class="normal">
            If you are resident in the European Economic Area and you believe we are unlawfully processing your personal information, you also have the right to complain to your local data protection supervisory authority. You can find their contact details here: http://ec.europa.eu/justice/data-protection/bodies/authorities/index_en.htm
        </p>
        <div class="each_sub_head">30.11 Controls for Do-Not-Track Features</div>
        <p class="normal">
            Most web browsers and some mobile operating systems and mobile applications include a Do-Not-Track (“DNT”) feature or setting you can activate to signal your privacy preference not to have data about your online browsing activities monitored and collected. No uniform technology standard for recognizing and implementing DNT signals has been finalized. As such, we do not currently respond to DNT browser signals or any other mechanism that automatically communicates your choice not to be tracked online. If a standard for online tracking is adopted that we must follow in the future, we will inform you about that practice in a revised version of this Privacy Policy. 
        </p>
        <div class="each_sub_head">30.12 Do California Residents Have Specific Privacy Rights?</div>
        <p class="normal">
            In Short: Yes, if you are a resident of California, you are granted specific rights regarding access to your personal information. 
        </p>
        <p class="normal">
            California Civil Code Section 1798.83, also known as the “Shine The Light” law, permits our users who are California residents to request and obtain from us, once a year and free of charge, information about categories of personal information (if any) we disclosed to third parties for direct marketing purposes and the names and addresses of all third parties with which we shared personal information in the immediately preceding calendar year. If you are a California resident and would like to make such a request, please submit your request in writing to us using the contact information provided below.
        </p>
        <p class="normal">
            If you are under 18 years of age, reside in California, and have a registered account with the Sites or Apps, you have the right to request removal of unwanted data that you publicly post on the Sites or Apps. To request removal of such data, please contact us using the contact information provided below, and include the email address associated with your account and a statement that you reside in California. We will make sure the data is not publicly displayed on the Sites or Apps, but please be aware that the data may not be completely or comprehensively removed from our systems.
        </p>
        <div class="each_sub_head">30.13 Do We Make Updates to This Policy?</div>
        <p class="normal">
            In Short: Yes, we will update this policy as necessary to stay compliant with relevant laws.
        </p>
        <p class="normal">
            We may update this privacy policy from time to time. The updated version will be indicated by an updated “Revised” date and the updated version will be effective as soon as it is accessible. If we make material changes to this privacy policy, we may notify you either by prominently posting a notice of such changes or by directly sending you a notification. We encourage you to review this privacy policy frequently to be informed of how we are protecting your information. 
        </p>
        <div class="each_sub_head">30.14 How Can You Contact Us About This Policy?</div>
        <p class="normal">
            If you have questions or comments about this policy, you may email us at contact@1platform.tv
        </p>
        <div class="each_sub_head">30.15 How Can You Review, Update, or Delete the Data We Collect From You?</div>
        <p class="normal">
            Based on the applicable laws of your country, you may have the right to request access to the personal information we collect from you, change that information, or delete it in some circumstances. To request to review, update, or delete your personal information, please email: contact@1platform.tv We will respond to your request within 30 days.
        </p>

        @endif
        <div class="each_head">Contact 1Platform</div>
        <p class="normal">
            In order to resolve a complaint regarding the Site or to receive further information regarding use of the Site, please contact us at issues@1platform.co.uk
        </p>    
    </div>

@stop
