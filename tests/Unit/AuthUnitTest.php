<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class AuthUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_should_be_customer(): void
    {

        $this->assertEquals(User::CUSTOMER_ROLE, 'CUSTOMER');
    }

    public function test_should_be_admin(): void
    {
        $this->assertEquals(User::ADMIN_ROLE, 'ADMIN');
    }
}
