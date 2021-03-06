<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Menu;
use App\Item;

class CateringPackage extends Model
{
    //
	use SoftDeletes;
	protected $table = 'tblCateringPackage';
	protected $primaryKey = 'cateringPackageCode';
	protected $fillable = ['cateringPackageName', 'cateringPackageDesc', 'cateringPackageAmount'];
	protected $dates = ['created_at', 'updated_at', 'deleted_at'];
	protected $casts = ['cateringPackageCode' => 'string'];

	public function menus(){
		return $this->belongsToMany('App\Menu', 'tblCateringPackageMenu',  'cateringPackageCode', 'menuCode')->withPivot('pax');;
	}

	public function items(){
		return $this->belongsToMany('App\Item', 'tblCateringPackageItem',  'cateringPackageCode', 'itemCode')->withPivot('quantity');
	}

	public function scopeAvailableMenus($query, $id)
	{
	  $ids = \DB::table('tblCateringPackageMenu')->where('cateringPackageCode', '=', $id)->pluck('menuCode');
	  return Menu::whereNotIn('menuCode', $ids)->get();
	}

	public function scopeAvailableItems($query, $id)
	{
	  $ids = \DB::table('tblCateringPackageItem')->where('cateringPackageCode', '=', $id)->pluck('itemCode');
	  return Item::whereNotIn('itemCode', $ids)->get();
	}
}
