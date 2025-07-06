<?php

namespace LLMSpeak\HuggingFace\Actions\HuggingFaceAPI\Chat;

use LLMSpeak\HuggingFace\Actions\Sagas\Chat\CompletionsEndpoint\HuggingFaceCompletionsEndpointNode;
use LLMSpeak\HuggingFace\Actions\Sagas\Chat\CompletionsEndpoint\PrepareChatCompletionsRequestNode;
use LLMSpeak\HuggingFace\Actions\Sagas\Chat\CompletionsEndpoint\PrepareChatCompletionsResultNode;
use LLMSpeak\HuggingFace\Builders\ConversationBuilder;
use LLMSpeak\HuggingFace\Enums\HuggingFaceRole;
use LLMSpeak\HuggingFace\HuggingFaceCallResult;
use LLMSpeak\HuggingFace\Support\Facades\HuggingFace;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\LaravelData\Data;

class CompletionsEndpoint extends Data
{
    use AsAction;

    protected string $uri = 'chat/completions';

    public function __construct(
        public readonly string $url,
        public readonly string $api_key,
        public readonly string $model,
        public readonly int $max_tokens,
        public readonly array $messages,
        public readonly ?array $tools = null,
        public readonly ?float $temperature = null,
    ) {}

    public function handle(): HuggingFaceCallResult
    {
        $work_nodes = new PrepareChatCompletionsRequestNode;
        $work_nodes->next(new HuggingFaceCompletionsEndpointNode("{$this->url}{$this->uri}"), 'call')
            ->next(new PrepareChatCompletionsResultNode, 'wrap-up');

        $shared = [
            'available_parameters' => $this->toArray()
        ];

        return flow($work_nodes, $shared);
    }

    public static function test(): HuggingFaceCallResult
    {
        $convo = (new ConversationBuilder())
            ->addText(HuggingFaceRole::SYSTEM, 'You are an astrophysicist. You don\'t have time for my small talk. Keep your answers to less than 20 words')
            ->addText(HuggingFaceRole::USER, '')
            ->addText(HuggingFaceRole::ASSISTANT, 'Yes?')
            ->addText(HuggingFaceRole::USER, 'What is the sky blue?')
            ->render();

        return HuggingFace::completions()
            ->withApikey(HuggingFace::api_key())
            ->withModel('meta-llama/llama-3.2-3b-instruct')
            ->withMaxTokens(500)
            ->withTemperature(0.1125478)
            ->withMessages($convo)
            ->handle();
    }

    public static function test2(): HuggingFaceCallResult
    {
        $convo = (new ConversationBuilder())
            ->addText(HuggingFaceRole::SYSTEM, 'You love to use tools.')
            ->addText(HuggingFaceRole::USER, '')
            ->addText(HuggingFaceRole::ASSISTANT, 'Hi!?')
            ->addText(HuggingFaceRole::USER, 'Say something funny with the echo tool.')
            ->render();

        $tools = [
            [
                'type' => 'function',
                'function' => [
                    "name" => "echo",
                    "description" => "Echoes back the request data for testing purposes",
                    "parameters" => [
                        "type" => "object",
                        "properties" => [
                            "intended_output" => [
                                "type" => "string",
                                "description" => "The intended output of the echo.",
                            ],
                        ],
                        "required" => [
                            "intended_output",
                        ],
                    ]
                ],
            ]
        ];

        return HuggingFace::completions()
            ->withApikey(HuggingFace::api_key())
            ->withModel('meta-llama/llama-3.2-3b-instruct')
            ->withTemperature(0.1125478)
            ->withMaxTokens(500)
            ->withTools($tools)
            ->withMessages($convo)
            ->handle();
    }

    public static function test3(): HuggingFaceCallResult
    {
        $convo = (new ConversationBuilder())
            ->addText(HuggingFaceRole::SYSTEM, 'You love to use tools.')
            ->addText(HuggingFaceRole::USER, '')
            ->addText(HuggingFaceRole::ASSISTANT, 'Hi!?')
            ->addText(HuggingFaceRole::USER, 'Say something funny with the echo tool.')
            ->addToolRequest('chatcmpl-tool-30b0cf146b9447d1adfd9101d7f743b6', 'echo', ['intended_output' => "I told my wife she was drawing her eyebrows too high. She looked surprised."])
            ->addToolResult('chatcmpl-tool-30b0cf146b9447d1adfd9101d7f743b6',  ['output' => "I told my wife she was drawing her eyebrows too high. She looked surprised."])
            ->render();

        $tools = [
            [
                'type' => 'function',
                'function' => [
                    "name" => "echo",
                    "description" => "Echoes back the request data for testing purposes",
                    "parameters" => [
                        "type" => "object",
                        "properties" => [
                            "intended_output" => [
                                "type" => "string",
                                "description" => "The intended output of the echo.",
                            ],
                        ],
                        "required" => [
                            "intended_output",
                        ],
                    ]
                ],
            ]
        ];

        return HuggingFace::completions()
            ->withApikey(HuggingFace::api_key())
            ->withModel('meta-llama/llama-3.2-3b-instruct')
            ->withTemperature(0.1125478)
            ->withMaxTokens(500)
            ->withMessages($convo)
            ->handle();
    }
}
