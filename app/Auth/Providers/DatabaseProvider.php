<?php


namespace App\Auth\Providers;


use App\Models\User;

class DatabaseProvider implements UserProvider
{

    public function getByUsername($username)
    {
        return User::where('email', $username)->first();

    }

    public function getById($id)
    {
        return User::find($id);
    }

    public function updateUserPasswordHash($id, $hash)
    {

        return User::find($id)->update([
            'passwor' => $hash
        ]);
    }

    public function getUserByRememberIdentifier($identifier)
    {
        return User::where('remember_identifier', $identifier)->first();
    }

    public function clearUserRememberToken($id)
    {
        return User::find($id)->update([
            'remember_identifier' => null,
            'remember_token' => null
        ]);
    }

    public function setUserRememberToken($id, $identifier, $hash)
    {
        return User::find($id)->update([
            'remember_identifier' => $identifier,
            'remember_token' => $hash
        ]);

    }
}