<?php

namespace App\GraphQL\Web\ResponseType;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ListCollectionResponse extends GraphQLType
{
    protected $attributes = [
        'name'          => 'ListCollectionResponse',
        'description'   => 'The response listing Collection'
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
                'type' => Type::listOf(GraphQL::type('Collection')),
                'selectable' => false,
                'description' => ''
            ]
        ];
    }
}
