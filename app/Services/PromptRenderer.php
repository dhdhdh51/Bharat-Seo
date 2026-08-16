<?php
namespace App\Services;

final class PromptRenderer
{
    public function render(string $template, array $variables): string
    {
        return preg_replace_callback('/{{\s*([a-zA-Z0-9_]+)\s*}}/', fn($m) => (string)($variables[$m[1]] ?? ''), $template);
    }
}
