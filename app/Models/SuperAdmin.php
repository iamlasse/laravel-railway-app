<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Parental\HasParent;

class SuperAdmin extends User
{
    use HasFactory;
    use HasParent;
}
