<?php

return [
    /*
    |--------------------------------------------------------------------------
    | HuggingFace API Key
    |--------------------------------------------------------------------------
    |
    | Here you may specify your HuggingFace API Key. This will be used to authenticate
    | with the HuggingFace API - you can find your API key on your HuggingFace
    | dashboard, at https://huggingface.co/settings/tokens.
    */

    'api_key' => env('HF_API_KEY', ''),

    /*
    |--------------------------------------------------------------------------
    | HuggingFace API URL
    |--------------------------------------------------------------------------
    |
    | Here you may specify the base URL for the Anthropic API. The default
    | is the official Anthropic API endpoint, but you can change it if needed.
    |
    |
    */

    'api_url' => env('HF_API_URL', 'https://router.huggingface.co/v1/'),
];
