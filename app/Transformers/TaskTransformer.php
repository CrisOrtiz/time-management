<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Task;

class TaskTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'notes'
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Task $task)
    {
        return [
            'id' => $task->id,
            'user_id' => $task->user_id,
            'date' => $task->date,
            'start' => $task->start,
            'end' => $task->end,
            'worked_hours' => $task->worked_hours,
        ];
    }

    public function includeNotes(Task $task)
    {
        return $this->item($task->notes, new NoteTransformer());
    }
}
