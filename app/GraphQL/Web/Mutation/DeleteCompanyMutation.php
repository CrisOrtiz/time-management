<?php

namespace App\GraphQL\Web\Mutation;

use App\Models\Company;
use GraphQL;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;

class DeleteCompanyMutation extends Mutation
{
    protected $attributes = [
        'name' => 'Id of the company'
    ];

    public function type()
    {
        return GraphQL::type('Company');
    }

    public function args()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $company = Company::findOrFail($args['id']);
        $company->delete();

        return $company;
    }
}
