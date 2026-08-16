<?php
namespace App\AI;
use PDO;
final class AIManager {
    public function __construct(private PDO $db, private string $appKey) {}
    public function run(string $requestType, array $messages, ?int $userId=null, ?string $idempotencyKey=null): AIResponse {
        $providers = $this->db->query("SELECT * FROM ai_providers WHERE active=1 ORDER BY priority ASC, id ASC")->fetchAll();
        $last = new AIResponse(false, '', [], 'No active AI provider is configured.');
        foreach ($providers as $provider) {
            $apiKey = \App\Helpers\Security::decryptSecret($provider['api_key_encrypted'], $this->appKey);
            $client = new OpenAICompatibleProvider(['name'=>$provider['name'],'base_url'=>$provider['base_url'],'api_key'=>$apiKey,'model'=>$provider['model'],'temperature'=>$provider['temperature'],'max_tokens'=>$provider['max_tokens']]);
            $result = $client->generate(['messages'=>$messages]);
            $stmt = $this->db->prepare("INSERT INTO ai_logs (user_id, provider_id, model, request_type, success, error_message, response_time_ms, created_at) VALUES (?,?,?,?,?,?,?,NOW())");
            $stmt->execute([$userId, $provider['id'], $provider['model'], $requestType, $result->success ? 1 : 0, $result->error, $result->meta['response_time_ms'] ?? null]);
            if ($result->success) return $result;
            $last = $result;
        }
        return $last;
    }
}
