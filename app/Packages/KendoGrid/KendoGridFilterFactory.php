<?php

namespace App\Packages\KendoGrid;

use GraphQL;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class KendoGridFilterFactory
{
    public static function create($name, $sort, $filter, $additionalFields = [])
    {
        return new InputObjectType([
            'name' => $name,
            'fields' => array_merge($additionalFields, [
                'take' => [
                    'type' => Type::int(),
                    'description' => ''
                ],
                'skip' => [
                    'type' => Type::int(),
                    'description' => ''
                ],
                'sort' => Type::listOf($sort),
                'filter' => new InputObjectType([
                    'name' => $name.'FilterField',
                    'fields' => [
                        'logic' => [
                            'type' => Type::string(),
                        ],
                        'filters' => Type::listOf($filter)
                    ]
                ])
            ])
        ]);
    }
}
