<?php

namespace App\GraphQL\Web\Mutation;

use App\Models\User;
use GraphQL;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;
use Illuminate\Validation\Rule;

class UpdateCollectionMutation extends Mutation
{
    protected $attributes = [
        'name' => 'UpdateCollectionMutation'
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function type()
    {
        return GraphQL::type('Collection');
    }

    public function args()
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::string())
            ],
            'data' => [
                'type' => Type::nonNull(GraphQL::type('UpdateCollectionInput'))
            ]
        ];
    }

    public function resolve($root, $args)
    {
//        $userId = $args['id'];
//        $data = $args['data'];
//        $user = User::findOrFail($userId);
//        if (isset($data['name'])) {
//            $user->name = $data['name'];
//        }
//        if (isset($data['surname'])) {
//            $user->surname = $data['surname'];
//        }
//        if (isset($data['email'])) {
//            $user->email = $data['email'];
//        }
//        if (isset($data['country'])) {
//            $user->country = $data['country'];
//        }
//        if (isset($data['user_type'])) {
//            $user->user_type = $data['user_type'];
//        }
//        if (isset($data['company'])) {
//            $user->company_id = $data['company'];
//        }
//        $user->save();
//        return $user;
    }

    public function rules(array $args = [])
    {
        $rules = [];
        $rules['data.email'] = [
            'required',
            'email',
            Rule::unique('user', 'email')->where(function ($query) {
                $query->whereNull('deleted_at');
            })->ignore($args['id'])
        ];
        return $rules;
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'data.email.unique' => "El email {$args['data']['email']} ya está en uso. Prueba con otro."
        ];
    }
}
