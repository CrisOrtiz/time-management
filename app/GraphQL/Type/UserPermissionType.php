<?php

namespace App\GraphQL\Type;

use App\Models\PermissionUser;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class UserPermissionType extends GraphQLType
{
    protected $attributes = [
        'name'          => 'UserPermision',
        'description'   => 'A PermissionUser',
        'model'         => PermissionUser::class
    ];

    public function fields()
    {
        return [
            'id' => [
                'type' => Type::string(),
                'description' => 'The id of of the UserPermission'
            ],
            'user_id' => [
                'type' => Type::string(),
                'description' => 'The user_id of the UserPermission'
            ],
            'permission_id' => [
                'type' => Type::string(),
                'description' => 'The permission_id of the UserPermission'
            ]
        ];
    }
}
