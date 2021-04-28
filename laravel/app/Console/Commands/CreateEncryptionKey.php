<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Str;

class CreateEncryptionKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'encryption_key:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set the encryption key';

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
     * @return int
     */
    public function handle()
    {
        $this->call('config:clear');

        $permittedChars = Str::random(32);
        $encryptionKey = "base64:" . base64_encode($permittedChars);

        if (!$this->setEnv("ENCRYPTION_KEY", $encryptionKey)) {
            $this->error('Error.');
            return;
        }

        $this->info('Encryption key  set successfully.');
    }

    private function setEnv($name, $value)
    {
        $oldValue =  env($name);
        var_dump($oldValue);
        $oldString = "{$name}={$oldValue}";
        $newString = "{$name}={$value}";

        file_put_contents(app()->environmentFilePath(), str_replace(
            $oldString,
            $newString,
            file_get_contents(app()->environmentFilePath())
        ));
        return true;
    }
}
