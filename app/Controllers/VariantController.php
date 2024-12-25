<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Variant extends ResourceController
{
    protected $modelName = 'App\Models\VariantModel';
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function create()
    {
        $data = $this->request->getPost();
        if ($this->model->insert($data)) {
            return $this->respondCreated($data);
        }
        return $this->failValidationErrors($this->model->errors());
    }
}
