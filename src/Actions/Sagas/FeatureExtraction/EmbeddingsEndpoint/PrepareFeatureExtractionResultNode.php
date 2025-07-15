<?php

namespace LLMSpeak\HuggingFace\Actions\Sagas\FeatureExtraction\EmbeddingsEndpoint;

use LLMSpeak\HuggingFace\HuggingFaceCallResult;
use LLMSpeak\HuggingFace\HuggingFaceEmbeddingsResult;
use ProjectSaturnStudios\PocketFlow\Node;

class PrepareFeatureExtractionResultNode extends Node
{
    public function prep(mixed &$shared): mixed
    {
        return $shared['model_response'];
    }

    public function exec(mixed $prep_res): mixed
    {
        return new HuggingFaceEmbeddingsResult($prep_res);
    }

    public function post(mixed &$shared, mixed $prep_res, mixed $exec_res): mixed
    {
        $shared = $exec_res;
        return 'finished';
    }
}
