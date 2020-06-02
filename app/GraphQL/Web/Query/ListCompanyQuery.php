<?php

namespace App\GraphQL\Web\Query;

use App\Packages\KendoGrid\KendoGridFilterFactory;
use KendoGrid;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\EnumType;

class ListCompanyQuery extends Query
{
    protected $attributes = [
        'name' => 'ListCompanyQuery'
    ];

    public function type()
    {
        return GraphQL::type('ListCompanyResponse');
    }

    public function args()
    {
        $sort = new InputObjectType([
            'name' => 'ListCompanySortFilter',
            'fields' => [
                'field' => new EnumType([
                    'name' => 'ListCompanySortFieldFilter',
                    'values' => ['name']
                ]),
                'dir' => new EnumType([
                    'name' => 'ListCompanyDirFieldFilter',
                    'values' => ['asc', 'desc']
                ])
            ]
        ]);
        $filter = new InputObjectType([
            'name' => 'ListCompanyFilter',
            'fields' => [
                'field' => new EnumType([
                    'name' => 'ListCompanyFieldFilter',
                    'values' => ['name']
                ]),
                'operator' => new EnumType([
                    'name' => 'ListCompanyOperatorFilter',
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
                'type' => KendoGridFilterFactory::create('ListCompanyFilters', $sort, $filter),
                'description' => ''
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $data = KendoGrid::create(\App\Models\Company::query())
            ->setParams($args['filters'])
            ->getData();
        return $data;
    }
}
