<?php

namespace App\GraphQL\Web\Mutation;

use App\Models\Permission;
use App\Models\PermissionUser;
use App\Models\User;
use GraphQL;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;

class UpdateUserPermissionsMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateUserPermissionsMutation'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function type()
    {
        return Type::listOf(GraphQL::type('Permission')) ;
    }

    public function args()
    {
        return [
            'user_id' => [
                'type' => Type::string()
            ],
            'permissions' => [
                'type' => Type::listOf(type::string())
            ],
        ];
    }

    public function resolve($root, $args)
    {
        $userId = $args['user_id'];
        $permissions = $args['permissions'];
        PermissionUser::where('user_id',$userId)->delete();
        if (isset($args['permissions'])) {
            foreach ($permissions as $key ) {
                $permission_user = new PermissionUser();
                $permission_user->user_id = $args['user_id'];
                $permission_user->permission_id = Permission::where('name', $key)->first()->id;
                $permission_user->save();
            }
        }
        return User::findOrFail($userId)->permissions;
    }

    public function rules(array $args = [])
    {
        return [];
    }


}
