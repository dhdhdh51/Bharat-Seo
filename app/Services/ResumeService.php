<?php
namespace App\Services;

use PDO;

final class ResumeService
{
    public function __construct(private PDO $db) {}

    public function create(int $userId, string $name, string $template = 'modern'): int
    {
        $token = bin2hex(random_bytes(24));
        $this->db->prepare('INSERT INTO resumes (user_id,name,template_key,public_token,created_at,updated_at) VALUES (?,?,?,?,NOW(),NOW())')->execute([$userId,$name,$template,$token]);
        $resumeId = (int)$this->db->lastInsertId();
        foreach (['summary','experience','skills','education','projects','certifications','languages'] as $i => $key) {
            $this->db->prepare('INSERT INTO resume_sections (resume_id,section_key,title,sort_order,content) VALUES (?,?,?,?,JSON_OBJECT())')->execute([$resumeId,$key,ucfirst($key),$i+1]);
        }
        return $resumeId;
    }

    public function snapshot(int $resumeId, string $source): void
    {
        $stmt = $this->db->prepare('SELECT * FROM resumes WHERE id=?');
        $stmt->execute([$resumeId]);
        $resume = $stmt->fetch() ?: [];
        $sections = $this->db->prepare('SELECT * FROM resume_sections WHERE resume_id=? ORDER BY sort_order');
        $sections->execute([$resumeId]);
        $this->db->prepare('INSERT INTO resume_versions (resume_id,snapshot,source,created_at) VALUES (?,?,?,NOW())')->execute([$resumeId, json_encode(['resume'=>$resume,'sections'=>$sections->fetchAll()]), $source]);
    }

    public function updateSectionOrder(int $resumeId, array $orderedKeys): void
    {
        foreach (array_values($orderedKeys) as $index => $key) {
            $this->db->prepare('UPDATE resume_sections SET sort_order=? WHERE resume_id=? AND section_key=?')->execute([$index+1,$resumeId,$key]);
        }
    }
}
