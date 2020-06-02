<?php

namespace App\GraphQL\Inputs\AgGrid;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\EnumType;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class AgGridSort extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'AgGridSort'
    ];

    public function fields()
    {
        $typeEnum = new EnumType([
            'name' => 'AgGridSortDirection',
            'description' => 'Direction to sort',
            'values' => ['asc', 'desc', 'ASC', 'DESC']
        ]);
        return [
            'colId' => [
                'type' => Type::string(),
                'description' => 'Name of the column to sort'
            ],
            'sort' => [
                'type' => $typeEnum
            ]
        ];
    }
}
