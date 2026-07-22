<?php

namespace App\Libraries;

/**
 * JwtHelper — Kelas terpusat untuk manajemen JWT Secret Key.
 *
 * [T1.2] Dibuat untuk menghilangkan hardcoded fallback JWT secret yang tersebar
 * di beberapa file (Auth.php, RoleFilter.php, SessionSecurityMiddleware.php).
 *
 * Referensi: OWASP Top 10 — A02: Cryptographic Failures.
 * Hardcoded secrets adalah penyebab umum kerentanan kriptografis.
 */
class JwtHelper
{
    /**
     * Mengambil JWT Secret Key dari environment variable.
     *
     * @throws \RuntimeException Jika JWT_SECRET tidak dikonfigurasi atau terlalu pendek.
     * @return string JWT Secret Key yang valid.
     */
    public static function getSecretKey(): string
    {
        $secret = getenv('JWT_SECRET');

        if (empty($secret) || strlen($secret) < 32) {
            log_message('critical', '[JwtHelper] JWT_SECRET environment variable is not set or is shorter than 32 characters. This is a critical security misconfiguration.');

            throw new \RuntimeException(
                'JWT_SECRET harus dikonfigurasi di file .env dengan minimal 32 karakter. ' .
                'Jalankan: php -r "echo bin2hex(random_bytes(32));" untuk generate secret yang aman.'
            );
        }

        return $secret;
    }

    /**
     * Generate JWT payload standar.
     *
     * @param array $user Data user dari database.
     * @param int   $expireSeconds Durasi token dalam detik (default: 3600 = 1 jam).
     * @return array Payload JWT yang siap di-encode.
     */
    public static function buildPayload(array $user, int $expireSeconds = 3600): array
    {
        return [
            'iat'     => time(),
            'exp'     => time() + $expireSeconds,
            'uid'     => $user['id'],
            'nomor'   => $user['nomor'],
            'nama'    => $user['nama'],
            'role_id' => $user['role_id'],
        ];
    }
}
