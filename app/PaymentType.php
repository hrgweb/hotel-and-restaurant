<?php

namespace App;

enum PaymentType: string
{
    case CASH = 'cash';
    case DEBIT_CARD = 'debit_card';
    case CREDIT_CARD = 'credit_card';
    case ONLINE_PAYMENT = 'online_payment';
}
