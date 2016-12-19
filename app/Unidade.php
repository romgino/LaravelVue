<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
  protected $table = 'unidades';
    //
  public $fillable = [ 'nome', 'endereco', 'resp', 'fone', 'email', 'obs'];
}
