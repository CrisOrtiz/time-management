<?php

namespace App\GraphQL\Web\Inputs;

use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\EnumType;
use GraphQL\Type\Definition\InputObjectType;
use Rebing\GraphQL\Support\Type as GraphQLType;
use GraphQL;

class GridFiltersInput extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name'          => 'GridFiltersInput'
    ];

    public function fields()
    {
//        $filterModel = new InputObjectType([
//            'name' => 'AgGridListUserFilter',
//            'fields' => [
//                'name' => [
//                    'type' => GraphQL::type('AgGridFilter')
//                ],
//                'surname' => [
//                    'type' => GraphQL::type('AgGridFilter')
//                ],
//                'country' => [
//                    'type' => new InputObjectType([
//                        'name' => 'AgGridListUserCountryFilter',
//                        'fields' => [
//                            'values' => [
//                                'type' => Type::listOf(Type::string())
//                            ],
//                            'filterType' => [
//                                'type' => new EnumType([
//                                    'name' => 'AgGridListUserCountryFilterType',
//                                    'values' => ['set']
//                                ])
//                            ]
//                        ]
//                    ])
//                ]
//            ]
//        ]);

        return [
            'take' => [
                'type' => Type::int(),
                'description' => ''
            ],
            'skip' => [
                'type' => Type::int(),
                'description' => ''
            ]
//            'rowGroupCols' => [
//                'type' => Type::nonNull(Type::listOf(GraphQL::type('AgGridColumn'))),
//                'description' => ''
//            ],
//            'startRow' => [
//                'type' => Type::int(),
//                'description' => ''
//            ],
//            'valueCols' => [
//                'type' => Type::nonNull(Type::listOf(GraphQL::type('AgGridColumn'))),
//                'description' => ''
//            ],
//            'pivotCols' => [
//                'type' => Type::nonNull(Type::listOf(GraphQL::type('AgGridColumn'))),
//                'description' => ''
//            ],
//            'pivotMode' => [
//                'type' => Type::nonNull(Type::boolean()),
//                'description' => ''
//            ],
//            'groupKeys' => [
//                'type' => Type::nonNull(Type::listOf(Type::string())),
//                'description' => ''
//            ],
//            'filterModel' => [
//                'type' => $filterModel,
//                'description' => ''
//            ],
//            'sortModel' => [
//                'type' => Type::nonNull(Type::listOf(GraphQL::type('AgGridSort'))),
//                'description' => ''
//            ]
        ];
    }
}
