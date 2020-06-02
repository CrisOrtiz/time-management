<?php

namespace App\GraphQL\Type;

use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CompanyAgGridResponseType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'CompanyAgGridResponseType',
        'description'   => 'The response listing Company for ag grid'
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
