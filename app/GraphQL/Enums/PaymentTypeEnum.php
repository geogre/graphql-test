<?php
namespace App\GraphQL\Enums;

use Rebing\GraphQL\Support\EnumType;

class PaymentTypeEnum extends EnumType
{
    protected $attributes = [
        'name' => 'PaymentType',
        'description' => 'The types of payment',
        'values' => [
            'DEBIT'  => 'Debit',
            'CREDIT' => 'Credit'
        ],
    ];
}
