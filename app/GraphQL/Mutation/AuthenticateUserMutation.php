<?php

namespace App\GraphQL\Mutation;

use App\Interfaces\UserRepositoryInterface;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Contracts\Hashing\Hasher;
use Rebing\GraphQL\Support\Mutation;
use Carbon\Carbon;

class AuthenticateUserMutation extends Mutation
{
    private $hash;

    private $userRepository;

    protected $attributes = [
        'name' => 'Authenticate User'
    ];

    public function __construct(UserRepositoryInterface $userRepository, Hasher $hash, Carbon $carbon)
    {
        parent::__construct();

        $this->hash = $hash;
        $this->userRepository = $userRepository;
        $this->carbon = $carbon;
    }

    public function type()
    {
        return GraphQL::type('AuthPayload');
    }

    public function args()
    {
        return [
            'email' => [
                'name' => 'email',
                'type' => Type::nonNull(Type::string())
            ],
//            'timezone' => [
//                'name' => 'timezone',
//                'type' => Type::nonNull(Type::string())
//            ],
            'password' => [
                'name' => 'password',
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $user = $this->userRepository->findByEmail($args['email']);

        if(!$user) {
            throw new GraphQL\Error\Error('No reconocemos tu email, intenta nuevamente');
        }

        if (!$this->hash->check($args['password'], $user->password)) {
            throw new GraphQL\Error\Error(403, 'Contraseña incorrecta, intenta nuevamente');
        }

        $token = auth()->setTTL(2000)->login($user);

        return [
            'token' => $token
        ];
    }

    public function rules(array $args = [])
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required']
        ];
    }
}
