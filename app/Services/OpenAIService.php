<?php

namespace App\Services;

use GuzzleHttp\Client;

class OpenAIService
{
    protected $client;
    protected $apiKey;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = env('OPENAI_API_KEY');
    }

    public function generatePostContent($prompt) {
        try {
            // Update the prompt to specify that only content-related tags should be returned
            $response = $this->client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-3.5-turbo',  // You can replace this with 'gpt-4' if needed
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                        ['role' => 'user', 'content' => $prompt . '. Please generate the blog content in plain HTML (with <p>, <h1>, and <ul> tags only) without the full document structure (like <!DOCTYPE> and <html>).']
                    ],
                    'max_tokens' => 1024,
                    'temperature' => 0.7,
                ],
            ]);
    
            $data = json_decode($response->getBody(), true);
            return $data['choices'][0]['message']['content'] ?? 'No content generated';
        } catch (\Exception $e) {
            \Log::error('Error calling OpenAI API: ' . $e->getMessage());
            return 'Error: ' . $e->getMessage();
        }
    }

    public function generatePostImage($prompt) {
        try {
            // Call the correct OpenAI API endpoint for image generation
            $response = $this->client->post('https://api.openai.com/v1/images/generations', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,  // Authorization with API key
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'prompt' => $prompt,
                    'n' => 1,  // Number of images to generate
                    'size' => '1024x1024',  // Image size
                ],
            ]);
    
            // Return the image URL from the API response
            $data = json_decode($response->getBody(), true);
            return $data['data'][0]['url'];
        } catch (\Exception $e) {
            \Log::error('Error generating image: ' . $e->getMessage());
            return null;  // Return null or a fallback image if the image generation fails
        }
    }
    
    
}
