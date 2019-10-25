<?php

return [
    /**
     * The url point to InsightVM/Nexpose API.
     * Your url should look like "https://<host>:<port>/api/3/".
     * For example: "https://127.0.0.1:3780/api/3/"
     */
    'url' => env('INSIGHTVM_URL', null),

    /**
     * The username/password for InsightVM/Nexpose login
     */
    'username' => env('INSIGHTVM_USERNAME'),
    'password' => env('INSIGHTVM_PASSWORD'),

    /**
     * If the account above has enabled OTP, please set key here.
     */
    'token' => env('INSIGHTVM_OTP_TOKEN', null),

];
