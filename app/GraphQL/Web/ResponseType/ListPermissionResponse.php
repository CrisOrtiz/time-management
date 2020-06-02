<?php

namespace App\GraphQL\Web\ResponseType;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ListPermissionResponse extends GraphQLType
{
    protected $attributes = [
        'name'          => 'ListPermissionResponse',
        'description'   => 'The response listing Permission'
    ];

    public function fields()
    {
        return [
            'data' => [
                'type' => Type::listOf(GraphQL::type('Permission')),
                'selectable' => false,
                'description' => ''
            ]
        ];
    }
}
