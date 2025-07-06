<?php

namespace LLMSpeak\HuggingFace\Actions\Sagas\Chat\CompletionsEndpoint;

use Illuminate\Support\Facades\Http;
use ProjectSaturnStudios\PocketFlow\Node;
use Symfony\Component\VarDumper\VarDumper;

class HuggingFaceCompletionsEndpointNode extends Node
{
    public function __construct(protected string $url)
    {
        parent::__construct();
    }

    public function prep(mixed &$shared): mixed
    {
        return $shared['prepared_request'];
    }

    public function exec(mixed $prep_res): mixed
    {
        $response = Http::withHeaders($prep_res['headers'])->post($this->url, $prep_res['body']);
        VarDumper::dump(['HuggingFace Request - HuggingFaceCompletionsEndpointNode', json_encode($prep_res['body'])]);
        VarDumper::dump(['HuggingFace Results - HuggingFaceCompletionsEndpointNode', $response->json()]);
        return $response->json();
    }

    public function post(mixed &$shared, mixed $prep_res, mixed $exec_res): mixed
    {
        $shared['model_response'] = $exec_res;
        return 'wrap-up';
    }
}
