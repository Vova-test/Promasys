<?php

namespace App\Console\Commands;

use App\Services\UserService;
use App\Services\EncryptService;
use Illuminate\Console\Command;
use Hash;
use Validator;
use Illuminate\Support\Str;
use App\Services\MailService;
use Illuminate\Support\Facades\URL;

class AssignUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:assign';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for assigning a user to program';

    /**
     * User model.
     *
     * @var object
     */
    private $user;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(UserService $user)
    {
        parent::__construct();

        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('config:clear');

        $details = $this->getDetails();

        $newUser = $this->user->create([
            'name' => $details['name'],
            'email' => $details['email'],
            'password' => Hash::make($details['password']),
            'credential_key' => EncryptService::encryptPassword($details['password']),
        ]);

        $mail = new MailService();
        $mail->send($details['email'], 'mail.registration', $details);

        $this->display($newUser);
    }

    /**
     * Ask for new user details.
     *
     * @return array
     */
    private function getDetails() : array
    {
        $details['name'] = $this->ask('Name');
        $details['email'] = $this->ask('Email');
        $details['password'] = Str::random(16);

        $errors = $this->isValid($details);

        while ($errors->all())
        {
            foreach ($errors->all() as $message) {
                $this->error($message);
            }

            if ($errors->has('name')) {
                $details['name'] = $this->ask('Name');
            }

            if ($errors->has('email')) {
                $details['email'] = $this->ask('Email');
            }

            if ($errors->has('password')) {
                $details['password'] = $this->secret('Password');
                $details['password_confirmation'] = $this->secret('Password confirmation');
            }

            $errors = $this->isValid($details);
        }

        return $details;
    }

    /**
     * Display created new user.
     *
     * @param object $user
     * @return void
     */
    private function display(object $user) : void
    {
        $headers = ['Name', 'Email'];

        $fields = [
            'name' => $user->name,
            'email' => $user->email
        ];

        $this->info('New user created');
        $this->table($headers, [$fields]);
    }

    /**
     * Validation.
     *
     * @param array $user
     * @return object
     */
    private function isValid(array $user) : object
    {
        $validator = Validator::make($user, [
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
        ]);

        return $validator->errors();
    }

}
