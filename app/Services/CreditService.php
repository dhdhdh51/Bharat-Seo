<?php
namespace App\Services;

use PDO;

final class CreditService
{
    public function __construct(private PDO $db) {}

    public function charge(int $userId, string $action, int $credits, string $idempotencyKey, ?int $providerId=null, ?string $model=null): bool
    {
        $this->db->beginTransaction();
        try {
            $exists = $this->db->prepare('SELECT id FROM ai_credit_transactions WHERE idempotency_key=?');
            $exists->execute([$idempotencyKey]);
            if ($exists->fetch()) { $this->db->commit(); return true; }
            $user = $this->db->prepare('SELECT ai_credits FROM users WHERE id=? FOR UPDATE');
            $user->execute([$userId]);
            $row = $user->fetch();
            if (!$row || (int)$row['ai_credits'] < $credits) { $this->db->rollBack(); return false; }
            $this->db->prepare('UPDATE users SET ai_credits=ai_credits-? WHERE id=?')->execute([$credits,$userId]);
            $this->db->prepare('INSERT INTO ai_credit_transactions (user_id,action,credits,idempotency_key,provider_id,model,created_at) VALUES (?,?,?,?,?,?,NOW())')->execute([$userId,$action,$credits,$idempotencyKey,$providerId,$model]);
            $this->db->commit();
            return true;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }
}
