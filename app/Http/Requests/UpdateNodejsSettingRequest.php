<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNodejsSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'KEY_PATH' => 'required|max:100',
            'CERT_PATH' => 'required|max:100',
            'PORT' => 'required|string|min:2|max:4',
            'IP' => 'required|ip|max:15',
            'ANNOUNCED_IP' => 'nullable|ip|max:15',
            'RTC_MIN_PORT' => 'required|max:500',
            'RTC_MAX_PORT' => 'required|max:500',
            'AI_CHATBOT_API_KEY' => 'nullable|max:200',
            'AI_CHATBOT' => 'nullable|max:100',
            'AI_CHATBOT_MODEL' => 'nullable|max:100',
            'AI_CHATBOT_SECONDS' => 'nullable|string|max:3',
            'AI_CHATBOT_MESSAGE_LIMIT' => 'nullable|string|max:3',
            'AI_CHATBOT_MAX_CONVERSATION_LENGTH' => 'nullable|string|max:3',
        ];
    }

    public function attributes()
    {
        return [
            'KEY_PATH' => __('SSL Key Path'),
            'CERT_PATH' => __('SSL Certificate Path'),
            'PORT' => __('Port'),
            'IP' => __('IP Address'),
            'ANNOUNCED_IP' => __('Announced IP Address'),
            'RTC_MIN_PORT' => __('RTC Min Port'),
            'RTC_MAX_PORT' => __('RTC Max Port'),
            'AI_CHATBOT_API_KEY' => __('AI Chatbot API Key'),
            'AI_CHATBOT' => __('AI Chatbot'),
            'AI_CHATBOT_MODEL' => __('AI Chatbot Model'),
            'AI_CHATBOT_SECONDS' => __('AI Chatbot Seconds'),
            'AI_CHATBOT_MESSAGE_LIMIT' => __('AI Chatbot Message Limit'),
            'AI_CHATBOT_MAX_CONVERSATION_LENGTH' => __('AI Chatbot Maximum Conversation Length'),
        ];
    }
}