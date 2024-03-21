<?php

namespace App;

enum TableStatus: string
{
    case OCCUPIED = 'occupied';
    case AVAILABLE = 'available';
}
