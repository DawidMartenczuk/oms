<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'ID_KONTRAHENTA'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the kontrahent of the user.
     *
     * @return \\App\\WFMAG\\Kontrahent
     */
    public function kontrahent()
    {
        return $this->belongsTo('App\WFMAG\Kontrahent', 'ID_KONTRAHENTA', 'ID_KONTRAHENTA');
    }
}
