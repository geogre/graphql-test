<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use App\User;

class AddUserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @dataProvider provider
     */
    public function testAddUser($permission, $returnCode)
    {
        $adminName = "Admin";
        $adminEmail = "test@admin.com";

        $user = new User(['name' => $adminName, 'email' => $adminEmail, 'password' => '111']);
        $user->save();
        $token = $user->createToken('test-token', [$permission])->plainTextToken;
        $response = $this->withHeaders([
          'Authorization' => 'Bearer ' . $token,
          'Content-Type' => 'application/json'
        ])->post('/graphql', ['query' => 'mutation transactions{addTransaction(user_id:1,type:DEBIT,amount:11.22){user_id}}']);

        $response->assertStatus($returnCode);
    }

    public function provider()
    {
        return [
            ["users:add", 200],
            ["users:get", 200],
            ["transaction:add", 200],
        ];
    }
}
