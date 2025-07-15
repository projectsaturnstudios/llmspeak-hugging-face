```php
use LLMSpeak\HuggingFace\Support\Facades\HuggingFace;

HuggingFace::completions() <--- HuggingFaceCompletionsAPIRepository Instance
    ->withApiKey($config['api_key']) <--- HuggingFaceCompletionsAPIRepository Instance
    ->withModel($model) <--- HuggingFaceCompletionsAPIRepository Instance
    ->withMaxTokens($max_tokens) <--- HuggingFaceCompletionsAPIRepository Instance
    ->withTools($temperature) <--- HuggingFaceCompletionsAPIRepository Instance
    ->withTemperature($temperature) <--- HuggingFaceCompletionsAPIRepository Instance
    ->withMessages($messages) <--- CompletionsEndpoint Instance
    ->handle();

HuggingFace::embeddings()
    ->withApikey(HuggingFace::api_key())
    ->withModel($model)
    ->withInputs($convo)
    ->handle();
```
