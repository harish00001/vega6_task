<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\AuthModel;

class Auth extends BaseController
{

    protected $authModel;

    public function __construct()
    {
        $this->authModel = new AuthModel();
    }

    public function signin()
    {
        return view('admin/auth/signin');
    }
    public function signup()
    {
        return view('admin/auth/signup');
    }

    public function loginSubmit()
    {
        // Load form validation service
        $validation = \Config\Services::validation();
        $gl = service('gl'); // Global Library to serve by service for global access 

     
    
        // Define validation rules
        $rules = [
            'email' => [
                'label' => 'Email',
                'rules' => 'required|valid_email'
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required'
            ]
        ];
    
        // Set validation rules
        $validation->setRules($rules);
    
        
        // Validate the input
        if (!$this->request->getMethod() === 'post' || !$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'status' => 0,
                'errors' => $validation->getErrors(),
                'data' => [],
                'msg' => 'Validation error!'
            ]);
        } else {
            $email = $this->request->getPost('email');
            $pass = $this->request->getPost('password');
            $remember = $this->request->getPost('remember_me');
          
            $user = $this->authModel->login($email, $pass);
            // print_R( $user);die;
            if ($user === false) {
                return $this->response->setJSON([
                    'status' => 0,
                    'errors' => [],
                    'data' => [],
                    'msg' => 'Email or password not matched!'
                ]);
            }
    
            if ($remember) {
                $token = sha1(rand(999, 99999));
                set_cookie('REMEMBER_ME', $token, 604800); // Set cookie for 1 week
                $this->authModel->set_remember_token($user['id'], $token);
            }
    
            // Start the user session
            session()->set(['user' => $user]);
            // Add any additional user session data if needed
            
    
            return $this->response->setJSON([
                'status' => 1,
                'errors' => [],
                'data' => [],
                'msg' => 'Logged in successfully!'
            ]);
        }
    }

    public function registerSubmit()
    {
        // Load necessary services
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();
        
        // Define validation rules
        $validationRules = [
            'name' => [
                'rules' => 'required|min_length[3]|max_length[100]',
                'label' => 'Full Name'
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'label' => 'Email Address'
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'label' => 'Password'
            ],
            'picture' => [
                'rules' => 'uploaded[picture]|max_size[picture,2048]|is_image[picture]|mime_in[picture,image/jpg,image/jpeg,image/png]',
                'label' => 'Profile Picture'
            ],
        ];
    
        // Check if validation passes
        if (!$this->validate($validationRules)) {
            // Return errors if validation fails
            return $this->response->setJSON([
                'status' => 0,
                'errors' => $validation->getErrors(),
            ]);
        }
    
        // Get form input values
        $name = $request->getPost('name');
        $email = $request->getPost('email');
        $password = password_hash($request->getPost('password'), PASSWORD_DEFAULT);
        
        // Handle profile picture upload
        $picture = $request->getFile('picture');
        if ($picture->isValid() && !$picture->hasMoved()) {
            $newName = $picture->getRandomName();
            $picture->move(WRITEPATH . 'uploads/profile_pictures', $newName);
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'errors' => ['picture' => 'Error uploading picture.'],
            ]);
        }
        // print_R($newName);die;
    
        // Prepare data to insert into database
        $userData = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'picture' => $newName,
            'created_at' => date('Y-m-d H:i:s'),
        ];
    
        if ($this->authModel->insert($userData)) {
            return $this->response->setJSON([
                'status' => 1,
                'message' => 'Registration successful.',
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 0,
                'errors' => ['general' => 'Failed to register user. Please try again.'],
            ]);
        }
    }
    
    


    public function register()
    {
        $data = [];
        
        if ($this->request->getMethod() === 'post') {
            // Validation
            $rules = [
                'name' => 'required|min_length[3]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'profile_picture' => 'uploaded[profile_picture]|max_size[profile_picture,1024]|ext_in[profile_picture,jpg,jpeg,png]'
            ];
            
            if ($this->validate($rules)) {
                // Save user data
                $profilePicture = $this->request->getFile('profile_picture');
                $newName = $profilePicture->getRandomName();
                $profilePicture->move(WRITEPATH . 'uploads', $newName);
                
                $data = [
                    'name' => $this->request->getPost('name'),
                    'email' => $this->request->getPost('email'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                    'profile_picture' => $newName,
                ];
                
                $this->authModel->save($data);
                return redirect()->to('/signin');
            } else {
                $data['validation'] = $this->validator;
            }
        }
        
        return view('auth/register', $data);
    }
}
