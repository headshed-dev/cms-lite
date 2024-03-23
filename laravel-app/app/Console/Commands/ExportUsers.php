<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ExportUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:export-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to export a list of users to a csv file.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        $file_contents = '';

        foreach ($users as $user) {
            $file_contents .= $user->name . ',' . $user->email . "\n";
        }

        $usersDirectoryPath = storage_path('app/exports/users');

        if (!file_exists($usersDirectoryPath)) {
            mkdir($usersDirectoryPath, 0775, true);
        }

        file_put_contents($usersDirectoryPath . '/users.csv', $file_contents);

        $this->info('Users exported to ' . $usersDirectoryPath . '/users.csv');
    }
}
