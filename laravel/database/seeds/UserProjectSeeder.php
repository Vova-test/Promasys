<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Project;
use App\Models\UserProject;


class UserProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userNames = [
            'Mike',
            'Susan',
            'David',
            'Elan'
        ];

        foreach ($userNames as $userName) {
            factory(User::class, 1)->create([
                'name' => $userName,
                'email' => mb_strtolower($userName) . "@test.com",
            ])->each(function ($user) {
                factory(Project::class, 4)->create()->each(function ($project) use ($user) {
                    UserProject::create(
                        [
                            'project_id' => $project->id,
                            'user_id'=> $user->id,
                            'type' => 1
                        ]
                    );

                });
            });
        }
    }
}
