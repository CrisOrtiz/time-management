<?php

namespace App\GraphQL\Web\Inputs;

use GraphQL\Type\Definition\Type;
use Illuminate\Validation\Rule;
use Rebing\GraphQL\Support\Type as GraphQLType;

class CreateUserInput extends GraphQLType
{
    protected $inputObject = true;

    protected $attributes = [
        'name' => 'CreateUserInput'
    ];

    public function fields()
    {
        return [
            'app_code' => [
                'type' => Type::string(),
                'description' => 'App code for the app',
                'rules' => ['regex:/^[0-9\-+*\/]*$/', 'min:1']
            ],
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
                'description' => 'The email of the user',
                'rules' => [
                    'email',
                    Rule::unique('user', 'email')->where(function ($query) {
                        return $query->whereNull('deleted_at');
                    })
                ]
            ],
            'password' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The password of the user',
                'rules' => ['min:8']
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
