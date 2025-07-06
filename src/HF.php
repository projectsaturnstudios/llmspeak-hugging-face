<?php

namespace LLMSpeak\HuggingFace;

use LLMSpeak\HuggingFace\Repositories\HuggingFaceCompletionsAPIRepository;

class HF
{
    public function __construct(protected array $config)
    {

    }

    public function completions(): HuggingFaceCompletionsAPIRepository
    {
        return new HuggingFaceCompletionsAPIRepository;
    }

    public function api_url(): string
    {
        return $this->config['api_url'] ?? 'https://router.huggingface.co/v1/';
    }

    public function api_key(): string
    {
        return $this->config['api_key'];
    }

    public static function boot(): void
    {
        app()->singleton('hugging-face', function () {
            $results = new static(config('llms.services.hugging-face'));

            return $results;
        });
    }
}
