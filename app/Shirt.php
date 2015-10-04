<?php

namespace ShirtBase;

use Illuminate\Database\Eloquent\Model;

class Shirt extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shirts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];
}
