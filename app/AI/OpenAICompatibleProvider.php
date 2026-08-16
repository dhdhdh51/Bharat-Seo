<?php
namespace App\AI;
final class OpenAICompatibleProvider implements AIProviderInterface {
    public function __construct(private array $config) {}
    public function name(): string { return $this->config['name'] ?? 'OpenAI Compatible'; }
    public function generate(array $payload): AIResponse {
        $body = json_encode(['model'=>$this->config['model'],'messages'=>$payload['messages'],'temperature'=>(float)($this->config['temperature'] ?? 0.4),'max_tokens'=>(int)($this->config['max_tokens'] ?? 900)]);
        $ch = curl_init(rtrim($this->config['base_url'], '/') . '/chat/completions');
        curl_setopt_array($ch, [CURLOPT_POST=>true, CURLOPT_RETURNTRANSFER=>true, CURLOPT_TIMEOUT=>45, CURLOPT_HTTPHEADER=>['Content-Type: application/json','Authorization: Bearer '.$this->config['api_key']], CURLOPT_POSTFIELDS=>$body]);
        $start = microtime(true); $raw = curl_exec($ch); $error = curl_error($ch); $status = curl_getinfo($ch, CURLINFO_RESPONSE_CODE); curl_close($ch);
        if ($raw === false || $status >= 400) return new AIResponse(false, '', ['status'=>$status,'response_time_ms'=>(int)((microtime(true)-$start)*1000)], $error ?: 'Provider request failed');
        $json = json_decode($raw, true);
        return new AIResponse(true, $json['choices'][0]['message']['content'] ?? '', ['status'=>$status,'usage'=>$json['usage'] ?? [],'response_time_ms'=>(int)((microtime(true)-$start)*1000)]);
    }
}
