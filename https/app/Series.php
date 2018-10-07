<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $guarded = ['id'];

    /**
     * Route model bindingのキーを変更する場合はgetRouteKeyNameをオーバーライド。
     * デフォルトはprimary keyであるid。
     *
     * Get the route key for the model.
     *
     * @return string
     */
//    public function getRouteKeyName()
//    {
//        return $this->getKeyName();
//    }

}
