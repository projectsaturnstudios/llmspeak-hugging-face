<?php

namespace LLMSpeak\HuggingFace\Repositories;

use LLMSpeak\HuggingFace\Support\Facades\HuggingFace;
use LLMSpeak\HuggingFace\Actions\HuggingFaceAPI\Chat\CompletionsEndpoint;

class HuggingFaceCompletionsAPIRepository extends HuggingFaceAPIRepository
{
    protected ?string $model = null;
    protected ?int $max_tokens = null;
    protected ?array $messages = null;
    protected ?array $tools = null;
    protected ?float $temperature = null;

    public function withModel(string $model): static
    {
        $this->model = $model;
        return $this;
    }

    public function withMaxTokens(int $tokens): static
    {
        $this->max_tokens = $tokens;
        return $this;
    }

    public function withMessages(array $conversation): CompletionsEndpoint
    {
        $this->messages = $conversation;
        return new CompletionsEndpoint(
            url: HuggingFace::api_url(),
            api_key: $this->api_key,
            model: $this->model,
            max_tokens: $this->max_tokens,
            messages: $this->messages,
            tools: $this->tools,
            temperature: $this->temperature
        );
    }


    public function withTools(array $tools): static
    {
        $this->tools = $tools;
        return $this;
    }

    public function withTemperature(float $temperature): static
    {
        $this->temperature = $temperature;
        return $this;
    }
}
