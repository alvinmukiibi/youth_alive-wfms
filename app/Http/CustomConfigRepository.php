<?php

namespace App\Http;

use Alexusmai\LaravelFileManager\Services\ConfigService\DefaultConfigRepository;

class CustomConfigRepository extends DefaultConfigRepository
{
    // implement all methods from interface
    
    /**
     * Get disk list
     *
     * ['public', 'local', 's3']
     *
     * @return array
     */
    public function getDiskList(): array
    {
        $types = ['General'];

        if (auth()->user()->user_type() == 'manager') {
            $types[] = 'Confidential';
        }
        
        if (auth()->user()->user_type() == 'director') {
            $types[] = 'Confidential';
            $types[] = 'Classified';
        }
        
        return $types;
    }
}

?>