<?php

  require 'lib/Stripe.php';

  define('CLIENT_ID', 'ca_9p45LAQoFUc47cE8Lrezf8QZU7JCWdh3');
  define('API_KEY', 'sk_test_rfANoBc8BWHgX9FdbglbgU5Z');
  define('TOKEN_URI', 'https://connect.stripe.com/oauth/token');
  define('AUTHORIZE_URI', 'https://connect.stripe.com/oauth/authorize');
  if (isset($_GET['code'])) { // Redirect w/ code
    $code = $_GET['code'];
    $token_request_body = array(
      'client_secret' => API_KEY,
      'grant_type' => 'authorization_code',
      'client_id' => CLIENT_ID,
      'code' => $code,
    );
    $req = curl_init(TOKEN_URI);
    curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($req, CURLOPT_POST, true );
    curl_setopt($req, CURLOPT_POSTFIELDS, http_build_query($token_request_body));
    // TODO: Additional error handling
    $respCode = curl_getinfo($req, CURLINFO_HTTP_CODE);
    $resp = json_decode(curl_exec($req), true);
    curl_close($req);


    //print_r ($resp);

    Stripe::setApiKey("sk_test_rfANoBc8BWHgX9FdbglbgU5Z");
    $charge = Stripe_Charge::create(array("amount" => 1000,
                                "currency" => "usd",
                                "source" => $resp['access_token']),
                          array('stripe_account' => $resp['stripe_user_id']));

    

    


  } else if (isset($_GET['error'])) { // Error
    echo $_GET['error_description'];
  } else { // Show OAuth link
    $authorize_request_body = array(
      'response_type' => 'code',
      'scope' => 'read_write',
      'client_id' => CLIENT_ID
    );
    $url = AUTHORIZE_URI . '?' . http_build_query($authorize_request_body);
    echo "<a href='$url'>Connect with Stripe</a>";
  }
?>