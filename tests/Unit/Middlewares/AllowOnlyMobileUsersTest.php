<?php

namespace Tests\Unit\Middlewares;

use App\Http\Middleware\AllowOnlyMobileUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Tests\TestCase;

class AllowOnlyMobileUsersTest extends TestCase
{
    protected $request;

    protected $middleware;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new Request();
        $this->middleware = new AllowOnlyMobileUsers();
        $this->user = new User();
    }
    public function testRejectRequestForRootUserType()
    {
        $this->user->user_type = User::ROOT;
        $this->actingAs($this->user);

        $response = $this->middleware->handle($this->request, function () {});

        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testRejectRequestForAdminUserType()
    {
        $this->user->user_type = User::ADMIN;
        $this->actingAs($this->user);

        $response = $this->middleware->handle($this->request, function () {});

        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testAcceptRequestForSupervisorUserType()
    {
        $this->user->user_type = User::SUPERVISOR;
        $this->actingAs($this->user);
        $called = false;

        $this->middleware->handle($this->request, function() use (&$called) {
            $called = true;
        });

        $this->assertTrue($called);
    }

    public function testAcceptRequestForWorkerUserType()
    {
        $this->user->user_type = User::WORKER;
        $this->actingAs($this->user);
        $called = false;

        $this->middleware->handle($this->request, function() use (&$called) {
            $called = true;
        });

        $this->assertTrue($called);
    }
}
