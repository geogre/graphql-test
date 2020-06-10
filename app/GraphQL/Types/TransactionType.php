<?php
namespace App\GraphQL\Types;

use App\Models\Transaction;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;
use Rebing\GraphQL\Support\Facades\GraphQL;

class TransactionType extends GraphQLType
{
    protected $attributes = [
        'name'        => 'Transaction',
        'description' => 'Transaction of a user',
        'model'       => Transaction::class,
    ];

    public function fields(): array
    {
        return [
            'id' => [
                'type'        => Type::int(),
                'description' => 'The id of the transaction'
            ],
            'user_id' => [
                'type'        => Type::int(),
                'description' => 'User Id'
            ],
            'type' => [
                'type'        => GraphQL::type('PaymentTypeEnum'),
                'description' => 'Payment type'
            ],
            'amount' => [
                'type'        => Type::float(),
                'description' => 'Transaction amount'
            ]
        ];
    }
}
