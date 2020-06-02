<?php

namespace App\GraphQL\Inputs\AgGrid;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\EnumType;
use Rebing\GraphQL\Support\Type as GraphQLType;

class AgGridFilter extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'AgGridFilter'
    ];

    public function fields()
    {
        $filterTypeEnum = new EnumType([
            'name' => 'AgGridFilterType',
            'description' => 'One of the possible filter type for ag-grid',
            'values' => ['text']
        ]);

        $typeEnum = new EnumType([
            'name' => 'AgGridTypeComparator',
            'description' => 'One of the possible type for ag-grid comparator',
            'values' => ['contains']
        ]);

        return [
            'filter' => [
                'type' => Type::string(),
                'description' => 'Text to search'
            ],
            'filterType' => [
                'type' => $filterTypeEnum,
                'description' => 'Type of filter'
            ],
            'type' => [
                'type' => $typeEnum,
                'description' => 'Operator to use'
            ]
        ];
    }
}
