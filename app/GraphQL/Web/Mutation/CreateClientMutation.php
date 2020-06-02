<?php

namespace App\GraphQL\Web\Mutation;

use App\Models\Client;
use GraphQL;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;

class CreateClientMutation extends Mutation
{
    protected $attributes = [
        'name' => 'Name of the client'
    ];

    public function type()
    {
        return GraphQL::type('Client');
    }

    public function args()
    {
        return [
            'name' => [
                'type' => Type::nonNull(Type::string())
            ],
            'surname' => [
                'type' => Type::nonNull(Type::string())
            ],
            'phone' => [
                'type' => Type::nonNull(Type::string())
            ],
            'address' => [
                'type' => Type::nonNull(Type::string())
            ],
            'business' => [
                'type' => Type::nonNull(Type::string())
            ],
            'guarantor_name' => [
                'type' => Type::nonNull(Type::string())
            ],
            'guarantor_phone' => [
                'type' => Type::nonNull(Type::string())
            ],
            'guarantor_address' => [
                'type' => Type::nonNull(Type::string())
            ],
            'latitude' => [
                'type' => Type::nonNull(Type::float())
            ],
            // 'cost_lat' => [
            //     'type' => Type::nonNull(Type::float())
            // ],
            // 'sin_lat' => [
            //     'type' => Type::nonNull(Type::float())
            // ],
            'longitude' => [
                'type' => Type::nonNull(Type::float())
            ],
            // 'cos_lng' => [
            //     'type' => Type::nonNull(Type::float())
            // ],
            // 'sin_lng' => [
            //     'type' => Type::nonNull(Type::float())
            // ],
             
            'cupo' => [
                'type' => Type::nonNull(Type::float())
            ],
            'identity_number' => [
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $client = new Client();
        $client->name = $args['name'];
        $client->surname = $args['surname'];
        $client->phone = $args['phone'];
        $client->address = $args['address'];
        $client->business = $args['business'];
        $client->guarantor_name = $args['guarantor_name'];
        $client->guarantor_phone = $args['guarantor_phone'];
        $client->guarantor_address = $args['guarantor_address'];
        $client->latitude = $args['latitude'];
        // $client->cost_lat = $args['cost_lat'];
        // $client->sin_lat = $args['sin_lat'];
        $client->longitude = $args['longitude'];
        // $client->cos_lng = $args['cos_lng'];
        // $client->sin_lng = $args['sin_lng'];
        $client->created_by = auth()->user()->id;
        $client->cupo = $args['cupo'];
        $client->identity_number = $args['identity_number'];
        $client->save();

        return $client;
    }

    public function rules(array $args = [])
    {
        return [];
    }

    
}

