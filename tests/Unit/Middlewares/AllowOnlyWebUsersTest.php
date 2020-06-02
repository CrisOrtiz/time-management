<?php

namespace Tests\Unit\Middlewares;

use App\Http\Middleware\AllowOnlyWebUsers;
use App\Models\User;
use Illuminate\Http\Request;
use Tests\TestCase;

class AllowOnlyWebUsersTest extends TestCase
{
    protected $request;

    protected $middleware;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->request = new Request();
        $this->middleware = new AllowOnlyWebUsers();
        $this->user = new User();
    }
    public function testRejectRequestForSupervisorUserType()
    {
        $this->user->user_type = User::SUPERVISOR;
        $this->actingAs($this->user);

        $response = $this->middleware->handle($this->request, function () {});

        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testRejectRequestForWorkerUserType()
    {
        $this->user->user_type = User::WORKER;
        $this->actingAs($this->user);

        $response = $this->middleware->handle($this->request, function () {});

        $this->assertEquals(403, $response->getStatusCode());
    }

    public function testAcceptRequestForRootUserType()
    {
        $this->user->user_type = User::ROOT;
        $this->actingAs($this->user);
        $called = false;

        $this->middleware->handle($this->request, function() use (&$called) {
            $called = true;
        });

        $this->assertTrue($called);
    }

    public function testAcceptRequestForAdminUserType()
    {
        $this->user->user_type = User::ADMIN;
        $this->actingAs($this->user);
        $called = false;

        $this->middleware->handle($this->request, function() use (&$called) {
            $called = true;
        });

        $this->assertTrue($called);
    }
}
