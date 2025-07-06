<?php

namespace LLMSpeak\HuggingFace\Enums;

enum HuggingFaceRole: string
{
    case USER = 'user';
    case ASSISTANT = 'assistant';
    case SYSTEM = 'system';
    case TOOL = 'tool';
}
