<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Facades\App\Services\ClientRenewals;
use App\Contracts\FormatterInterface;

class GenerateClientRenewals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clientRenewals:generate
    { --filename=clientRenewals : Desired name of file }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a CSV with clients due for renewal';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(FormatterInterface $formatter)
    {
        parent::__construct();

        $this->formatter = $formatter;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $clients = ClientRenewals::getClients();
        $this->mapHeaders($clients);

        $csv = $this->formatter->arrayToCsv($clients);

        $file = fopen($this->option('filename') . date('dmY') . '.csv','w');
        fputs($file, $csv);
        fclose($file);
    }

    private function mapHeaders(array &$clients) {
        $clients = array_map(function($client) {
            return [
                'Nombre' => $client['name'],
                'Email' => $client['email'],
                'Teléfono' => $client['phone'],
                'Empresa' => $client['company']
            ];
        }, $clients);
    }
}
