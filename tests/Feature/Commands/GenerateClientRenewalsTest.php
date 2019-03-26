<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\App\Services\ClientRenewals;
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;
use PHPUnit\Framework\Exception;

class GenerateClientRenewalsTest extends TestCase
{
    use WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->expectedClients = [
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

        ClientRenewals::shouldReceive('getCsvFromClients')
            ->once();
    }

    /**
     * @test
     *
     * @return void
     */
    public function canGenerateCsvFromClientsJson()
    {
        ClientRenewals::shouldReceive('getClientsFromJson')
                    ->once()
                    ->andReturn($this->expectedClients);

        $this->artisan('clientRenewals:generate', [
            '--input' => 'json',
            '--filename' => 'testClientRenewals'
        ]);
        $this->assertCSV($this->expectedClients);

    }

    /**
     * @test
     *
     * @return void
     */
    public function canGenerateCsvFromClientsXml()
    {
        ClientRenewals::shouldReceive('getClientsFromXml')
                    ->once()
                    ->andReturn($this->expectedClients);

        $this->artisan('clientRenewals:generate', [
            '--input' => 'xml',
            '--filename' => 'testClientRenewals'
        ]);
        $this->assertCSV($this->expectedClients);

    }

    private function assertCSV(array $clients) {
        $reader = ReaderFactory::create(Type::CSV);
        $renewalsFile = 'testClientRenewals' . date('dmY') . '.csv';

        try {
            if(!is_readable($renewalsFile)) {
                throw new Exception('File is not readable!');
            }

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
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }
}
