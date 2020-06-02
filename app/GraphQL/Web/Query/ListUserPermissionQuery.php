<?php

namespace App\GraphQL\Web\Query;

use KendoGrid;
use GraphQL;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\Type;

class ListUserPermissionQuery extends Query
{
    protected $attributes = [
        'name' => 'ListUserPermissionQuery'
    ];

    public function args()
    {
        return [
            'user_id' => [
                'type' => Type::string(),
                'description' => ''
            ]
        ];
    }

    public function type()
    {
        return Type::listOf(GraphQL::type('Permission'));
    }

    public function resolve($root, $args)
    {
        $user = \App\Models\User::findOrFail($args['user_id']);
        return $user->permissions;
    }
}
