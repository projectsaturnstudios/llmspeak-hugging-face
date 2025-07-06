<?php

namespace LLMSpeak\HuggingFace;

use Spatie\LaravelData\Data;

class HuggingFaceCallResult extends Data
{
    public function __construct(
        public readonly ?string $id = null,
        public readonly ?array $choices = null,
        public readonly string|int|null $created = null,
        public readonly ?string $model = null,
        public readonly ?string $object = null,
        public readonly ?string $service_tier = null,
        public readonly ?string $system_fingerprint = null,
        public readonly ?array $usage = null,
        public readonly ?array $prompt_logprobs = null,
    ) {}
}
