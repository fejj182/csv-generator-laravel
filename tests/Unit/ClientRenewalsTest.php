<?php

namespace Tests\Unit;

use Tests\TestCase;
use Facades\App\Services\ClientRenewals;
use Tests\Traits\MockHttpRequests;

class ClientRenewalsTest extends TestCase
{
    use MockHttpRequests;

    protected function setUp(): void
    {
        parent::setUp();
        $this->expectedClients = [
            [
                "name" => "Leanne Graham",
                "email" => "Sincere@april.biz",
                "phone" => "1-770-736-8031 x56442",
                "company" => "Romaguera-Crona"
            ],
            [
                "name" => "Ervin Howell",
                "email" => "Shanna@melissa.tv",
                "phone" => "010-692-6593 x09125",
                "company" => "Deckow-Crist"
            ]
        ];
    }

    /**
     * @test
     *
     * @return void
     */
    public function preparesClientRenewalsFromJson()
    {
        $this->mock_client();
        $this->append_response(
            200,
            ['Content-Type' => 'application/json'],
            load_stub('client_renewals.json')
        );

        $clients = ClientRenewals::getClientsFromJson();

        $this->assertEquals($this->expectedClients, $clients);
    }

    /**
     * @test
     *
     * @return void
     */
    public function preparesClientRenewalsFromXml()
    {
        $path = 'tests/stubs/client_renewals';
        $clients = ClientRenewals::getClientsFromXml($path);

        $this->assertEquals($this->expectedClients, $clients);
    }
}
