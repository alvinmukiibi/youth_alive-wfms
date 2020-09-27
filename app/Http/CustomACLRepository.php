<?php

    namespace App\Http;
    use Auth;
    use File;
    use Alexusmai\LaravelFileManager\Services\ACLService\ConfigACLRepository;

    class CustomACLRepository extends ConfigACLRepository
    {
        /**
         * Get user ID
         *
         * @return mixed
         */
        public function getUserID()
        {
            return \Auth::id();
        }

        public function createUsersPersonalDirectory($email){

            $path = public_path('storage/file-manager/personal/') . $email;
            if(!File::isDirectory($path)){
                File::makeDirectory($path, 0777, true, true);
            }
        }

        /**
         * Get ACL rules list for user
         *
         * @return array
         */
        public function getRules(): array
        {
            // if (in_array('administrator', \Auth::user()->arrayOfRoles())) {
            //     return [
            //         ['disk' => 'General', 'path' => '*', 'access' => 2],
            //     ];
            // }

            $email = Auth::user()->email;

            $this->createUsersPersonalDirectory($email);

            $result = [
                ['disk' => 'General', 'path' => '*', 'access' => 2],
                ['disk' => 'Personal', 'path' => '/', 'access' => 1],
                ['disk' => 'Personal', 'path' => $email, 'access' => 1],
                ['disk' => 'Personal', 'path' => $email . '/*', 'access' => 2],
            ];

            if (Auth::user()->user_type() == 'manager') {
                $result[] = ['disk' => 'Confidential', 'path' => '*', 'access' => 2];
            }
            if (Auth::user()->user_type() == 'director') {
                $result[] = ['disk' => 'Classified', 'path' => '*', 'access' => 2];
            }

            return $result;
        }
    }
















?>
