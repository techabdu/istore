<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateTenant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:create {full_name} {business_name} {business_capital} {address} {phone_number} {domain}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new tenant';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenant = \App\Models\Tenant::create([
            'full_name' => $this->argument('full_name'),
            'business_name' => $this->argument('business_name'),
            'business_capital' => $this->argument('business_capital'),
            'address' => $this->argument('address'),
            'phone_number' => $this->argument('phone_number'),
        ]);

        $tenant->domains()->create(['domain' => $this->argument('domain')]);

        $this->info("Tenant created successfully!");
    }
}
