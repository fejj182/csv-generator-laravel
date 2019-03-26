<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Facades\App\Services\ClientRenewals;

class GenerateClientRenewals extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clientRenewals:generate
    { --input=json : Format of input }
    { --filename=clientRenewals : Desired name of file }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a CSV with clients due for renewal';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $input = $this->option('input');
        $clients = [];

        switch($input) {
            case 'json':
                $clients = ClientRenewals::getClientsFromJson();
                break;
            case 'xml':
                $path = 'example_client_renewals';
                $clients = ClientRenewals::getClientsFromXml($path);
                break;
        }

        if (count($clients) > 0) {
            $csv = ClientRenewals::getCsvFromClients($clients);
            $file = fopen($this->option('filename') . date('dmY') . '.csv','w');
            fputs($file, $csv);
            fclose($file);
        }

    }
}
