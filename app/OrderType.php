<?php

namespace App;

enum OrderType: string
{
    case DINEIN = 'dinein';
    case TAKEAWAY = 'takeaway';
    case DELIVERY = 'delivery';
}
