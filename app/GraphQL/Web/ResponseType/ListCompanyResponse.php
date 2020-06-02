<?php

namespace App\GraphQL\Web\ResponseType;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ListCompanyResponse extends GraphQLType
{
    protected $attributes = [
        'name'          => 'ListCompanyResponse',
        'description'   => 'The response listing Company'
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
                'type' => Type::listOf(GraphQL::type('Company')),
                'selectable' => false,
                'description' => ''
            ]
        ];
    }
}
