<?php

namespace App\Models;

use CodeIgniter\Model;

class AuthModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    
    protected $allowedFields = [
        'name',
        'email',
        'password',
        'picture',
        'created_at',
    ];
    // Check if email exists
    public function isEmailExists(string $email): bool
    {
        return $this->where('email', $email)->countAllResults() > 0;
    }

    // Update reset token
    public function updateResetToken(string $email, string $token, string $expiration): void
    {
        $this->update(['email' => $email], [
            'reset_token' => $token,
            'reset_token_expiration' => $expiration,
        ]);
    }

    // Save OTP
    public function saveOTP(string $email, string $OTP): bool
    {
        $data = [
            'email' => $email,
            'otp' => $OTP,
            'otp_expiration' => date('Y-m-d H:i:s', strtotime('+5 minutes')),
        ];

        // Delete existing records for the email (optional)
        $this->db->table('otp_codes')->where('email', $email)->delete();

        // Insert new OTP
        $this->db->table('otp_codes')->insert($data);
        return true;
    }

    // Login method
    public function login(string $email, string $password)
    {
        $user = $this->where('email', $email)->first();

        if ($user === null) {
            return false;
        }

        if (password_verify($password, $user['password'])) {
            unset($user['password']);
            unset($user['remember_token']);
            return $user;
        }

        return false;
    }

    // Update password
    public function updatePassword(string $email, string $password): void
    {
        $this->update(['email' => $email], [
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'reset_token' => null,
            'reset_token_expiration' => null,
        ]);
    }

    // Get user by reset token
    public function getUserByResetToken(string $token)
    {
        return $this->where('reset_token', $token)->first();
    }

    // Set remember token
    public function setRememberToken(int $id, string $token): void
    {
        $this->update($id, ['remember_token' => $token]);
    }

    // Get user by ID
    public function getUserById(int $id)
    {
        $user = $this->find($id);
        unset($user['password']);
        unset($user['remember_token']);
        return $user;
    }

    // Get user by token
    public function getUserByToken(string $token)
    {
        $user = $this->where('remember_token', $token)->first();
        unset($user['password']);
        unset($user['remember_token']);
        return $user;
    }

    // Reset remember token
    public function resetToken(int $user_id): void
    {
        $this->update($user_id, ['remember_token' => null]);
    }

    // Update profile
    public function updateProfile(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }
}
