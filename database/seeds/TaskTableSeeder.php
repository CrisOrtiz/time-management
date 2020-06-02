<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class TaskTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $task = new \App\Models\Task();
        $task->user_id = User::skip(2)->first()->id;
        $task->date = '2020-05-20';
        $task->start = '12:00:00';
        $task->end = '16:00:00';;
        $task->worked_hours = 4;
        $task->save();

    }
}
