<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dish extends Model
{
    //
  use SoftDeletes;
  protected $table = 'tblDish';
  protected $primaryKey = 'dishCode';
  protected $fillable = ['dishName','dishTypeCode','dishDesc'];
  protected $dates = ['created_at', 'updated_at', 'deleted_at'];
  protected $casts = ['dishCode' => 'string'];

  public function dishType()
  {
      return $this->belongsTo('App\DishType', 'dishTypeCode')->withTrashed();
  }

  public function menus()
  {
      return $this->belongsToMany('App\Menu', 'tblMenuDetail', 'dishCode', 'menuCode');
  }
}
