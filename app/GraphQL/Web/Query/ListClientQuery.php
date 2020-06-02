<?php

namespace App\GraphQL\Web\Query;

use App\Packages\KendoGrid\KendoGridFilterFactory;
use KendoGrid;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\EnumType;

class ListClientQuery extends Query
{
    protected $attributes = [
        'name' => 'ListClientQuery'
    ];

    public function type()
    {
        return GraphQL::type('ListClientResponse');
    }

    public function args()
    {
        $sort = new InputObjectType([
            'name' => 'ListClientSortFilter',
            'fields' => [
                'field' => new EnumType([
                    'name' => 'ListClientSortFieldFilter',
                    'values' => ['name', 'surname', 'email', 'country', 'user_type', 'company' => [
                        'value' => 'company.name'
                    ]]
                ]),
                'dir' => new EnumType([
                    'name' => 'ListClientDirFieldFilter',
                    'values' => ['asc', 'desc']
                ])
            ]
        ]);
        $filter = new InputObjectType([
            'name' => 'ListClientFilter',
            'fields' => [
                'field' => new EnumType([
                    'name' => 'ListClientFieldFilter',
                    'values' => ['name', 'surname','phone', 'address', 'cupo']
                ]),
                'operator' => new EnumType([
                    'name' => 'ListClientOperatorFilter',
                    'values' => ['contains', 'eq']
                ]),
                'value' => [
                    'type' => Type::string(),
                    'description' => 'Value to search'
                ]
            ]
        ]);
        return [
            'filters' => [
                'type' => KendoGridFilterFactory::create('ListClientFilters', $sort, $filter),
                'description' => ''
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $data = KendoGrid::create(\App\Models\Client::query())
            ->setParams($args['filters'])
            ->getData();
        return $data;
    }
}
