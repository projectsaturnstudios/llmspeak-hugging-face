<?php

namespace LLMSpeak\HuggingFace\Actions\HuggingFaceAPI\FeatureExtraction;

use LLMSpeak\HuggingFace\Actions\Sagas\FeatureExtraction\EmbeddingsEndpoint\HuggingFaceEmbeddingsEndpointNode;
use LLMSpeak\HuggingFace\Actions\Sagas\FeatureExtraction\EmbeddingsEndpoint\PrepareFeatureExtractionRequestNode;
use LLMSpeak\HuggingFace\Actions\Sagas\FeatureExtraction\EmbeddingsEndpoint\PrepareFeatureExtractionResultNode;
use LLMSpeak\HuggingFace\Builders\EmbeddingQueryBuilder;
use LLMSpeak\HuggingFace\HuggingFaceEmbeddingsResult;
use LLMSpeak\HuggingFace\Support\Facades\HuggingFace;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\LaravelData\Data;

class EmbeddingsEndpoint extends Data
{
    use AsAction;

    public function __construct(
        public readonly string $url,
        public readonly string $api_key,
        public readonly string $model,
        public readonly string|array $inputs,
    ) {}

    public function handle(): HuggingFaceEmbeddingsResult
    {
        $work_nodes = new PrepareFeatureExtractionRequestNode;
        $work_nodes->next(new HuggingFaceEmbeddingsEndpointNode("{$this->url}"), 'call')
            ->next(new PrepareFeatureExtractionResultNode, 'wrap-up');

        $shared = [
            'available_parameters' => $this->toArray()
        ];

        return flow($work_nodes, $shared);
    }

    public static function test(): HuggingFaceEmbeddingsResult
    {
        $convo = (new EmbeddingQueryBuilder())
            ->addQuery("What happens if I get pulled over for speeding?")
            ->render();

        return HuggingFace::embeddings()
            ->withApikey(HuggingFace::api_key())
            ->withModel('Qwen/Qwen3-Embedding-8B')
            ->withInputs($convo)
            ->handle();
    }

    public static function test2(): HuggingFaceEmbeddingsResult
    {
        $convo = (new EmbeddingQueryBuilder())
            ->addQuery("What happens if I get pulled over for speeding?")
            ->addQuery("If I go to jail do I get my one phone call?")
            ->render();

        return HuggingFace::embeddings()
            ->withApikey(HuggingFace::api_key())
            ->withModel('Qwen/Qwen3-Embedding-8B')
            ->withInputs($convo)
            ->handle();
    }
}
