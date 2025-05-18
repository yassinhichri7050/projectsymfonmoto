<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ChatService
{
    private HttpClientInterface $client;
    private string $apiKey;

    public function __construct(HttpClientInterface $client, string $apiKey)
    {
        $this->client = $client;
        $this->apiKey = $apiKey;
    }

    public function askQuestion(string $question): string
    {
        $response = $this->client->request('POST', 'https://openrouter.ai/api/v1/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'model' => 'openai/gpt-3.5-turbo',
                'messages' => [
                    ['role' => 'user', 'content' => $question]
                ]
            ]
        ]);

        $data = $response->toArray(false);
        return $data['choices'][0]['message']['content'] ?? 'No response from AI.';
    }
}
