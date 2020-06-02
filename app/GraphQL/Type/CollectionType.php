<?php

namespace App\GraphQL\Type;

use App\Models\Collection;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CollectionType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Collection',
        'description'   => 'A Collection model',
        'model'         => Collection::class
    ];

    public function fields()
    {
        $currency = new GraphQL\Type\Definition\EnumType([
            'name' => 'CCurrency',
            'values' => [1, 2, 3, 4, 5, 6, 7, 8]
        ]);
        return [
            'id' => [
                'type' => Type::string(),
                'description' => 'The id of'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name'
            ],
            'default_interest' => [
                'type' => Type::int(),
                'description' => 'Default interest'
            ],
            'default_installment_number' => [
                'type' => Type::int(),
                'description' => 'Default installment number'
            ],
            'currency' => [
                'type' => Type::int(),
                'description' => 'Currency'
            ],
            'company' => [
                'type' => GraphQL::type('Company'),
                'description' => 'The company of the collection'
            ],
            'worker' => [
                'type' => GraphQL::type('User'),
                'description' => 'The worker'
            ],
            'last_liquidation' => [
                'type' => Type::string(),
                'description' => 'ISO date'
            ]
        ];
    }
}
