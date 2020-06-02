<?php

namespace App\GraphQL\Type;

use App\Models\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'User',
        'description'   => 'A User payload for success login',
        'model'         => User::class
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::string(),
                'description' => 'The id of the user'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the user'
            ],
            'surname' => [
                'type' => Type::string(),
                'description' => 'The surname of the user'
            ],
            'email' => [
                'type' => Type::string(),
                'description' => 'The email of the user'
            ],
            'country' => [
                'type' => Type::string(),
                'description' => 'The country of the user'
            ],
            'user_type' => [
                'type' => Type::int(),
                'description' => 'The type of the user'
            ],
            'company' => [
                'type' => GraphQL::type('Company'),
                'description' => 'Company'
            ]
        ];
    }
}
