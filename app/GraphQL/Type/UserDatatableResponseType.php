<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserDatatableResponseType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'UserDatatableResponse',
        'description'   => 'The response listing User for datatables'
    ];

    public function fields()
    {
        return [
            'draw' => [
                'type' => Type::int(),
                'selectable' => false,
                'description' => ''
            ],
            'recordsTotal' => [
                'type' => Type::int(),
                'selectable' => false,
                'description' => ''
            ],
            'recordsFiltered' => [
                'type' => Type::int(),
                'selectable' => false,
                'description' => ''
            ],
            'data' => [
                'type' => Type::listOf(GraphQL::type('User')),
                'selectable' => false,
                'description' => ''
            ],
            'error' => [
                'type' => Type::string(),
                'selectable' => false,
                'description' => ''
            ]
        ];
    }
}
