<?php

namespace App\GraphQL\Web\Mutation;

use App\Models\Company;
use GraphQL;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;

class CreateCompanyMutation extends Mutation
{
    protected $attributes = [
        'name' => 'Name of the company'
    ];

    public function type()
    {
        return GraphQL::type('Company');
    }

    public function args()
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $company = new Company();
        $company->name = $args['name'];
        $company->save();

        return $company;
    }

    public function rules(array $args = [])
    {
        return [];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'user.email.unique' => "El correo {$args['user']['email']} ya está en uso. Prueba con otro."
        ];
    }
}
