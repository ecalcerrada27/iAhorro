<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;
use App\Models\Expert;
use App\Models\Register;
use Carbon\Carbon;
use Laravel\Sanctum\Sanctum;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function setUp(): void
    {
        parent::setUp();
        $this->withoutExceptionHandling();
    }

    public function crear_registro(): Register
    {
        $user = $this->crear_user();
        $expert = Expert::factory()->create();
 
        return Register::create([
            "user_id" => $user->id,
            "expert_id" => $expert->id,
            "requested_quantity" => rand(10000,100000),
            "comunication_time" => rand(1,8),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }

    public function crear_user(): User
    {
        return User::factory()->create();
    }

    public function auth_user(): User
    {
        $user = $this->crear_user();
        Sanctum::actingAs($user);
        return $user;
    }
}

