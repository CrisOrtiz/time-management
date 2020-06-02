<?php

namespace App\GraphQL\ResponseTypes;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserAgGridResponse extends GraphQLType
{
    protected $attributes = [
        'name'          => 'UserAgGridResponse',
        'description'   => 'The response listing User for ag grid'
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
