<?php

namespace LLMSpeak\HuggingFace\Repositories;

abstract class HuggingFaceAPIRepository
{
    protected ?string $api_key = null;

    public function withApikey(string $api_key): static
    {
        $this->api_key = $api_key;

        return $this;
    }
}
