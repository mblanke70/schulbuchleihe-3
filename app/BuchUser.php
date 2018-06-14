<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BuchUser extends Pivot
{
    protected $table = 'buch_user';
}
