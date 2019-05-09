<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $fillable = ['name', 'creator_id'];

    // 1 form will have many elements in it.
    public function elements() {
		return $this->hasMany('\App\Models\FormElement');
	}

}
