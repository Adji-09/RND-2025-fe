<?php

return [
    'lang'              => 'en',
    'server-get-config' => false,
    'id'                => env('GEETEST_ID'),
    'key'               => env('GEETEST_KEY'),
    'url'               => '/geetest',
    'protocol'          => 'http',
    'product'           => 'float',
    'client_fail_alert' => 'Please complete the verification code correctly',
    'server_fail_alert' => 'The verification code failed to be verified',
];
