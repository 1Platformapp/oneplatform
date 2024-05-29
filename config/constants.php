<?php

return [

	'admin_email' => 'ahsanhanif99@gmail.com',

    'bcc_email' => 'admin@1platform.tv',

    'from_email' => env('MAIL_USERNAME', 'no-reply@1platform.tv'),

    'optimize_story_image' => 70,

    'optimize_music_image' => 70,

    'optimize_product_image' => 70,

    'optimize_bonus_image' => 70,

	'disclaimer' => '1Platform provides a platform for users to buy, sell, and collaborate. We are not responsible for any agreements made between users. Users should be cautious and diligent when interacting with others. By using our services, you agree that 1Platform cannot be held liable for any disputes, and you waive any right to take legal action against us.',

    'optimize_user_profile_image' => 70,

    'primaryDomain' => 'http://127.0.0.1',

    'singingExperienceDomain' => 'singingexperience.co.uk',

    'fcmServerKey' => 'AAAAbFFHXdQ:APA91bE3Rml-dYTML7hUd_R4v7ZB3gXAgfjVAUdi73e24W_Nbt49-bDz26hIMk1arpyXvYqwY8s4JK16z1bSxz4JwLYodnM60R571ihy_Hr0pPAN1Jabi0v8zFOJrcb0_vYWw1Q5aO0k',

    /* test mode keys */

    'stripe_connect_client_id' => 'ca_GZAYmx7yDVCxFQxA37Etr0uEJgEfJ8GE',

    'stripe_key_public' => 'pk_test_hbwueutzl74sMtTbdanyqDyD00GTC7p3uj',

    'stripe_key_secret' => 'sk_test_aa56k9tR6Qu0Cry961SDBIpE00oaIX79zb',

    'stripe_webhook_secret' => 'whsec_gp3yAdreYYMuGTgRfD7gQ6ms78S0dZSL',

    /* live mode keys */

    'stripe_live_key_public' => 'pk_live_YYOr7CPxmhxO0FTbNJijadCP00I83rZXtf',

    'stripe_live_key_secret' => 'sk_live_d7llFE6QfOeOCx2GsrX6VhEv00ZRmqygr9',

    'stripe_live_connect_client_id' => 'ca_GZAY0PeZmSmYp8ceOAqve1Xx0X7JSZW8',

    'stripe_live_webhook_secret' => 'whsec_q781By9Sowwy3H9fLUbJOVYkiYIHhwcO',

    /* other stripe keys */

    'stripe_payment_mode' => 'test',

    'stripe_connect_token_uri' => 'https://connect.stripe.com/oauth/token',

    'stripe_connect_authorize_uri' => 'https://connect.stripe.com/oauth/authorize',

    'stripe_platform_account_id' => 'acct_1G1y4hKVLFtbUew5',


    'facebook_profile' => 'https://www.facebook.com/1PlatformTV',

    'twitter_profile' => 'https://www.twitter.com/1PlatformTV',

    'instagram_profile' => 'https://www.instagram.com/1PlatformTV',

    'crowdfund_application_fee' => 5,

    'paypal_mode' => 'live',

    'paypal_api_uri' => 'https://api-m.paypal.com',

	'editor_tinycloud_api_key' => 'd411xqja9m1eb67vx71xjrmm433w7270l0ng73g7959dzlh5',

    //'paypal_mode' => 'sandbox',

    /* test mode plans */
    /*'user_internal_packages' => [
        0 => ['name' => 'silver', 'volume' => 2, 'application_fee' => 14, 'pricing' => ['month' => 0, 'year' => 0], 'plans' => ['month' => '', 'year' => '']],
        1 => ['name' => 'gold', 'volume' => 5, 'application_fee' => 0, 'pricing' => ['month' => 15, 'year' => 150], 'plans' => ['month' => 'plan_GvpknURF7L8Ard', 'year' => 'plan_GvpjjnaxsDNNBs']],
        2 => ['name' => 'platinum', 'volume' => 10, 'application_fee' => 0, 'pricing' => ['month' => 65, 'year' => 650], 'plans' => ['month' => 'plan_GvpiL6uWDjexAC', 'year' => 'plan_GvphF3EFx0lJUD']]
    ],*/

    /* live mode plans */
    'user_internal_packages' => [
        0 => ['name' => 'silver', 'volume' => 0.5, 'network_limit' => 10, 'application_fee' => 14, 'pricing' => ['month' => 0, 'year' => 0], 'plans' => ['month' => '', 'year' => '']],
        1 => ['name' => 'gold', 'volume' => 2, 'network_limit' => 100, 'application_fee' => 7, 'pricing' => ['month' => 15, 'year' => 150], 'plans' => ['month' => 'plan_GvpknURF7L8Ard', 'year' => 'plan_GvpjjnaxsDNNBs']],
        2 => ['name' => 'platinum', 'volume' => 5, 'network_limit' => 500, 'application_fee' => 2, 'pricing' => ['month' => 65, 'year' => 650], 'plans' => ['month' => 'plan_GvpiL6uWDjexAC', 'year' => 'plan_GvphF3EFx0lJUD']]
    ],

    'ffmpeg_path' => '/var/www/vhosts/1platform.tv/httpdocs/usr/bin/ffmpeg',

    'ffmpeg_decoded_path' => '/var/www/vhosts/1platform.tv/httpdocs/public/user-music-files/',

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

    'cotysoAccounts' => [ 765 ],

    'clients_portal_database' => [
        'host' => '127.0.0.1',
        'username' => 'oneplatformmainuser',
        'password' => '6K3vQribvE*gp4nk',
        'database' => 'singingexperiencemain',
    ],

    /* test mode coupons */
    /*'coupons' => [
        1 => ['name' => 'Platinum Coupon', 'id' => 'b5kqDXNz', 'percent_off' => '100'],
        2 => ['name' => 'Gold Coupon', 'id' => 'n8NuKSrC', 'percent_off' => '50'],
        3 => ['name' => 'Silver Coupon', 'id' => '6Hj4h6FW', 'percent_off' => '25'],
        4 => ['name' => 'Admin Coupon', 'id' => 'vv9dfNYR', 'percent_off' => '100'],
    ],*/

    /* live mode coupons */
    'coupons' => [
        1 => ['name' => 'Platinum Coupon', 'id' => 'r17E6Hri', 'percent_off' => '100'],
        2 => ['name' => 'Gold Coupon', 'id' => 'd178dW8A', 'percent_off' => '50'],
        3 => ['name' => 'Silver Coupon', 'id' => 'lWmP6VD5', 'percent_off' => '25'],
        4 => ['name' => 'Admin Coupon', 'id' => 'kSsC6Hr8', 'percent_off' => '100'],
    ],

    'skills' => [

        'Artist Manager',
        'Backing singer',
        'Band',
        'Duet act',
        'MC (rapper)',
        'Music producer',
        'Musician',
        'Network agency',
        'Network manager',
        'Orchestra (or part of)',
        'Producer',
        'Session musician',
        'Singer',
        'Singer / Songwriter',
        'Sound engineer',
        'Studio owner',
        'Trio act',
        'Promoter',
        'Publisher',
        'Lawyer',
        'Videographer',
        'Photographer',
        'Distributer',
        'Plugger',
        'Record Label',
        'Tour Event Manager',
        'Vocal Coach',
    ],
];
