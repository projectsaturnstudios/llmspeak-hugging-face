<?php

namespace LLMSpeak\HuggingFace\Actions\Sagas\FeatureExtraction\EmbeddingsEndpoint;

use ProjectSaturnStudios\PocketFlow\Node;

class PrepareFeatureExtractionRequestNode extends Node
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

        if(array_key_exists('inputs', $prep_res)) is_array($prep_res['inputs']) ? $results['body']['input'] = $prep_res['inputs'] : $results['body']['input'] = $prep_res['inputs'];
        else throw new \InvalidArgumentException('Inputs are required for the request.');

        return $results;
    }

    public function post(mixed &$shared, mixed $prep_res, mixed $exec_res): mixed
    {
        $shared['prepared_request'] = $exec_res;
        return 'call';
    }
}
