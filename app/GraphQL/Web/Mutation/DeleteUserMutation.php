<?php

namespace App\GraphQL\Web\Mutation;

use App\Models\User;
use GraphQL;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;

class DeleteUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'DeleteUserMutation'
    ];

    public function type()
    {
        return GraphQL::type('User');
    }

    public function args()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $user = User::findOrFail($args['id']);
        $user->delete();

        return $user;
    }
}
