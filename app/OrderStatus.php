<?php

namespace App;

enum OrderStatus: string
{
    case PENDING = 'pending';
    case PROGRESS = 'progress';
    case COMPLETED = 'completed';
}
