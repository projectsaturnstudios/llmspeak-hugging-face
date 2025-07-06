<?php

namespace LLMSpeak\HuggingFace\Providers;

use Illuminate\Support\ServiceProvider;
use LLMSpeak\HuggingFace\HF;

class HuggingFaceLLMSpeakServiceProvider extends ServiceProvider
{
    protected array $config = [
        'llms.services.hugging-face' => __DIR__ .'/../../config/llms/hugging-face.php',
    ];

    public function register(): void
    {
        $this->registerConfigs();
    }

    public function boot(): void
    {
         $this->publishConfigs();
         HF::boot();
    }

    protected function publishConfigs() : void
    {
        $this->publishes([
            $this->config['llms.services.hugging-face'] => config_path('llms/hugging-face.php'),
        ], ['llms', 'llms.hugging-face']);
    }

    protected function registerConfigs() : void
    {
        foreach ($this->config as $key => $path) {
            $this->mergeConfigFrom($path, $key);
        }
    }

}
