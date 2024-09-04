<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Filament\Notifications\Notification;

class SendNotificationToAllUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:all-users {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a notification to all users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $message = $this->argument('message');
        $users = User::all();

        foreach ($users as $user) {
            Notification::make()->title($message)->sendToDatabase($user);
        }

        $this->info('Notification sent to all users successfully.');

        return 0;
    }
}