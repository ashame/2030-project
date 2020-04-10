<?php

require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") { 

    $chObj = curl_init();
    curl_setopt($chObj, CURLOPT_URL, "https://api.yelp.com/v3/graphql");
    curl_setopt($chObj, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($chObj, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($chObj, CURLOPT_VERBOSE, true);
    curl_setopt($chObj, CURLOPT_POSTFIELDS, $_POST['query']);
    curl_setopt(
        $chObj,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/graphql',
            'Authorization: bearer ' . APIKEY
        )
    );

    $response = curl_exec($chObj);
    
    echo $response;
}

?>