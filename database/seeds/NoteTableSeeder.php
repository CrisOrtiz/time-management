<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;
use App\Models\Note;

class NoteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $note = new \App\Models\Note();
        $note->user_id = Task::first()->user_id;
        $note->task_id = Task::first()->id;
        $note->description = 'Example note 1';
        $note->save();

        $note = new \App\Models\Note();
        $note->user_id = Task::first()->user_id;
        $note->task_id = Task::first()->id;
        $note->description = 'Example note 2';
        $note->save();

        $note = new \App\Models\Note();
        $note->user_id = Task::first()->user_id;
        $note->task_id = Task::first()->id;
        $note->description = 'Example note 3';
        $note->save();
    }
}
