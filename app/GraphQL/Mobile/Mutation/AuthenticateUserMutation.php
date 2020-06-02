<?php

namespace App\GraphQL\Mobile\Mutation;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use GraphQL;
use GraphQL\Type\Definition\Type;
use Illuminate\Contracts\Hashing\Hasher;
use Rebing\GraphQL\Support\Mutation;
use Carbon\Carbon;
use GraphQL\Error\Error;

class AuthenticateUserMutation extends Mutation
{
    private $carbon;
    private $hash;
    private $userRepository;

    protected $attributes = [
        'name' => 'Authenticate User'
    ];

    public function __construct(UserRepositoryInterface $userRepository, Hasher $hash, Carbon $carbon)
    {
        parent::__construct();

        $this->carbon = $carbon;
        $this->hash = $hash;
        $this->userRepository = $userRepository;
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
            throw new Error('No reconocemos tu email, intenta nuevamente');
        }

        if (!$this->hash->check($args['password'], $user->password)) {
            throw new Error('Contraseña incorrecta, intenta nuevamente');
        }

        if ($user->user_type === User::ADMIN || $user->user_type === User::ROOT) {
            throw new Error('No reconocemos tu email, intenta nuevamente');
        }

        $secondsUntilEndOfDay = Carbon::now($user->getTimezone())->diffInSeconds(Carbon::now($user->getTimezone())->endOfDay());

        // Until end of the day
        $token = auth()->setTTL($secondsUntilEndOfDay)->login($user);

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
