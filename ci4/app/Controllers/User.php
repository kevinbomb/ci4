<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\Modeluser;
class User extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $modelUser = new Modeluser();
        $data = $modelUser->findAll();
        $response = [
        'status' => 200,
        'error' => "false",
        'message' => 'Data retreived',
        'totaldata' => count($data),
        'data' => $data,
        ];
        return $this->respond($response, 200);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($cari = null)
    {
        $modelUser = new Modeluser();
        $data = $modelUser->orLike('id', $cari)
        ->get()->getResult();
        if(count($data) > 1) {
        $response = [
        'status' => 200,
        'error' => "false",
        'message' => '',
        'totaldata' => count($data),
        'data' => $data,
        ];
        return $this->respond($response, 200);
        }else if(count($data) == 1) {
        $response = [
        'status' => 200,
        'error' => "false",
        'message' => '',
        'totaldata' => count($data),
        'data' => $data,
        ];
        return $this->respond($response, 200);
        }else {
        return $this->failNotFound('maaf user ' . $cari . 
        ' tidak ditemukan');
        }
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $modelUser = new Modeluser();
        $id = $this->request->getPost("id");
        $email = $this->request->getPost("email");
        $username = $this->request->getPost("username");
        $password = $this->request->getPost("password");
        $tanggalLahir = $this->request->getPost("tanggalLahir");
        $noTelepon = $this->request->getPost("noTelepon");
        $validation = \Config\Services::validation();
        $valid = $this->validate([
        'id' => [
        'rules' => 'is_unique[user.id]',
        'label' => 'id',
        'errors' => [
            'is_unique' => "{field} sudah ada"
            ]
            ]
        ]);
        if(!$valid){
            $response = [
            'status' => 404,
            'error' => true,
            'message' => $validation->getError("id"),
            ];
            return $this->respond($response, 404);
        }else {
            $modelUser->insert([
            'id' => $id,
            'email' => $email,
            'username' => $username,
            'password' => $password,
            'tanggalLahir' => $tanggalLahir,
            'noTelepon' => $noTelepon,
            ]);
            $response = [
            'status' => 201,
            'error' => "false",
            'message' => "Data berhasil disimpan"
            ];
            return $this->respond($response, 201);
        }
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $model = new Modeluser();
        $data = [
        'email' => $this->request->getVar("email"),
        'username' => $this->request->getVar("username"),
        'password' => $this->request->getVar("password"),
        'tanggalLahir' => $this->request->getVar("tanggalLahir"),
        'noTelepon' => $this->request->getVar("noTelepon"),
        ];
        $data = $this->request->getRawInput();
        $model->update($id, $data);
        $response = [
            'status' => 200,
            'error' => null,
            'message' => "Data user Anda dengan ID $id berhasil dibaharukan"
        ];
        return $this->respond($response);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $modelUser = new Modeluser();
        $cekData = $modelUser->find($id);
        if($cekData) {
            $modelUser->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => "Selamat data sudah berhasil dihapus maksimal"
            ];
            return $this->respondDeleted($response);
        }else {
            return $this->failNotFound('Data tidak ditemukan kembali');
        }
    }
}
