<?php

return [
    /**
     * The url point to InsightVM/Nexpose API.
     * Do not include "api/v3", your url should look like "https://<host>:<port>".
     * For example: "https://127.0.0.1:3780"
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