<?php
use App\Core\App;
use App\Core\Response;

$path = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/', '/') ?: '/';
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true) ?: [];

try {
    if ($path === '/api/ats' && $method === 'POST') {
        $ats = new \App\Services\ATSAnalyzer();
        Response::json(true, 'ATS scan completed.', $ats->analyze($input['resume'] ?? [], $input['job_description'] ?? ''));
        return;
    }
    if ($path === '/api/job/analyze' && $method === 'POST') {
        $text = strtolower($input['job_description'] ?? '');
        $keywords = array_values(array_unique(array_filter(preg_split('/[^a-z0-9+#.]+/i', $text), fn($w) => strlen($w) > 3)));
        Response::json(true, 'Job description analyzed.', [
            'job_title'=>$input['job_title'] ?? 'Review required',
            'keywords'=>array_slice($keywords, 0, 30),
            'missing_keywords'=>[],
            'recommendations'=>['Review extracted keywords before applying them to your CV.', 'Add only skills and achievements that are true.'],
        ]);
        return;
    }
    if ($path === '/api/ai' && $method === 'POST') {
        Response::json(false, 'AI provider is not configured yet. Add a provider in Admin > AI Providers before using generation tools.', [], 503);
        return;
    }
    Response::json(false, 'Endpoint not found.', [], 404);
} catch (Throwable $e) {
    error_log($e->getMessage());
    Response::json(false, 'Something went wrong. Please try again.', [], 500);
}
