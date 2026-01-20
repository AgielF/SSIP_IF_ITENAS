# Panduan Perbaikan Keamanan Login

## Masalah Keamanan yang Ditemukan

1. **Password Plain Text**: Password disimpan dan diverifikasi tanpa hashing
2. **Encryption Key Kosong**: Key enkripsi belum diatur
3. **JWT Secret Default**: Menggunakan secret key default
4. **Tidak Ada Rate Limiting**: Rentan terhadap brute force attacks
5. **Tidak Ada Account Lockout**: Tidak ada mekanisme lock setelah failed attempts

## Langkah Perbaikan

### 1. Konfigurasi Environment Variables

Tambahkan ke file `.env`:

```env
# Encryption Key (generate random 32-character string)
app.encryption.key = "your-32-character-random-key-here"

# JWT Secret (generate random 64-character string)
JWT_SECRET = "your-64-character-random-jwt-secret-here"
```

**Cara generate key:**
- Gunakan command: `php -r "echo bin2hex(random_bytes(32));"` untuk encryption key
- Gunakan command: `php -r "echo bin2hex(random_bytes(64));"` untuk JWT secret

### 2. Update UserModel untuk Password Hashing

Tambahkan method berikut ke `app/Models/UserModel.php`:

```php
<?php
// ... existing code ...

class UserModel extends Model
{
    // ... existing properties and methods ...

    /**
     * Hash password sebelum save
     */
    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {
            $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    /**
     * Verify password
     */
    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    // Hook untuk auto-hash password saat insert/update
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];
}
```

### 3. Update Auth Controller

Modifikasi `app/Controllers/Api/Auth.php` method login:

```php
public function login()
{
    try {
        $nomor    = $this->request->getPost('nomor');
        $password = $this->request->getPost('password');

        if (!$nomor || !$password) {
            return redirect()->back()->with('error', 'Nomor dan password harus diisi');
        }

        $user = $this->userModel->where('nomor', $nomor)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        // Ganti pengecekan plain text dengan verify hash
        if (!$this->userModel->verifyPassword($password, $user['password'])) {
            return redirect()->back()->with('error', 'Password salah');
        }

        // Generate JWT dengan secret dari env
        $key = getenv('JWT_SECRET');
        if (!$key) {
            throw new \Exception('JWT_SECRET tidak dikonfigurasi');
        }

        $payload = [
            'iat'     => time(),
            'exp'     => time() + 86400, // 24 jam
            'uid'     => $user['id'],
            'nomor'   => $user['nomor'],
            'nama'    => $user['nama'],
            'role_id' => $user['role_id']
        ];
        $token = JWT::encode($payload, $key, 'HS256');

        // Simpan token ke session
        session()->set('token', $token);
        session()->set('user', [
            'id'      => $user['id'],
            'nomor'   => $user['nomor'],
            'nama'    => $user['nama'],
            'role_id' => $user['role_id']
        ]);

        // Redirect sesuai role
        if ($user['role_id'] == 1) {
            return redirect()->to('/asisten_admin');
        } else {
            return redirect()->to('/dashboard');
        }

    } catch (\Throwable $e) {
        return redirect()->back()->with('error', 'Login gagal: ' . $e->getMessage());
    }
}
```

### 4. Update Encryption Config

Update `app/Config/Encryption.php`:

```php
public string $key = ''; // Kosongkan, akan menggunakan dari .env
```

Dan pastikan di bootstrap atau service provider, key di-load dari env.

### 5. Tambahkan Rate Limiting (Opsional)

Buat middleware untuk rate limiting:

`app/Middleware/RateLimitMiddleware.php`:

```php
<?php

namespace App\Middleware;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Middleware\BaseMiddleware;

class RateLimitMiddleware extends BaseMiddleware
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $ip = $request->getIPAddress();
        $key = 'login_attempts_' . $ip;

        $attempts = session()->get($key) ?? 0;

        if ($attempts >= 5) {
            return redirect()->back()->with('error', 'Terlalu banyak percobaan login. Coba lagi nanti.');
        }

        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Increment attempts on failed login
        if ($response->getStatusCode() === 302 && session()->getFlashdata('error')) {
            $ip = $request->getIPAddress();
            $key = 'login_attempts_' . $ip;
            $attempts = session()->get($key) ?? 0;
            session()->set($key, $attempts + 1);
        }
    }
}
```

### 6. Migrasi Password Existing

Buat migration untuk hash password yang sudah ada:

`app/Database/Migrations/2025_10_03_000000_HashExistingPasswords.php`:

```php
<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class HashExistingPasswords extends Migration
{
    public function up()
    {
        $users = $this->db->table('users')->get()->getResultArray();

        foreach ($users as $user) {
            if (!password_get_info($user['password'])['algo']) {
                // Password belum di-hash
                $hashed = password_hash($user['password'], PASSWORD_DEFAULT);
                $this->db->table('users')
                         ->where('id', $user['id'])
                         ->update(['password' => $hashed]);
            }
        }
    }

    public function down()
    {
        // Tidak bisa rollback hashing
    }
}
```

### 7. Testing

Setelah implementasi, test:

1. Login dengan password lama (harus masih work jika belum di-hash ulang)
2. Register user baru (password harus ter-hash)
3. Coba login dengan password salah beberapa kali
4. Verifikasi JWT token valid
5. Test logout

### 8. Best Practices Tambahan

1. **HTTPS Only**: Pastikan semua traffic menggunakan HTTPS
2. **Secure Cookies**: Set cookie flags secure dan httpOnly
3. **Password Policy**: Implementasi kebijakan password kuat
4. **Logging**: Log semua login attempts untuk monitoring
5. **2FA**: Pertimbangkan implementasi Two-Factor Authentication

## Checklist Implementasi

- [ ] Set encryption key di .env
- [ ] Set JWT secret di .env
- [ ] Update UserModel dengan password hashing
- [ ] Update Auth controller untuk verify hash
- [ ] Run migration untuk hash password existing
- [ ] Test login functionality
- [ ] Implement rate limiting (opsional)
- [ ] Enable HTTPS
- [ ] Add secure cookie flags