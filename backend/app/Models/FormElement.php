<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FormElement extends Model
{
    /**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
    protected $fillable = ['label', 'type', 'form_id'];

    // elements will belong to just 1 form
    public function form() {
		return $this->belongsTo('\App\Models\Form');
	}
}
