<?php
namespace App\GraphQL\Mutations;

use Auth;
use App\User;
use Closure;
use App\Models\Transaction;
use GraphQL;
use GraphQL\Type\Definition\Type;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\Mutation;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

class AddTransactionMutation extends Mutation
{
    protected $attributes = [
        'name' => 'AddTransaction'
    ];

    public function type(): Type
    {
        return GraphQL::type('transaction');
    }

    public function args(): array
    {
        return [
            'user_id' => ['name' => 'user_id', 'type' => Type::int()],
            'type'    => ['name' => 'type', 'type' => GraphQL::type('PaymentTypeEnum')],
            'amount'  => ['name' => 'amount', 'type' => Type::float()]
        ];
    }

    protected function rules(array $args = []): array
    {
        return [
            'user_id'  => ['required'],
        ];
    }

    public function resolve($root, $args, $context, ResolveInfo $resolveInfo, Closure $getSelectFields)
    {
        if (Auth::user()->tokenCan('transactions:add')) {
            $transaction = new Transaction();

            $transaction->user_id = $args['user_id'];
            $transaction->type = $args['type'];
            $transaction->amount = $args['amount'];
            $transaction->save();

            return $transaction;
        } else {
            abort(403, 'You cannot add transactions');
        }
    }
}
