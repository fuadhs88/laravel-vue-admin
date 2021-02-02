<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test User List for Admin
     *
     * @return void
     */
    public function testUserListForAdmin()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')
            ->getJson('/api/users');

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => true,
            ]);
    }

    /**
     * Test User List for user type
     *
     * @return void
     */
    public function testUserListForStandardUser()
    {
        $user = User::factory()->create([
            'type' => 'user',
        ]);

        $response = $this->actingAs($user, 'api')
            ->getJson('/api/users');

        $response
            ->assertStatus(403)
            ->assertJson([
                'success' => false
            ]);
    }

    /**
     * Store user
     *
     * @return void
     */
    public function testStoreUser()
    {
        $user = User::factory()->create();

        $data = [
            'name'     => $this->faker->name,
            'email'    => $this->faker->unique()->safeEmail,
            'password' => bcrypt(123456), // password
            'type'     => 'user',
        ];

        $response = $this->actingAs($user, 'api')
            ->postJson('/api/users', $data);

        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    /**
     * Store user validation errors
     *
     * @return void
     */
    public function testStoreUserValidationError()
    {
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'type' => 'admin',
        ];

        $response = $this->actingAs($user, 'api')
            ->postJson('/api/users', $data);

        $response->assertStatus(422);
    }

    /**
     * Update user
     *
     * @return void
     */
    public function testUpdateUser()
    {
        $user = User::factory()->create();

        $data = [
            'name' => $this->faker->name,
            'type' => 'user'
        ];

        $response = $this->actingAs($user, 'api')
            ->putJson('/api/users/' . $user->id, $data);
        $response
            ->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    /**
     * Store user validation errors
     *
     * @return void
     */
    public function testUpdateUserValidationError()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')
            ->putJson('/api/users/' . $user->id, ['email' => 'Invalid@email com']);

        $response->assertStatus(422);
    }


    /**
     * Delete User
     *
     * @return void
     */
    public function testDeleteUser()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')
            ->deleteJson('/api/users/' . $user->id);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true
            ]);
    }

    /**
     * Delete User by Non-Admin User
     *
     * @return void
     */
    public function testDeleteUserForNonAdminUser()
    {
        $user = User::factory()->create([
            'type' => 'user',
        ]);

        $response = $this->actingAs($user, 'api')
            ->deleteJson('/api/users/' . $user->id);

        $response->assertStatus(403);
    }
}
