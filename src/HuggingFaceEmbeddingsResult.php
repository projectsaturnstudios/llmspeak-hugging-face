<?php

namespace LLMSpeak\HuggingFace;

use Spatie\LaravelData\Data;

class HuggingFaceEmbeddingsResult extends Data
{
    public function __construct(
        public readonly ?array $embeddings
    ) {}
}
