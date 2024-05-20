<?php

use Tests\TestCase;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\Response;

class UsersApiTest extends TestCase
{
    public function testStore()
    {
        $userData = [
            'name' => Str::random(10),
            'last_name' => Str::random(10),
            'email' => Str::random(6) . '@example.com',
        ];

        $response = $this->json('POST', '/api/users', $userData);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'status',
            'messege',
            'userId',
        ]);
        $this->assertDatabaseHas('users', $userData);
    }

    public function testUpdate()
    {
        $userId = $this->createRandomUser();
        $updatedData = [
            'name' => 'Nuevo Nombre',
            'last_name' => 'Nuevo Apellido',
            'email' => 'nuevoemail@example.com',
        ];
        $response = $this->put("/api/users/{$userId}", $updatedData);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'status' => true,
            'messege' => 'Actualizado correctamente!', // Corregir el nombre de la clave aquí
        ]);
        $this->assertDatabaseHas('users', $updatedData);
    }

    public function testDestroy()
    {
        $userId = $this->createRandomUser();
        $response = $this->delete("/api/users/{$userId}");
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson([
            'status' => true,
            'messege' => 'Eliminado correctamente!'
        ]);
        $this->assertDatabaseMissing('users', ['id' => $userId]);
    }

    public function testIndex()
    {
        $response = $this->get('/api/users');
        $response->assertStatus(Response::HTTP_OK);
        // Verificar que la respuesta sea un array
        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
                'last_name',
                'email',
                'email_verified_at',
                'updated_at',
                'created_at',
            ]
        ]);
    }

    private function createRandomUser()
    {
        // Generar datos aleatorios para crear un usuario
        $userData = [
            'name' => Str::random(10),
            'last_name' => Str::random(10),
            'email' => Str::random(6) . '@example.com',
        ];

        // Crear el usuario y devolver su ID
        $user = User::factory()->create($userData);

        return $user->id;
    }
}
