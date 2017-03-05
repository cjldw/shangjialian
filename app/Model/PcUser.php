<?php
namespace App\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Created by PhpStorm.
 * User: luowen
 * Date: 2017/3/5
 * Time: 9:29
 */
class PcUser extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'salt', 'password', 'remember_token',
    ];

    public function find($id) {
        return new self([
            'id' => 0,
            'name' => 'admin',
            'password' => 'admin'
        ]);
    }
}