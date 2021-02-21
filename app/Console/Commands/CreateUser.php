<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\AdminMaster;
use Illuminate\Console\Command;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:admin_master {name} {username} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Administrative Administrators';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        $username = $this->argument('username');
        $password = $this->argument('password');
        Admin::create([
            'nickname' => $name,
            'username' => $username,
            'level' => 'M',
            'password' => app('hash')->make($password),
            'created_at' => date_create()->format('Y-m-d H:i:s'),
            'updated_at' => date_create()->format('Y-m-d H:i:s'),
        ]);
        $this->info('Account created for '.$name);

    }
}
