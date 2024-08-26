<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\OAuthClientSeed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IncomeFeatureTest extends TestCase
{
    //refresh dabase every time we run test
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(OAuthClientSeed::class);

        $fakeUser = new FakeUser('1', 'ben', 'ben@gmail.com', User::CUSTOMER_ROLE);
        $user = User::createUser($fakeUser);

        $token = $user->createToken('Token Name')->accessToken;

        $this->withHeaders([
            'authorization' => 'Bearer '.$token,
        ]);
    }

    /**
     * A basic feature test example.
     */
    public function test_should_create_income(): void
    {

        // - user should provide name,amount and userId inputs
        // - should return {message:"saved successfully",status:201}
        $response = $this->postJson('/api/incomes', [
            'name' => 'salary',
            'amount' => 23,
            'userId' => 1,
        ]);

        $response->assertCreated();
        $response->assertJsonPath('message', 'saved income successfully');

    }

    /**
     * update test depends on create test
     */
    public function test_should_update_income(): void
    {

        //testing if we going to get an eror
        $updateResponse = $this->putJson('/api/incomes', [
            'id' => '',
            'name' => '',
            'amount' => 23,
            'userId' => 1,
        ]);

        $updateResponse->assertStatus(422);
        //end

        //first create row
        // return ID
        //use ID to update this record
        $createResponse = $this->postJson('/api/incomes', [
            'name' => 'salary',
            'amount' => 23,
            'userId' => 1,
        ]);

        $data = $createResponse->assertJsonStructure(['income'])->json();

        $id = $data['income']['id'];

        $updateResponse_1 = $this->putJson('/api/incomes', [
            'id' => $id,
            'name' => 'salary-1',
            'amount' => 23,
            'userId' => 1,
        ]);

        $updateResponse_1->assertStatus(200);
        $updateResponse_1->assertJsonPath('message', 'updated income successfully');

    }

    /**
     * depends on create test
     */
    public function test_should_get_income(): void
    {

        $this->postJson('/api/incomes', [
            'name' => 'salary',
            'amount' => 23,
            'userId' => 1,
        ]);

        $response = $this->getJson('/api/incomes', []);

        $response->assertStatus(200);
        $data = $response->json();

        $keys = array_keys($data['data'][0]);
        $this->assertEquals(['id', 'name', 'amount', 'userId'], $keys);

    }

    /**
     * delete on create
     */
    public function test_should_delete_income(): void
    {
        //checking if id is valid numbe
        $deleteResponse = $this->deleteJson('/api/incomes', [
            'id' => 'dkdkd',

        ]);
        $deleteResponse->assertStatus(422);

        //create a record
        $createResponse = $this->postJson('/api/incomes', [
            'name' => 'salary',
            'amount' => 23,
            'userId' => 1,
        ]);

        $data = $createResponse->assertJsonStructure(['income'])->json();

        $id = $data['income']['id'];

        $deleteResponse_1 = $this->deleteJson('/api/incomes', [
            'id' => $id,

        ]);

        $deleteResponse_1->assertStatus(200);
        $deleteResponse_1->assertJsonPath('message', 'income deleted successfully');

    }
}
