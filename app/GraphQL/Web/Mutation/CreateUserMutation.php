<?php

namespace App\GraphQL\Web\Mutation;

use App\Models\User;
use GraphQL;
use App\Interfaces\UserRepositoryInterface;
use Rebing\GraphQL\Support\Mutation;

class CreateUserMutation extends Mutation
{
    private $userRepository;

    protected $attributes = [
        'name' => 'Create User'
    ];

    public function __construct(UserRepositoryInterface $userRepository)
    {
        parent::__construct();

        $this->userRepository = $userRepository;
    }

    public function type()
    {
        return GraphQL::type('User');
    }

    public function args()
    {
        return [
            'user' => [
                'type' => GraphQL::type('CreateUserInput')
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $data = $args['user'];

        $user = new User();
        $user->name = $data['name'];
        $user->surname = $data['surname'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->user_type = $data['user_type'];
        $user->country = $data['country'];
        $user->company_id = $data['company'] ?? null;
        $user->save();

        $appData = $user->setupAppData();
        $appData->app_code = $data['app_code'];
        $appData->save();

        return $user;
    }

    public function rules(array $args = [])
    {
        return [];
    }

    public function validationErrorMessages ($args = [])
    {
        return [
            'user.email.unique' => "El correo ",
            'user.company' => "Empresa inválida"
        ];
    }
}
