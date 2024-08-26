<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\OauthAccessTokenSeed;
use Database\Seeders\OAuthClientSeed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Facades\Socialite;
use Tests\TestCase;

class AuthFeatureTest extends TestCase
{
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
    public function test_create_user(): void
    {
        $fakeUser = new FakeUser('1', 'ben', 'ben@gmail.com', User::CUSTOMER_ROLE);
        $createdUser = User::createUser($fakeUser);

        $data = $createdUser->toArray();

        $this->assertEquals(new FakeUser($data['google_id'], $data['name'], $data['email'], $data['role']), $fakeUser);

    }

    // public function test_should_redirect_to_google(): void
    // {
    //     $response = $this->get('/auth/redirect');
    //     Socialite::shouldReceive('google')->with('redirect');

    //     $response->assertRedirectContains('https://accounts.google.com');
    // }

    public function test_should_logout_user(): void
    {
        $this->seed(OauthAccessTokenSeed::class);
        $deleteResponse = $this->postJson('/api/logout', [
            'userId' => 1,
        ]);

        $deleteResponse->assertStatus(200);
        $deleteResponse->assertJsonPath('message', 'user logged out');

    }
}
