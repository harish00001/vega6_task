<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AuthModel;
class User extends BaseController
{
    public $authModel = null;
    public function __construct()
    {
        $this->authModel = new AuthModel();
    }
    public function index()
    {
        $session = session();
        $userId = $session->get('user')['id'];

        // Fetch the user data from the database
        $user = (object)$this->authModel->find($userId);        

        unset($user->password);       

        
        return view('admin/user/profile', ['user' => $user]);
    }

    public function profile_update()
    {
        $session = session();
        $validation = \Config\Services::validation();
        $rules = [
            'name' => 'required|string|min_length[3]',
            'email' => 'required|valid_email',
            'picture' => 'mime_in[picture,image/jpg,image/jpeg,image/png]',
            'password' => 'permit_empty|min_length[6]',
            'confirm_password' => 'matches[password]',
        ];
        $gl = service('gl');
    //    $gl::pr($_FILES,1);
        // Get the current user ID from the session
        $userId = $session->get('user')['id'];
        // Set validation rules
        $validation->setRules($rules);
        // Validate the input data
        if ($this->request->getMethod() === 'POST' && $validation->withRequest($this->request)->run()) {
            // Prepare the data for updating
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
            ];

            
            if ($file = $this->request->getFile('picture')) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(WRITEPATH . 'uploads/profile_pictures', $newName);
                    $data['picture'] = $newName;
                }
            }
           
            $password = $this->request->getPost('password');
            if (!empty($password)) {
                $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            // Update the user's information
            if ($this->authModel->update($userId, $data)) {
                $updatedUser = $this->authModel->find($userId); // Re-fetch the updated user data
                $session->set('user', $updatedUser);
                $session->setFlashdata('success', 'Profile updated successfully!');
            } else {
                $session->setFlashdata('error', 'Failed to update profile.');
            }

            // Redirect to profile page or reload
            return redirect()->to('/profile');
        }

        return $this->response->setJSON([
            'status' => 0,
            'errors' => $validation->getErrors(),
            'data' => [],
            'msg' => 'Validation error!'
        ]);
        // // If validation fails, redirect back with errors
        // return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
    }
    public function search()
    {
        return view('admin/user/index');
    }


}
