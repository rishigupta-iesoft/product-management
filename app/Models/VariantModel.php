<?php

namespace App\Models;

use CodeIgniter\Model;

class VariantModel extends Model
{
    protected $table      = 'variants';
    protected $primaryKey = 'id';

    protected $allowedFields = ['name'];
    protected $validationRules = [
        'name' => 'required|min_length[3]',
    ];
}
