<?php

namespace LLMSpeak\HuggingFace\Builders;

use LLMSpeak\HuggingFace\Enums\HuggingFaceRole;

class ConversationBuilder
{
    protected array $conversation = [];

    public function addText(HuggingFaceRole $role, string $content): static
    {
        $this->conversation[] = [
            'role' => $role->value,
            'content' => $content,
        ];

        return $this;
    }

    public function addToolRequest(string $id, string $name, array $input): static
    {
        $this->conversation[] = [
            'role' => 'assistant',
            'content' => '',
            'tool_calls' => [
                [
                    'id' => $id,
                    'type' => 'function',
                    'function' => [
                        'name' => $name,
                        'arguments' => json_encode($input)
                    ]
                ]
            ]
        ];
        return $this;
    }

    public function addToolResult(string $id, string $name, mixed $content): static
    {
        $this->conversation[] = [
            'tool_call_id' => $id,
            'role' => 'tool',
            'name' => $name,
            'content' => is_array($content) ? json_encode($content) : $content
        ];
        return $this;
    }

    public function render(): array
    {
        return $this->conversation;
    }
}
