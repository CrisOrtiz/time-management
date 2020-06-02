<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class WorkerTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
    ];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name
        ];
    }
}
