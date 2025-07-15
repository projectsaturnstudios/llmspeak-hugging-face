<?php

namespace LLMSpeak\HuggingFace\Repositories;

use LLMSpeak\HuggingFace\Actions\HuggingFaceAPI\FeatureExtraction\EmbeddingsEndpoint;
use LLMSpeak\HuggingFace\Support\Facades\HuggingFace;

class HuggingFaceFeatureExtractionAPIRepository extends HuggingFaceAPIRepository
{
    protected ?string $model = null;
    protected array|string|null $inputs = null;

    public function withModel(string $model): static
    {
        $this->model = $model;
        return $this;
    }

    public function withInputs(string|array $conversation): EmbeddingsEndpoint
    {
        $this->inputs = $conversation;
        return new EmbeddingsEndpoint(
            url: HuggingFace::embeddings_api_url(),
            api_key: $this->api_key,
            model: $this->model,
            inputs: $this->inputs,
        );
    }
}
