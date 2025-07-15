<?php

namespace LLMSpeak\HuggingFace\Support\Facades;

use Illuminate\Support\Facades\Facade;
use LLMSpeak\HuggingFace\HF;
use LLMSpeak\HuggingFace\Repositories\HuggingFaceCompletionsAPIRepository;
use LLMSpeak\HuggingFace\Repositories\HuggingFaceFeatureExtractionAPIRepository;


/**
 * @method static string api_url()
 * @method static string embeddings_api_url()
 * @method static string api_key()
 * @method static HuggingFaceCompletionsAPIRepository completions()
 * @method static HuggingFaceFeatureExtractionAPIRepository embeddings()
 *
 * @see HF
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
