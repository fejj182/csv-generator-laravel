<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\App\Services\ClientRenewals;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class GenerateClientRenewalsTest extends TestCase
{
    use WithFaker;

    /**
     * @test
     *
     * @return void
     */
    public function canGenerateCsvFromClients()
    {
        $clients = [
            [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'phone' => $this->faker->phoneNumber,
                'company' => $this->faker->company
            ],
            [
                'name' => $this->faker->name,
                'email' => $this->faker->email,
                'phone' => $this->faker->phoneNumber,
                'company' => $this->faker->company
            ]
        ];

        ClientRenewals::shouldReceive('getClients')
                    ->once()
                    ->andReturn($clients);

        $this->artisan('clientRenewals:generate', ['--filename' => 'testClientRenewals']);
        $this->assertCSV($clients);

    }

    private function assertCSV(array $clients) {
        $reader = ReaderFactory::create(Type::CSV);
        $renewalsFile = 'testClientRenewals' . date('dmY') . '.csv';

        $reader->open($renewalsFile);

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $key => $row) {
                switch($key) {
                    case 1:
                        $this->assertEquals([
                            0 => "Nombre",
                            1 => "Email",
                            2 => "Teléfono",
                            3 => "Empresa"
                        ], $row);
                        break;
                    case 2:
                        $client1 = [];
                        foreach($clients[0] as $key => $value) {
                            $client1[] = $value;
                        }
                        $this->assertEquals($client1, $row);
                        break;
                    case 3:
                        $client2 = [];
                        foreach($clients[1] as $key => $value) {
                            $client2[] = $value;
                        }
                        $this->assertEquals($client2, $row);
                        break;
                }
            }
        }

        $reader->close();

        unlink($renewalsFile);
    }
}
