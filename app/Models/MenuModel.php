<?php namespace indiashopps\Models;

use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model {
	
	protected $table = 'gc_cat';
	function getTopCat()
	{
		$cat = DB::table($table)->where('level',0)->get();
		return $cat;
	}

}
