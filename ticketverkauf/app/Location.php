<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model {
  public function concerts() {
    return $this->hasMany("App\\Concert");
  }
}
