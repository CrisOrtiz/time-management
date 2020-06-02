<?php

namespace App\GraphQL\Inputs\AgGrid;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Graphql;

class AgGridColumn extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'AgGridColumn'
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::string()
            ],
            'displayName' => [
                'type' => Type::string()
            ],
            'field' => [
                'type' => Type::boolean()
            ],
            'aggFunc' => [
                'type' => Type::boolean()
            ]
        ];
    }
}
