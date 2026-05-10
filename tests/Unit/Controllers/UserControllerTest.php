<?php
namespace Tests\Unit\Controllers;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\ControllerTestTrait;
use CodeIgniter\Test\DatabaseTestTrait;

class UserControllerTest extends CIUnitTestCase
{
    use ControllerTestTrait, DatabaseTestTrait;

    protected $migrate = true;
    protected $seed    = 'Tests\Support\Database\Seeds\DatabaseSeeder';

    public function testIndexReturnsCorrectView()
    {
        $result = $this->controller(\App\Controllers\UserController::class)
                       ->execute('index');

        // Test: Response status 200
        $this->assertTrue($result->isOK(), 'Response should be OK');

        // Test: View mengandung title yang benar
        $this->assertStringContainsString(
            'Anggota Laboratorium',
            $result->getBody(),
            'Page should contain correct title'
        );

        // Test: View mengandung data asisten
        $this->assertStringContainsString(
            'asisten',
            $result->getBody(),
            'Page should contain asisten data'
        );
    }
}
