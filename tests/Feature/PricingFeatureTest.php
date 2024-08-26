<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\OAuthClientSeed;
use Database\Seeders\PricingFeatureSeed;
use Database\Seeders\PricingSeed;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PricingFeatureTest extends TestCase
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
    public function test_should_pricing_table_has_data(): void
    {
        $this->seed(PricingSeed::class);
        $this->assertDatabaseHas('pricings', [
            'name' => 'Basic',
            'stripe_price_id' => 'price_1PZbOVHpqk1Ix2np7tbxqlP2',
            'stripe_prod_id' => 'prod_QQSJdJwwJxMCOW',
            'price' => 15,
        ]);

        $this->assertDatabaseHas('pricings', [
            'name' => 'Pro',
            'stripe_price_id' => 'price_1PZbOyHpqk1Ix2npwRkr2DaW',
            'stripe_prod_id' => 'prod_QQSJdJwwJxMCOW',
            'price' => 100,
        ]);

        $this->assertDatabaseHas('pricings', [
            'name' => 'LifeTime',
            'stripe_price_id' => 'price_1PZbPRHpqk1Ix2npUcsxjwvi',
            'stripe_prod_id' => 'prod_QQSJdJwwJxMCOW',
            'price' => 300,
        ]);

    }

    public function test_should_returns_correct_pricings_columns(): void
    {
        $this->seed([PricingSeed::class, PricingFeatureSeed::class]);

        $response = $this->getJson('/api/pricings', []);

        $response->assertStatus(200);
        $data = $response->json();

        $priceKeys = array_keys($data['data'][0]);
        $pricingFeaturesKeys = array_keys($data['data'][0]['pricing_features'][0]);

        $this->assertEquals(['id', 'name',
            'stripe_price_id', 'stripe_prod_id', 'price', 'payment_term',
            'created_at', 'updated_at', 'pricing_features'], $priceKeys);

        $this->assertEquals(['id', 'name',
            'priceId', 'created_at', 'updated_at'], $pricingFeaturesKeys);

    }
}
