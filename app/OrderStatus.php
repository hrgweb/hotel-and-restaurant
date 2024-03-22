<?php

namespace App;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROCESS = 'process';
    case COMPLETED = 'completed';
}
