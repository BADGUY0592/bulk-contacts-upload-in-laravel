<?php

namespace App\Imports;

use App\Contact;
use Maatwebsite\Excel\Concerns\ToModel;

class ContactsImport implements ToModel
{
    public function  __construct($user)
    {
        $this->user= $user;
    }
    
    public function model(array $row){
        return new Contact([
            'name' => $row[0],
            'mobile' => $row[1],
            'user_id' => $this->user
        ]);
    }
}
