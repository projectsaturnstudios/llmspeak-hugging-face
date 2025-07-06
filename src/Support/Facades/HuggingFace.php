<?php

namespace LLMSpeak\HuggingFace\Support\Facades;

use Illuminate\Support\Facades\Facade;
use LLMSpeak\HuggingFace\Repositories\HuggingFaceCompletionsAPIRepository;


/**
 * @method static string api_url()
 * @method static string api_key()
 * @method static HuggingFaceCompletionsAPIRepository completions()
 */
class HuggingFace extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'hugging-face';
    }
}
