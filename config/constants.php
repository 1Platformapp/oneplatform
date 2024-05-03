<?php

return [

	'admin_email' => 'cotysostudios@gmail.com',

    'bcc_email' => 'office@recordingexperiences.com',

    'from_email' => env('MAIL_USERNAME', 'no-reply@recordingexperiences.com'),

    //'admin_email' => 'theauditiontv@gmail.com',

    'optimize_story_image' => 70,

    'optimize_music_image' => 70,

    'optimize_product_image' => 70,

    'optimize_bonus_image' => 70,

    'optimize_user_profile_image' => 70,

    'fcmServerKey' => 'AAAAbFFHXdQ:APA91bE3Rml-dYTML7hUd_R4v7ZB3gXAgfjVAUdi73e24W_Nbt49-bDz26hIMk1arpyXvYqwY8s4JK16z1bSxz4JwLYodnM60R571ihy_Hr0pPAN1Jabi0v8zFOJrcb0_vYWw1Q5aO0k',

    'primaryDomain' => 'http://127.0.0.1',

    'stripe_connect_client_id' => 'ca_GZAYmx7yDVCxFQxA37Etr0uEJgEfJ8GE',

    'stripe_connect_token_uri' => 'https://connect.stripe.com/oauth/token',

    'stripe_connect_authorize_uri' => 'https://connect.stripe.com/oauth/authorize',

    'stripe_key_public' => 'pk_test_hbwueutzl74sMtTbdanyqDyD00GTC7p3uj',

    'stripe_key_secret' => 'sk_test_aa56k9tR6Qu0Cry961SDBIpE00oaIX79zb',

    'stripe_platform_account_id' => 'acct_1G1y4hKVLFtbUew5',

    'stripe_webhook_secret' => 'whsec_gp3yAdreYYMuGTgRfD7gQ6ms78S0dZSL',

    'paypal_mode' => 'sandbox',

    'paypal_api_uri' => 'https://api-m.sandbox.paypal.com',

    'editor_tinycloud_api_key' => 'qg6p2tpxnxk2ndkur6146uhi041588nfurd5y6km3fcndzno',

    'facebook_profile' => 'https://www.facebook.com/1PlatformTV',

    'twitter_profile' => 'https://www.twitter.com/1PlatformTV',

    'instagram_profile' => 'https://www.instagram.com/1PlatformTV',

    'crowdfund_application_fee' => 4.75,

    'user_internal_packages' => [
        0 => ['name' => 'silver', 'volume' => 2, 'network_limit' => 10, 'application_fee' => 14, 'pricing' => ['month' => 0, 'year' => 0], 'plans' => ['month' => '', 'year' => '']],
        1 => ['name' => 'gold', 'volume' => 5, 'network_limit' => 100, 'application_fee' => 7, 'pricing' => ['month' => 15, 'year' => 150], 'plans' => ['month' => 'plan_GvpknURF7L8Ard', 'year' => 'plan_GvpjjnaxsDNNBs']],
        2 => ['name' => 'platinum', 'volume' => 10, 'network_limit' => 500, 'application_fee' => 2, 'pricing' => ['month' => 65, 'year' => 650], 'plans' => ['month' => 'plan_GvpiL6uWDjexAC', 'year' => 'plan_GvphF3EFx0lJUD']]
    ],

    'ffmpeg_path' => '/var/www/vhosts/recordingexperiences.com/httpdocs/usr/bin/ffmpeg',

    'ffmpeg_decoded_path' => '/var/www/vhosts/recordingexperiences.com/httpdocs/public/user-music-files/',

    'licenses' => [
        1 => ['name' => 'MP3 Standard', 'filename' => 'MP3 Standard', 'price' => 2, 'input_name' => 'mp3_standard', 'terms_id' => 51],
        2 => ['name' => 'Music Recording', 'filename' => 'Music Recording', 'price' => 25, 'input_name' => 'music_recording', 'terms_id' => 52],
        3 => ['name' => 'FULL FILE & STEMS', 'filename' => 'FULL FILE & STEMS', 'price' => 65, 'input_name' => 'full_file_stems', 'terms_id' => 53],
        4 => ['name' => 'Radio Advertisement', 'filename' => 'Radio Advertisement', 'price' => 50, 'input_name' => 'advertise_radio', 'terms_id' => 54],
        5 => ['name' => 'TV advertisement', 'filename' => 'TV advertisement', 'price' => 4800, 'input_name' => 'advertise_tv', 'terms_id' => 55],
        6 => ['name' => 'App', 'filename' => 'App', 'price' => 55, 'input_name' => 'app', 'terms_id' => 56],
        7 => ['name' => 'TV Show', 'filename' => 'TV Show', 'price' => 700, 'input_name' => 'tv_show', 'terms_id' => 57],
        8 => ['name' => 'Corporate Website, Event, Video', 'filename' => 'Corporate Website, Event, Video', 'price' => 150, 'input_name' => 'corporate_website_event_video', 'terms_id' => 58],
        9 => ['name' => 'Crowdfunding Campaign', 'filename' => 'Crowdfunding Campaign', 'price' => 50, 'input_name' => 'crowdfunding_campaign', 'terms_id' => 61],
        10 => ['name' => 'Film Budget under 2 million', 'filename' => 'Film Budget under 2 million', 'price' => 250, 'input_name' => 'film_budget_under_2000', 'terms_id' => 62],
        11 => ['name' => 'Film Independent', 'filename' => 'Film Independent', 'price' => 55, 'input_name' => 'film_independent', 'terms_id' => 64],
        12 => ['name' => 'Film over 2 million budget', 'filename' => 'Film over 2 million budget', 'price' => 5000, 'input_name' => 'film_budget_over_2000', 'terms_id' => 65],
        13 => ['name' => 'Video Game', 'filename' => 'Video Game', 'price' => 150, 'input_name' => 'video_game', 'terms_id' => 72],
        14 => ['name' => 'Exclusivity rights', 'filename' => 'Exclusivity rights', 'price' => 'POA', 'input_name' => 'exclusivity_rights', 'terms_id' => 73],
    ],

    'admins' => [
        'developer' => ['name' => 'Ahsan Hanif', 'user_id' => 627],
        'masteradmin' => ['name' => 'Master Admin', 'user_id' => 1],
        '1platformagent' => ['name' => 'Stuart Leadbetter', 'user_id' => 727],
    ],

    'cotysoAccounts' => [ 1 ],

    'clients_portal_database' => [
        'host' => '127.0.0.1',
        'username' => 'oneplatformmainuser',
        'password' => '6K3vQribvE*gp4nk',
        'database' => 'singingexperiencemain',
    ],

    'coupons' => [
        1 => ['name' => 'Platinum Coupon', 'id' => 'T9AARkDB', 'percent_off' => '100'],
        2 => ['name' => 'Gold Coupon', 'id' => 'tQadKKrj', 'percent_off' => '50'],
        3 => ['name' => 'Silver Coupon', 'id' => '6Hj4h6FW', 'percent_off' => '25'],
        4 => ['name' => 'Admin Coupon', 'id' => 'vv9dfNYR', 'percent_off' => '100'],
    ],
];
