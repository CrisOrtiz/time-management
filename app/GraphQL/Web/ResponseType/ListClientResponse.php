<?php

namespace App\GraphQL\Web\ResponseType;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ListClientResponse extends GraphQLType
{
    protected $attributes = [
        'name'          => 'ListClientResponse',
        'description'   => 'The response listing Client'
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
                'type' => Type::listOf(GraphQL::type('Client')),
                'selectable' => false,
                'description' => ''
            ]
        ];
    }
}
