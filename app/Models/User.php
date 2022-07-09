<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $table = 'user';
    protected $primaryKey = 'user_id';

    public $timestamps = true;

    protected $attributes = [

        "user_account_id" => 1,

    ];


    public static function List($column, $filter)
    {
        return User::leftJoin('company', 'company_store_id', 'user.user_account_id')
            ->leftJoin('person', 'person.person_id', 'user.user_person_id')
            ->where($column, $filter);
    }

    public static function Account($column, $filter)
    {
        return User::leftJoin('person', 'person.person_id', 'user.user_person_id')
            ->leftJoin('account', 'account_id', 'user.user_account_id')
            ->leftJoin('store', 'store.store_account_id', 'account.account_id')
            ->where($column, $filter);
    }

    public static function AccountCompany($column, $filter)
    {
        return User::leftJoin('person', 'person.person_id', 'user.user_person_id')
            ->leftJoin('account', 'account_id', 'user.user_account_id')
            ->leftJoin('store', 'store.store_account_id', 'account.account_id')
            ->leftJoin('company', 'company_store_id', 'store.store_id')
            ->where($column, $filter);
    }

    public static function Company($column, $filter)
    {
        return User::leftJoin('account', 'account.account_id', 'user.user_account_id')
            ->leftJoin('store', 'store.store_account_id', 'account.account_id')
            ->leftJoin('company', 'company_store_id', 'store.store_id')
            ->leftJoin('person', 'person.person_id', 'user.user_person_id')
            ->leftJoin('address', 'address.addresstable_id', 'company.company_id')
            ->where($column, $filter);
            
    }

    public static function Person($column, $filter)
    {

        return User::leftJoin('store', 'store.store_id', 'user.user_account_id')
            ->leftJoin('person', 'person.person_id', 'user.user_person_id')
            ->leftjoin('address', 'address.addresstable_id', 'person.person_id')
            ->where($column, $filter);
    }

    public static function Contact()
    {
        return User::leftJoin('person', 'person.person_id', 'user.user_person_id');
    }

    public static function Child()
    {
        return User::leftJoin('person', 'person.person_user_id', 'user.user_id');
    }

    public static function Store($column, $filter)
    {
        return User::leftJoin('person', 'person.person_id', 'user.user_person_id')
            ->leftJoin('store', 'store.store_id', 'person.persontable_id');
        //->where('persontable_type', 'Store')
        // ->where($column, $filter);
    }

    public static function Guest()
    {
        $user =  User::where('user_type', 3)->first();
        $credentials['email'] = $user->email;
        $credentials['password'] = 'test1234';

        if (Auth::attempt($credentials)) {

            $user = User::Person('user_id', Auth::user()->user_id)->first();
        }

        return $user;
    }

    public static function Employment($column, $filter)
    {
        return User::leftJoin('person', 'person.person_id', 'user.user_person_id')
            ->leftJoin('account', 'account_id', 'user.user_account_id')
            ->leftJoin('store', 'store.store_account_id', 'account.account_id')
            ->leftJoin('employment', 'employment.employment_user_id', 'user.user_id')
            ->leftjoin('attendance', 'attendance.attendance_user_id', 'user.user_id')
            ->where($column, $filter);
    }

    public static function UserType()
    {
        return [
            'Super Admin',
            'Admin', //
            'User',
            'Guest',

        ];
    }
}
