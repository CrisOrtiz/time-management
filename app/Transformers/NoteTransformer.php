<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\Note;

class NoteTransformer extends TransformerAbstract
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
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Note $note)
    {
        return [
            'id' => $note->id,
            'user_id' => $note->user_id,
            'task_id' => $note->date,
            'description' => $note->start,
        ];
    }
}
