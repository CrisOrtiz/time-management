<?php

namespace App\GraphQL\Type;

use App\Models\Permission;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PermissionType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'Permission',
        'description'   => 'A Permissions',
        'model'         => Permission::class
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::string(),
                'description' => 'The id of the permissiion'
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'The name of the permission'
            ],
            'description' => [
                'type' => Type::string(),
                'description' => 'The name of the permission'
            ]
        ];
    }
}
