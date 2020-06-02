<?php

namespace App\GraphQL\Type;

use App\Models\Client;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class ClientType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Client',
        'description'   => 'A Client attributes',
        'model'         => Client::class
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::string(),
                'description' => 'The id of the client'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the client'
            ],
            'surname' => [
                'type' => Type::string(),
                'description' => 'The surname of the client'
            ],
            'phone' => [
                'type' => Type::string(),
                'description' => 'The email of the client'
            ],
            'address' => [
                'type' => Type::string(),
                'description' => 'The country of the client'
            ],
            'cupo' => [
                'type' => Type::int(),
                'description' => 'The quantity limit for loan'
            ],
            
        ];
    }
}
