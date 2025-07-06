<?php

namespace LLMSpeak\HuggingFace\Actions\Sagas\Chat\CompletionsEndpoint;

use ProjectSaturnStudios\PocketFlow\Node;

class PrepareChatCompletionsRequestNode extends Node
{
    public function prep(mixed &$shared): mixed
    {
        return $shared['available_parameters'];
    }

    public function exec(mixed $prep_res): mixed
    {
        $results = [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'body' => [],
        ];

        if(array_key_exists('api_key', $prep_res)) $results['headers']['Authorization'] = "Bearer {$prep_res['api_key']}";
        else throw new \InvalidArgumentException('API key is required for the request.');

        if(array_key_exists('model', $prep_res)) $results['body']['model'] = $prep_res['model'];
        else throw new \InvalidArgumentException('Model is required for the request.');

        if(array_key_exists('max_tokens', $prep_res)) $results['body']['max_tokens'] = $prep_res['max_tokens'];
        else throw new \InvalidArgumentException('Max tokens is required for the request.');

        if(array_key_exists('messages', $prep_res)) $results['body']['messages'] = $prep_res['messages'];
        else throw new \InvalidArgumentException('Messages are required for the request.');

        if(array_key_exists('tools', $prep_res) && (!empty($prep_res['tools']))) $results['body']['tools'] = $prep_res['tools'];
        if(array_key_exists('temperature', $prep_res) && (!empty($prep_res['temperature']))) $results['body']['temperature'] = $prep_res['temperature'];

        return $results;
    }

    public function post(mixed &$shared, mixed $prep_res, mixed $exec_res): mixed
    {
        $shared['prepared_request'] = $exec_res;
        return 'call';
    }
}
