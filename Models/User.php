<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;
class User extends Model
{
    protected $connection = "awsapp";
   /**
    * The database table used by the model.
    *
    * @var string
    */
    protected $table = "users";
   /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'name', 'email', 'password'
    ];
   /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
        'password', 'remember_token',
    ];
   
}
?>