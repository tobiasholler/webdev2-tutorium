<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Concert extends Model {

  public function artists() {
    return $this->belongsToMany("App\\Artist");
  }

  public function location() {
    return $this->belongsTo("App\\Location");
  }

  public function events() {
    return $this->hasMany("App\\Event");
  }

}
