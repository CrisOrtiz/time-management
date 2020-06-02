<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class AuthPayloadType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'AuthPayload',
        'description'   => 'Auth payload for success login'
    ];

    public function fields()
    {
        return [
            'token' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The aut token'
            ]
        ];
    }
}
