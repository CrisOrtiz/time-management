<?php

namespace App\GraphQL\Web\Inputs;

use GraphQL\Type\Definition\Type;
use Illuminate\Validation\Rule;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UpdateUserInput extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'UpdateUserInput'
    ];

    public function fields()
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The name of the user'
            ],
            'company' => [
                'type' => Type::string(),
                'description' => 'The id of the company the user belongs to',
                'rules' => [
                    'nullable',
                    Rule::exists('company', 'id')->where(function ($query) {
                        return $query->whereNull('deleted_at');
                    })
                ]
            ],
            'surname' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The surname of the user'
            ],
            'email' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The email of the user'
            ],
            'country' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The country of the user',
                'rules' => ['in:BO,CO,BRA,PE']
            ],
            'user_type' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'The type of the user',
                'rules' => ['integer', 'min:1', 'max: 4']
            ]
        ];
    }
}
