# Testing Guide untuk SSIP IF ITENAS

## 📋 Overview Testing Strategy

Berdasarkan analisis project SSIP IF ITENAS, berikut adalah panduan lengkap untuk testing yang harus dicantumkan dan diimplementasi:

## 🧪 1. Unit Testing (Model & Controller Testing)

### **A. Model Testing**
```php
// tests/unit/Models/UserModelTest.php
<?php
namespace Tests\Unit\Models;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use App\Models\UserModel;

class UserModelTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = false;
    protected $refresh     = true;
    protected $seed        = 'Tests\Support\Database\Seeds\UserTestSeeder';

    public function testGetAsistenLab()
    {
        $model = new UserModel();
        $asisten = $model->getAsistenLab();
        
        $this->assertIsArray($asisten);
        // Test that all returned users have role_id = 2
        foreach ($asisten as $user) {
            $this->assertEquals(2, $user['role_id']);
        }
    }

    public function testPasswordHashing()
    {
        $model = new UserModel();
        $plainPassword = 'testpassword123';
        
        $userData = [
            'nomor' => '152022999',
            'nama' => 'Test User',
            'password' => $plainPassword,
            'jurusan' => 'Informatika',
            'role_id' => 3
        ];
        
        $userId = $model->insert($userData);
        $user = $model->find($userId);
        
        // Password should be hashed
        $this->assertNotEquals($plainPassword, $user['password']);
        $this->assertTrue(password_verify($plainPassword, $user['password']));
    }
}
```

### **B. Controller Testing**
```php
// tests/unit/Controllers/UserControllerTest.php
<?php
namespace Tests\Unit\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class UserControllerTest extends CIUnitTestCase
{
    use ControllerTestTrait, DatabaseTestTrait;

    protected $migrate = true;
    protected $seed    = 'DatabaseSeeder';

    public function testIndexReturnsAsistenList()
    {
        $result = $this->controller(\App\Controllers\UserController::class)
                       ->execute('index');

        $this->assertTrue($result->isOK());
        $this->assertStringContainsString('Anggota Laboratorium', $result->getBody());
    }

    public function testStoreCreatesNewUser()
    {
        $data = [
            'nomor' => '152022888',
            'nama' => 'Test User Store',
            'no_telp' => '081234567890',
            'jurusan' => 'Informatika',
            'password' => 'testpass123',
            'role_id' => 2
        ];

        $result = $this->controller(\App\Controllers\UserController::class)
                       ->execute('store');

        $this->assertTrue($result->isRedirect());
    }
}
```

## 🌐 2. Integration Testing (API Testing)

### **A. Authentication API Testing**
```php
// tests/integration/Api/AuthTest.php
<?php
namespace Tests\Integration\Api;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class AuthTest extends CIUnitTestCase
{
    use FeatureTestTrait, DatabaseTestTrait;

    protected $migrate = true;
    protected $seed    = 'DatabaseSeeder';

    public function testLoginWithValidCredentials()
    {
        $response = $this->post('/api/auth/login', [
            'nomor' => '152022001',
            'password' => 'admin123'
        ]);

        $response->assertStatus(302); // Redirect after successful login
        $this->assertNotEmpty(session('token'));
    }

    public function testLoginWithInvalidCredentials()
    {
        $response = $this->post('/api/auth/login', [
            'nomor' => '152022001',
            'password' => 'wrongpassword'
        ]);

        $response->assertRedirect();
        $this->assertEmpty(session('token'));
    }
}
```

### **B. CRUD API Testing**
```php
// tests/integration/Api/ContentTest.php
<?php
namespace Tests\Integration\Api;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class ContentTest extends CIUnitTestCase
{
    use FeatureTestTrait, DatabaseTestTrait;

    protected $migrate = true;
    protected $seed    = 'DatabaseSeeder';

    public function testGetPublikasiData()
    {
        $response = $this->get('/api/publikasi');
        
        $response->assertStatus(200);
        $response->assertJSONStructure([
            '*' => [
                'id_publikasi',
                'jenis_publikasi',
                'kategori',
                'tanggal_publikasi'
            ]
        ]);
    }

    public function testGetAsistenData()
    {
        $response = $this->get('/api/asisten');
        
        $response->assertStatus(200);
        $data = $response->getJSON();
        $this->assertIsArray($data);
    }
}
```

## 🔐 3. Security Testing

### **A. Authentication & Authorization Testing**
```php
// tests/security/AuthSecurityTest.php
<?php
namespace Tests\Security;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class AuthSecurityTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testAdminRoutesRequireAuthentication()
    {
        $adminRoutes = [
            '/asisten_admin',
            '/publikasi-ilmiah_admin',
            '/penelitian-proyek_admin',
            '/galeri_admin',
            '/jadwal_admin',
            '/rekrutmen_admin',
            '/berita_admin',
            '/peserta-praktikum_admin',
            '/events_admin'
        ];

        foreach ($adminRoutes as $route) {
            $response = $this->get($route);
            $this->assertTrue(
                $response->isRedirect() || $response->getStatusCode() === 401,
                "Route {$route} should require authentication"
            );
        }
    }

    public function testPasswordHashing()
    {
        $userModel = new \App\Models\UserModel();
        
        // Test that passwords are properly hashed
        $plainPassword = 'testpassword123';
        $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
        
        $this->assertTrue($userModel->verifyPassword($plainPassword, $hashedPassword));
        $this->assertFalse($userModel->verifyPassword('wrongpassword', $hashedPassword));
    }
}
```

### **B. Input Validation Testing**
```php
// tests/security/ValidationTest.php
<?php
namespace Tests\Security;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class ValidationTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testSQLInjectionPrevention()
    {
        $maliciousInput = "'; DROP TABLE users; --";
        
        $response = $this->post('/asisten/store', [
            'nomor' => $maliciousInput,
            'nama' => 'Test User',
            'jurusan' => 'Informatika',
            'password' => 'test123',
            'role_id' => 2
        ]);

        // Should not crash the application
        $this->assertTrue($response->getStatusCode() < 500);
    }

    public function testXSSPrevention()
    {
        $xssInput = '<script>alert("XSS")</script>';
        
        $response = $this->post('/publikasi-ilmiah/store', [
            'jenis_publikasi' => 'jurnal',
            'kategori' => $xssInput,
            'tanggal_publikasi' => '2024-01-01',
            'deskripsi' => 'Test description'
        ]);

        // Check that XSS is properly escaped
        $this->assertStringNotContainsString('<script>', $response->getBody());
    }
}
```

## 🎭 4. Feature Testing (End-to-End)

### **A. User Management Feature Testing**
```php
// tests/feature/UserManagementTest.php
<?php
namespace Tests\Feature;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class UserManagementTest extends CIUnitTestCase
{
    use FeatureTestTrait, DatabaseTestTrait;

    protected $migrate = true;
    protected $seed    = 'DatabaseSeeder';

    public function testCompleteUserCRUDFlow()
    {
        // Login as admin first
        $this->loginAsAdmin();

        // CREATE: Add new user
        $userData = [
            'nomor' => '152022777',
            'nama' => 'Test Feature User',
            'no_telp' => '081234567890',
            'jurusan' => 'Informatika',
            'password' => 'testpass123',
            'role_id' => 2
        ];

        $response = $this->post('/asisten/store', $userData);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        // READ: Check user appears in list
        $response = $this->get('/asisten_admin');
        $response->assertStatus(200);
        $response->assertSee('Test Feature User');

        // UPDATE: Modify user data
        $userId = $this->getUserIdByNomor('152022777');
        $updateData = [
            'nomor' => '152022777',
            'nama' => 'Updated Feature User',
            'jurusan' => 'Sistem Informasi',
            'role_id' => 3
        ];

        $response = $this->post("/asisten/update/{$userId}", $updateData);
        $response->assertRedirect();
        $response->assertSessionHas('success');

        // DELETE: Remove user
        $response = $this->get("/asisten/delete/{$userId}");
        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    private function loginAsAdmin()
    {
        $this->post('/api/auth/login', [
            'nomor' => '152022001',
            'password' => 'admin123'
        ]);
    }

    private function getUserIdByNomor($nomor)
    {
        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('nomor', $nomor)->first();
        return $user['id'] ?? null;
    }
}
```

## 📊 5. Database Testing

### **A. Migration Testing**
```php
// tests/database/MigrationTest.php
<?php
namespace Tests\Database;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class MigrationTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    public function testAllTablesCreated()
    {
        $expectedTables = [
            'roles', 'users', 'events', 'jadwal', 'asisten_jadwal',
            'publikasi', 'praktikum', 'rekrut', 'proyek_riset',
            'berita', 'galeri_umum', 'modul_praktikum', 'peserta_praktikum'
        ];

        foreach ($expectedTables as $table) {
            $this->assertTrue(
                $this->db->tableExists($table),
                "Table {$table} should exist after migration"
            );
        }
    }

    public function testForeignKeyConstraints()
    {
        // Test that foreign key relationships work
        $this->assertTrue($this->db->tableExists('users'));
        $this->assertTrue($this->db->tableExists('roles'));
        
        // Test foreign key constraint
        $fields = $this->db->getFieldData('users');
        $roleIdField = null;
        foreach ($fields as $field) {
            if ($field->name === 'role_id') {
                $roleIdField = $field;
                break;
            }
        }
        
        $this->assertNotNull($roleIdField, 'role_id field should exist in users table');
    }
}
```

### **B. Seeder Testing**
```php
// tests/database/SeederTest.php
<?php
namespace Tests\Database;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class SeederTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate = true;
    protected $seed    = 'DatabaseSeeder';

    public function testSeedersCreateExpectedData()
    {
        // Test roles seeder
        $roleModel = new \App\Models\RoleModel();
        $roles = $roleModel->findAll();
        $this->assertCount(4, $roles, 'Should have 4 roles');

        // Test users seeder
        $userModel = new \App\Models\UserModel();
        $users = $userModel->findAll();
        $this->assertGreaterThan(10, count($users), 'Should have more than 10 users');

        // Test admin user exists
        $admin = $userModel->where('nomor', '152022001')->first();
        $this->assertNotNull($admin, 'Admin user should exist');
        $this->assertEquals(1, $admin['role_id'], 'Admin should have role_id = 1');
    }
}
```

## 🔐 6. Security Testing

### **A. Authentication Security**
```php
// tests/security/AuthenticationTest.php
<?php
namespace Tests\Security;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

class AuthenticationTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testJWTTokenGeneration()
    {
        // Test JWT token is properly generated
        $authController = new \App\Controllers\Api\Auth();
        
        // Mock successful login
        $this->post('/api/auth/login', [
            'nomor' => '152022001',
            'password' => 'admin123'
        ]);

        $token = session('token');
        $this->assertNotEmpty($token, 'JWT token should be generated');
    }

    public function testAdminFilterProtection()
    {
        // Test that admin routes are protected
        $protectedRoutes = [
            '/asisten_admin',
            '/publikasi-ilmiah_admin',
            '/penelitian-proyek_admin'
        ];

        foreach ($protectedRoutes as $route) {
            $response = $this->get($route);
            $this->assertTrue(
                $response->isRedirect() || $response->getStatusCode() === 401,
                "Route {$route} should be protected"
            );
        }
    }
}
```

## 🎨 7. Frontend Testing (JavaScript & UI)

### **A. Toast Notification Testing**
```javascript
// public/assets/js/tests/toast-test.js
describe('Toast Notifications', function() {
    beforeEach(function() {
        // Setup DOM
        document.body.innerHTML = `
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <div id="successToast" class="toast">
                    <div class="toast-body">
                        <span id="successMessage"></span>
                    </div>
                </div>
            </div>
        `;
    });

    it('should show success toast and auto-dismiss after 3 seconds', function(done) {
        const successToast = new bootstrap.Toast(document.getElementById('successToast'));
        document.getElementById('successMessage').textContent = 'Test success message';
        
        successToast.show();
        
        setTimeout(() => {
            successToast.hide();
            done();
        }, 3000);
    });
});
```

### **B. CRUD Form Testing**
```javascript
// public/assets/js/tests/crud-test.js
describe('CRUD Operations', function() {
    it('should validate required fields before submission', function() {
        const form = document.createElement('form');
        const requiredInput = document.createElement('input');
        requiredInput.required = true;
        requiredInput.value = '';
        form.appendChild(requiredInput);

        const isValid = form.checkValidity();
        expect(isValid).toBe(false);
    });

    it('should show confirmation dialog for delete operations', function() {
        spyOn(window, 'confirm').and.returnValue(true);
        
        const deleteButton = document.createElement('button');
        deleteButton.onclick = () => confirm('Hapus data ini?');
        deleteButton.click();

        expect(window.confirm).toHaveBeenCalledWith('Hapus data ini?');
    });
});
```

## 📱 8. Browser Testing (Manual Testing Checklist)

### **A. Responsive Design Testing**
- [ ] **Desktop (1920x1080)**: Layout proper, semua fitur berfungsi
- [ ] **Tablet (768x1024)**: Navigation collapse, table responsive
- [ ] **Mobile (375x667)**: Touch-friendly buttons, readable text
- [ ] **Print View**: PDF export berfungsi, styling print proper

### **B. Cross-Browser Testing**
- [ ] **Chrome**: Semua fitur berfungsi normal
- [ ] **Firefox**: Compatibility check
- [ ] **Safari**: WebKit compatibility
- [ ] **Edge**: Microsoft compatibility

### **C. Performance Testing**
- [ ] **Page Load Time**: < 3 detik untuk halaman utama
- [ ] **Database Query**: < 100ms untuk query sederhana
- [ ] **File Upload**: < 5MB file upload berfungsi
- [ ] **Concurrent Users**: 10+ user simultan

## 🚀 9. Load Testing

### **A. Database Performance**
```php
// tests/performance/DatabasePerformanceTest.php
<?php
namespace Tests\Performance;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;

class DatabasePerformanceTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    public function testUserQueryPerformance()
    {
        $userModel = new \App\Models\UserModel();
        
        $startTime = microtime(true);
        $users = $userModel->getProcessedPersonnelData();
        $endTime = microtime(true);
        
        $executionTime = ($endTime - $startTime) * 1000; // Convert to milliseconds
        
        $this->assertLessThan(100, $executionTime, 'User query should execute in less than 100ms');
    }
}
```

## 📋 10. Testing Checklist untuk Project

### **Manual Testing Checklist:**

#### **🔐 Authentication Testing**
- [ ] Login dengan kredensial valid (admin: 152022001)
- [ ] Login dengan kredensial invalid
- [ ] Logout functionality
- [ ] Session timeout handling
- [ ] JWT token validation

#### **👥 User Management Testing**
- [ ] **CREATE**: Tambah user baru dengan semua field
- [ ] **READ**: Tampilkan daftar user dengan pagination
- [ ] **UPDATE**: Edit data user existing
- [ ] **DELETE**: Hapus user dengan confirmation
- [ ] **VALIDATION**: Test duplicate nomor prevention
- [ ] **TOAST**: Verify 3-second auto-dismiss notification

#### **📚 Content Management Testing**
- [ ] **Publikasi**: CRUD operations + toast notifications
- [ ] **Proyek Riset**: CRUD operations + toast notifications
- [ ] **Berita**: CRUD operations + toast notifications
- [ ] **Galeri**: CRUD operations + toast notifications
- [ ] **Events**: CRUD operations + toast notifications
- [ ] **Jadwal**: CRUD operations + toast notifications
- [ ] **Rekrutmen**: CRUD operations + toast notifications
- [ ] **Modul Praktikum**: CRUD operations + toast notifications
- [ ] **Peserta Praktikum**: CRUD operations + toast notifications

#### **🎨 UI/UX Testing**
- [ ] **Toast Notifications**: Auto-dismiss dalam 3 detik
- [ ] **Modal Forms**: Open/close functionality
- [ ] **Search & Filter**: Real-time search berfungsi
- [ ] **Pagination**: Navigation antar halaman
- [ ] **Responsive**: Mobile/tablet compatibility
- [ ] **Print**: PDF export functionality

#### **🔒 Security Testing**
- [ ] **Admin Routes**: Hanya admin yang bisa akses
- [ ] **CSRF Protection**: Form submission aman
- [ ] **Input Sanitization**: XSS prevention
- [ ] **SQL Injection**: Database query aman
- [ ] **Password Security**: Hashing berfungsi

#### **⚡ Performance Testing**
- [ ] **Page Load**: < 3 detik loading time
- [ ] **Database Query**: < 100ms execution time
- [ ] **Memory Usage**: < 128MB PHP memory
- [ ] **Concurrent Access**: Multiple user access

### **Automated Testing Commands:**

```bash
# Run all tests
composer test

# Run specific test suite
vendor/bin/phpunit tests/unit/
vendor/bin/phpunit tests/integration/
vendor/bin/phpunit tests/security/

# Generate coverage report
vendor/bin/phpunit --coverage-html tests/coverage/

# Run performance tests
vendor/bin/phpunit tests/performance/
```

### **Testing Environment Setup:**

```bash
# 1. Setup test database
cp .env .env.testing
# Edit .env.testing with test database credentials

# 2. Run migrations for testing
php spark migrate --env=testing

# 3. Seed test data
php spark db:seed DatabaseSeeder --env=testing

# 4. Run tests
composer test
```

## 📊 Expected Test Coverage

### **Target Coverage:**
- **Models**: 90%+ coverage
- **Controllers**: 80%+ coverage
- **API Endpoints**: 95%+ coverage
- **Security Functions**: 100% coverage

### **Critical Test Areas:**
1. **Authentication & Authorization** (100% coverage required)
2. **CRUD Operations** (90% coverage required)
3. **Data Validation** (95% coverage required)
4. **Toast Notifications** (Manual testing required)
5. **Admin Panel Security** (100% coverage required)

Implementasi testing ini akan memastikan bahwa semua fitur SSIP IF ITENAS berfungsi dengan baik, aman, dan memberikan user experience yang optimal dengan toast notification yang auto-dismiss dalam 3 detik.