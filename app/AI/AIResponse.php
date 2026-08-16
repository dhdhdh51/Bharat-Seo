<?php
namespace App\AI;
final class AIResponse {
    public function __construct(public bool $success, public string $content='', public array $meta=[], public ?string $error=null) {}
}
