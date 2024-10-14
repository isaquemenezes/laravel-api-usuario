<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    use RefreshDatabase;

    public function test_criar_novos_users()
    {
        $data = [
            'nome' => 'Test User',
            'email' => 'testuser@example.com',
            'cpf' => '61201749077',
            'cep' => '66840891'
        ];

        $response = $this->postJson('/api/users', $data);

        // $response->assertStatus(201);
        $response->assertJson([
            'message' => 'Usuário criado com sucesso!',
            'user' => [
                'nome' => 'Test User',
                'email' => 'testuser@example.com',
                'cpf' => '61201749077',

            ]
        ]);

    }
    public function test_status_users()
    {
        // Usuários testes
        User::factory()->create(['status' => 'ativo']);
        User::factory()->create(['status' => 'inativo']);

        $response = $this->getJson('/api/users');

        $response->assertStatus(200);
        $response->assertJsonCount(1);
    }

    /** @test */
    public function test_show_user()
    {
        $user = User::factory()->create();

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'nome' => $user->nome,
                'email' => $user->email
            ]);
    }

    /** @test */
    public function test_delete_status_inativo_user()
    {
        $user = User::factory()->create(['status' => 'ativo']);

        $response = $this->deleteJson("/api/users/{$user->id}");

        $response->assertStatus(204);

        $this->assertDatabaseHas(
            'users',
            [
                'id' => $user->id,
                'status' => 'inativo'
            ]
        );
    }



}
