<?php

    namespace App\Http;

    use Alexusmai\LaravelFileManager\Services\ACLService\ConfigACLRepository;

    class CustomACLRepository extends ConfigACLRepository
    {
        /**
         * Get user ID
         *
         * @return mixed
         */
        // public function getUserID()
        // {
        //     return \Auth::id();
        // }

        /**
         * Get ACL rules list for user
         *
         * @return array
         */
        // public function getRules(): array
        // {
        //     if (auth()->user()->user_type() == 'officer') {
        //         return [
        //             ['disk' => 'General', 'path' => '*', 'access' => 2],
        //         ];
        //     }
        // }
    }
















?>