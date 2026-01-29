<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ShowEnvCommand extends Command
{
    protected $signature = 'env:show';

    protected $description = 'Display all environment variables';

    public function handle()
    {
        $this->info('🔧 Environment Variables:');
        $this->newLine();

        $vars = [
            'APP_NAME' => env('APP_NAME'),
            'APP_ENV' => env('APP_ENV'),
            'APP_KEY' => env('APP_KEY') ? '****' : '(not set)',
            'APP_DEBUG' => env('APP_DEBUG') ? 'true' : 'false',
            'APP_URL' => env('APP_URL'),
            'DB_CONNECTION' => env('DB_CONNECTION'),
            'DB_HOST' => env('DB_HOST'),
            'DB_PORT' => env('DB_PORT'),
            'DB_DATABASE' => env('DB_DATABASE'),
            'DB_USERNAME' => env('DB_USERNAME'),
            'DB_PASSWORD' => env('DB_PASSWORD') ? '****' : '(not set)',
            'SESSION_DRIVER' => env('SESSION_DRIVER'),
            'CACHE_STORE' => env('CACHE_STORE'),
            'QUEUE_CONNECTION' => env('QUEUE_CONNECTION'),
            'REDIS_HOST' => env('REDIS_HOST'),
            'REDIS_PASSWORD' => env('REDIS_PASSWORD') ? '****' : '(not set)',
            'REDIS_PORT' => env('REDIS_PORT'),
        ];

        foreach ($vars as $key => $value) {
            $this->line("   <comment>{$key}</comment> = <info>{$value}</info>");
        }

        $this->newLine();
        return Command::SUCCESS;
    }
}
