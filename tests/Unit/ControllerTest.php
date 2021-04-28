<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ControllerTest extends TestCase {
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testWelcomeController() {
        $response = $this->call('GET','/fr');
        $response->assertStatus(200);
    }

    public function testUsersController() {
        $response = $this->call('GET','utilisateurs');
        $response->assertStatus(200);
    }

    public function testUserController() {
        $response = $this->call('GET','utilisateur/1');
        $response->assertStatus(200);
        $response = $this->call('GET','utilisateur/2');
        $response->assertStatus(200);
        $response = $this->call('GET','utilisateur/3');
        $response->assertStatus(200);
    }


    public function testAdministrationController() {
        $response = $this->call('GET','administration');
        $response->assertStatus(200);
    }

    public function testScenarioRegisterController() {
        $response = $this->call('GET','scenario_register');
        $response->assertStatus(200);
    }

    public function testScenarioNewController() {
        $response = $this->call('GET','scenario/nouveau');
        $response->assertStatus(200);
    }

    public function testScenariosController() {
        $response = $this->call('GET','scenarios');
        $response->assertStatus(200);
    }



}
