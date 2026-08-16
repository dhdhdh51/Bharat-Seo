<?php
namespace App\Services;
final class ATSAnalyzer {
    public function analyze(array $resume, string $jobDescription=''): array {
        $text = strtolower(json_encode($resume).' '.$jobDescription);
        $checks = [
            'Contact Information'=>str_contains($text,'email') || str_contains($text,'phone') ? 12 : 4,
            'Section Structure'=>str_contains($text,'experience') && str_contains($text,'education') ? 14 : 6,
            'Skills'=>str_contains($text,'skills') ? 12 : 5,
            'Experience'=>str_contains($text,'company') || str_contains($text,'responsibilities') ? 14 : 6,
            'Education'=>str_contains($text,'degree') || str_contains($text,'institution') ? 10 : 5,
            'Readability'=>10,
            'Formatting'=>12,
            'Keywords'=>$jobDescription ? min(16, 6 + substr_count($text, ' ')/120) : 8,
        ];
        $score = min(100, (int)array_sum($checks));
        return ['score'=>$score,'categories'=>$checks,'strengths'=>['Clear sections improve parser readability.'],'issues'=>$score < 80 ? ['Add more job-specific keywords and measurable achievements.'] : [],'disclaimer'=>'Estimated optimization score only; it does not guarantee passing any real ATS.'];
    }
}
