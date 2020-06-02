<?php

namespace App\GraphQL\Web\Query;

use App\Packages\KendoGrid\KendoGridFilterFactory;
use KendoGrid;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\EnumType;

class ListUserQuery extends Query
{
    protected $attributes = [
        'name' => 'ListUserQuery'
    ];

    public function type()
    {
        return GraphQL::type('ListUserResponse');
    }

    public function args()
    {
        $sort = new InputObjectType([
            'name' => 'ListUserSortFilter',
            'fields' => [
                'field' => new EnumType([
                    'name' => 'ListUserSortFieldFilter',
                    'values' => ['name', 'surname', 'email', 'country', 'user_type', 'company' => [
                        'value' => 'company.name'
                    ]]
                ]),
                'dir' => new EnumType([
                    'name' => 'ListUserDirFieldFilter',
                    'values' => ['asc', 'desc']
                ])
            ]
        ]);
        $filter = new InputObjectType([
            'name' => 'ListUserFilter',
            'fields' => [
                'field' => new EnumType([
                    'name' => 'ListUserFieldFilter',
                    'values' => ['name', 'surname', 'email', 'country', 'user_type', 'company' => [
                        'value' => 'company.name'
                    ]]
                ]),
                'operator' => new EnumType([
                    'name' => 'ListUserOperatorFilter',
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
                'type' => KendoGridFilterFactory::create('ListUserFilters', $sort, $filter, [
                    'company' => [
                        'type' => Type::string()
                    ]
                ]),
                'description' => ''
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $query = \App\Models\User::query();
        if (isset($args['filters']) && isset($args['filters']['company']) && $args['filters']['company']) {
            $query->where('company_id', $args['filters']['company']);
        }
        $data = KendoGrid::create($query)
            ->setParams($args['filters'])
            ->getData();
        return $data;
    }
}
