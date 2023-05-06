<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	protected $fillable = ['name', 'display_name', 'description'];

	protected function get_all() {

		return $this->where('is_hidden', '=', 0)
			     ->where('enabled', '=', 1)
			     ->get();
	}
}
