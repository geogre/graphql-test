<?php
namespace App\GraphQL\Mutations;

use Auth;
use Closure;
use GraphQL;
use App\User;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Mutation;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class AddUserMutation extends Mutation
{
    protected $attributes = [
        'name' => 'AddUser'
    ];

    public function type(): Type
    {
        return GraphQL::type('user');
    }

    public function args(): array
    {
        return [
            'name' => ['name' => 'name', 'type' => Type::nonNull(Type::string())],
            'email' => ['name' => 'email', 'type' => Type::nonNull(Type::string())],
            'password' => ['name' => 'password', 'type' => Type::nonNull(Type::string())]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'name'  => ['required', 'string'],
            'email' => ['required', 'email'],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        if (Auth::user()->tokenCan('users:add')) {
            $user = new User();

            $user->name = $args['name'];
            $user->email = $args['email'];
            $user->password = bcrypt($args['password']);
            $user->save();

            return $user;
        } else {
            abort(403, 'You cannot add users');
        }
    }

    public function validationErrorMessages(array $args = []): array
    {
        return [
            'name.required'  => 'Please enter your full name',
            'name.string'    => 'Your name must be a valid string',
            'email.required' => 'Please enter your email address',
            'email.email'    => 'Please enter a valid email address',
            'email.exists'   => 'Sorry, this email address is already in use',
        ];
    }
}
