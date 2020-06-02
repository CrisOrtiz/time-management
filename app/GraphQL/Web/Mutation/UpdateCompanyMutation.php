<?php

namespace App\GraphQL\Web\Mutation;

use App\Models\Company;
use GraphQL;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;

class UpdateCompanyMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateCompanyMutation'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function type()
    {
        return GraphQL::type('Company');
    }

    public function args()
    {
        return [
            'id' => [
                'type' => Type::string()
            ],
            'name' => [
                'type' => Type::string()
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $companyId = $args['id'];
        $company = Company::findOrFail($companyId);
        if (isset($args['name'])) {
            $company->name = $args['name'];
        }
        $company->save();
        return $company;
    }

    public function rules(array $args = [])
    {
        return [];
    }

//    public function validationErrorMessages ($args = [])
//    {
//        return [
////            'user.email.unique' => "El campo {$ar/gs['user']['email']} ya está en uso. Prueba con otro."
//        ];
//    }
}
