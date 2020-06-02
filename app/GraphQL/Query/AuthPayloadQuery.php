<?php

namespace App\GraphQL\Query;

use App\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;

class AuthPayloadQuery extends Query
{
    protected $attributes = [
        'name' => 'Users query'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('AuthPayload'));
    }

    public function args()
    {
        return [
        ];
    }

    public function resolve($root, $args)
    {
        return [];
    }
}
