<?php

namespace App\Controllers\Admin;

use CodeIgniter\RESTful\ResourceController;

class Roles extends ResourceController
{
    protected $modelName = 'App\Models\RoleModel';
    protected $format    = 'json';
    
    // Get semua role
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    // Get Role berdasarkan ID /api/roles/{id}
    public function show($id = null)
    {
        $data = $this->model->find($id);
        if ($data) {
            return $this->respond($data);
        }   
        return $this->failNotFound('Role tidak ditemukan');
    }

    // Create role baru /POST /api/roles
    public function create(){
        $input = $this->request->getJSON(true);
        if ($this->model->insert($input)) {
            return $this->respondCreated(($input));
        }
        return $this->failValidationError($this->model->errors());
    }

    // Update role berdasarkan ID /PUT /api/roles/{id}
    public function update($id = null)
    {
        $input = $this->request->getJSON(true);
        if($this->model->update($id, $input)){
            return $this->respondDeleted(['id' => $id]);
        }
        return $this->failValidationError($this->model->errors());
    }

    // Detele role berdasarkan ID /DELETE /api/roles/{id}
    public function delete($id = null)
    {
        if($this->model->delete($id)){
            return $this->respondDeleted(['id' => $id]);
        } 
        return $this->failNotFound('Role tidak ditemukan');
        
    }
}