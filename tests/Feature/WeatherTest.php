<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class WeatherTest extends TestCase
{

    // used in localStorage
    private $_userToken = '134.kv5h34kjgv5134k5h134l-j5h2j12l3451l34jhv34jhv';

    /**
     * Create testing user
     *
     * @return void
     */
    public function test_create_register_user()
    {
        $user = User::factory()->create([
            'name' => 'Ilon Mask',
            'email' => 'i.m@gmail.com',
            'token' => $this->_userToken,
            'expires_in' => 3599
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'i.m@gmail.com'
        ]);
    }

    /**
     * Get weather via API Unauthorized
     *
     * @return void
     */
    public function test_get_weather_unauthorized()
    {
        $response = $this->getJson('/api/user/kojhglkhglughkluhkujhlkuhklujh');

        $response->assertUnauthorized();
    }

    /**
     * Auth check user via API
     *
     * @return void
     */
    public function test_get_user()
    {
        $response = $this->getJson('/api/user/' . $this->_userToken);

        $response->assertJson([
            'name' => 'Ilon Mask',
            'email' => 'i.m@gmail.com',
            'expires_in' => 3599
        ]);
    }

    /**
     * Get weather via API
     *
     * @return void
     */
    public function test_get_weather()
    {
        $response = $this->getJson('/api/getweather?token='.$this->_userToken.'&lat=50.450100&lon=30.523400');

        $response->assertJsonStructure([
            'user' => [
                'id', 'name', 'email', 'created_at', 'updated_at', 'avatar', 'expires_in'
            ],
            'main' => [
                'temp', 'feels_like', 'temp_min', 'temp_max', 'pressure', 'humidity'
            ]
        ]);
    }

    /**
     * Check redis
     *
     * @return void
     */
    public function test_check_redis()
    {
        $jsonGetWeather = $this->getJson('/api/getweather?token='.$this->_userToken.'&lat=50.450100&lon=30.523400');
        $jsonCacheResponse = Redis::get('weather:i.m@gmail.com');
        $this->assertEquals(json_encode($jsonGetWeather->json()), $jsonCacheResponse);
    }

    /**
     * Check redis
     *
     * @return void
     */
    public function test_delete_created_data()
    {
        $response = $this->deleteJson('/api/user/' . $this->_userToken);
        Redis::executeRaw(['DEL', 'weather:i.m@gmail.com']);
        $response->assertOk();
    }
}
