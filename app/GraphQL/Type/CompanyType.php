<?php

namespace App\GraphQL\Type;

use App\Models\Company;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CompanyType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Company',
        'description'   => 'A Company',
        'model'         => Company::class
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::string(),
                'description' => 'The id of the company'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the company'
            ]
        ];
    }
}
