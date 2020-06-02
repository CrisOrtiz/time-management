<?php

namespace App\GraphQL\Web\Query;

use App\Packages\KendoGrid\KendoGridFilterFactory;
use KendoGrid;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\EnumType;

class ListCollectionQuery extends Query
{
    protected $attributes = [
        'name' => 'ListCollectionQuery'
    ];

    public function type()
    {
        return GraphQL::type('ListCollectionResponse');
    }

    public function args()
    {
        $sort = new InputObjectType([
            'name' => 'ListCollectionSortFilter',
            'fields' => [
                'field' => new EnumType([
                    'name' => 'ListCollectionSortFieldFilter',
                    'values' => ['name', 'default_interest', 'default_installment_number', 'currency', 'last_liquidation', 'worker' => ['value' => 'worker.name']]
                ]),
                'dir' => new EnumType([
                    'name' => 'ListCollectionDirFieldFilter',
                    'values' => ['asc', 'desc']
                ])
            ]
        ]);
        $filter = new InputObjectType([
            'name' => 'ListCollectionFilter',
            'fields' => [
                'field' => new EnumType([
                    'name' => 'ListCollectionFieldFilter',
                    'values' => ['name', 'worker' => ['value' => 'worker.name'], 'default_interest', 'default_installment_number', 'currency', 'last_liquidation']
                ]),
                'operator' => new EnumType([
                    'name' => 'ListCollectionOperatorFilter',
                    'values' => ['contains']
                ]),
                'value' => [
                    'type' => Type::string(),
                    'description' => 'Value to search'
                ]
            ]
        ]);
        return [
            'filters' => [
                'type' => KendoGridFilterFactory::create('ListCollectionFilters', $sort, $filter),
                'description' => ''
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $data = KendoGrid::create(\App\Models\Collection::query())
            ->setParams($args['filters'])
            ->getData();
        return $data;
    }
}
