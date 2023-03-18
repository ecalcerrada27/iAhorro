<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Expert;
use Carbon\Carbon;

class RegisterTest extends TestCase
{

    //use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->auth_user();
    }


    /**
     * A feature test to try login user
     *
     * @return void
     */
    public function test_for_try_to_login()
    {
        $user= $this->crear_user();

        $response = $this->postJson(route('login'), [
            'email' => $user->email,
            'password' => $user->password,
        ])->assertOk()->json();
        
        $this->assertArrayHasKey('access_token', $response);
    }


    /**
     * A feature test to add a new register
     *
     * @return void
     */
    public function test_for_add_register()
    {
        $user= $this->crear_user();
        $expert = Expert::factory()->create();
 
        $payload = [
            "user_id" => $user->id,
            "expert_id" => $expert->id,
            "requested_quantity" => rand(10000,100000),
            "comunication_time" => rand(1,8),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
 
        $response= $this->postJson(route('registers.store'), $payload)
            ->assertCreated()
            ->json();
        
        $this->assertEquals($user->id, $response['register']['user_id']);
    }

    /**
     * A feature test to get register data based on register ID
     *
     * @return void
     */
    public function test_get_register_by_id()
    {
        $register = $this->crear_registro();
        
        $response = $this->getJson(route('registers.show', $register->id))
                    ->assertOk()
                    ->json();

        $this->assertEquals($response['id'], $register->id);
    }

    /**
     * A feature test to get all registers data
     *
     * @return void
     */
    public function test_get_registers()
    {
        $register = $this->crear_registro();
        
        $this->getJson(route('registers.index'))
        ->assertOk()
        ->json();

        $this->assertDatabaseHas('registers', $register->toArray());   
    }


     /**
     * A feature test to delete register data
     *
     * @return void
     */
    public function test_for_delete_register()
    {
        $register = $this->crear_registro();

        $this->deleteJson(route('registers.destroy', $register->id))
            ->assertNoContent();

        $this->assertDatabaseMissing('registers', $register->toArray());
    }

}
