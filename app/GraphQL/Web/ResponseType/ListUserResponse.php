<?php

namespace App\GraphQL\Web\ResponseType;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ListUserResponse extends GraphQLType
{
    protected $attributes = [
        'name'          => 'ListUserResponse',
        'description'   => 'The response listing User'
    ];

    public function fields()
    {
        return [
            'recordsTotal' => [
                'type' => Type::int(),
                'selectable' => false,
                'description' => ''
            ],
            'data' => [
                'type' => Type::listOf(GraphQL::type('User')),
                'selectable' => false,
                'description' => ''
            ]
        ];
    }
}
