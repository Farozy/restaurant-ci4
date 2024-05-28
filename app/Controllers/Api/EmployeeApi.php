<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\EmployeeModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class EmployeeApi extends BaseController
{
    use ResponseTrait;

    protected $format = 'json';
    private EmployeeModel $employee;

    public function __construct()
    {
        helper('response');
        $this->employee = new EmployeeModel();
    }

    public function index()
    {
        try {
            $employee = $this->employee->findAll();

            $msg = successResponse(ResponseInterface::HTTP_OK, 'Fetch All Empoyee', $employee);

            return $this->respond($msg, ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            log_message('error', 'Error updating employee');
            return $this->failServerError($e->getMessage());
        }
    }

    public function create()
    {
        try {
            $input = $this->request->getVar();
            $file = $this->request->getFile('image');

            $validationResult = $this->validation();

            if ($validationResult !== true) {
                return $this->failValidationErrors($validationResult);
            }

            $image = $file->getRandomName();
            $file->move('uploads/images/employee', $image);
            $gender = strtolower(str_replace('-', '_', $input['gender']));
            if ($gender === 'perempuan' || $gender === 'laki_laki') {
                $resultGender = $gender !== 'perempuan' ? 'male' : 'female';
            } else {
                $resultGender = $input['gender'] !== 'female' ? 'male' : 'female';
            }

            $data = [
                'name' => $input['name'],
                'gender' => $resultGender,
                'date_of_birth' => format_year($input['date_of_birth']),
                'place_of_birth' => $input['place_of_birth'],
                'image' => $image,
                'phone' => $input['phone'],
                'address' => $input['address'],
                'email' => $input['email']
            ];

            if (!$this->employee->insert($data)) {
                return $this->failServerError('Failed to create new menu');
            }

            $newEmployeeId = $this->employee->getInsertID();
            $newEmployee = $this->employee->find($newEmployeeId);

            $msg = successResponse(ResponseInterface::HTTP_CREATED, 'Create new employee', $newEmployee);

            return $this->respondCreated($msg);

        } catch (\Exception $e) {
            log_message('error', 'Error creating employee');
            return $this->failServerError($e->getMessage());
        }
    }

    public function update($id)
    {
        try {
            $input = $this->request->getVar();
            $file = $this->request->getFile('image');

            $checkEmail = !empty($input['email']) ? $input['email'] : null;
            $checkImage = $file !== null;

            $validationResult = $this->validation($checkEmail, $checkImage);

            if ($validationResult !== true) {
                return $this->failValidationErrors($validationResult);
            }

            $employee = $this->employee->find($id);

            if (!$employee) return $this->failNotFound('Employee not found');

            if ($file->getError() == 4) {
                $image = $employee->image;
            } else {
                unlink('uploads/images/employee/' . $employee->image);
                $image = $file->getRandomName();
                $file->move('uploads/images/employee', $image);
            }

            $gender = strtolower(str_replace('-', '_', $input['gender']));
            if ($gender === 'perempuan' || $gender === 'laki_laki') {
                $resultGender = $gender !== 'perempuan' ? 'male' : 'female';
            } else {
                $resultGender = $input['gender'] !== 'female' ? 'male' : 'female';
            }

            $data = [
                'name' => $input['name'],
                'gender' => $resultGender,
                'date_of_birth' => format_year($input['date_of_birth']),
                'place_of_birth' => $input['place_of_birth'],
                'image' => $image,
                'phone' => $input['phone'],
                'address' => $input['address'],
                'email' => $input['email']
            ];

            if (!$this->employee->update($id, $data)) {
                return $this->failServerError('Failed to create new employee');
            }

            $updatedEmployee = $this->employee->find($id);

            $msg = successResponse(ResponseInterface::HTTP_OK, 'Updated new employee', $updatedEmployee);

            return $this->respondUpdated($msg);

        } catch (\Exception $e) {
            log_message('error', 'Error updating employee');
            return $this->failServerError($e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $employee = $this->employee->find($id);

            if (!$employee) return $this->failNotFound('Employee not found');

            $msg = successResponse(ResponseInterface::HTTP_OK, 'Find data employee by ID', $employee);

            return $this->respond($msg, ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            log_message('error', 'Error fetching by id employee');
            return $this->failServerError($e->getMessage());
        }
    }

    public function validation($email = null, $isUpdate = false)
    {
        $rules = [
            'name' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
            'place_of_birth' => 'required',
            'image' => !$isUpdate ? 'uploaded[image]|' : '' . 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]',
            'phone' => 'required|is_natural',
            'email' => "required|valid_email|is_unique[employees.email,email,$email]",
            'address' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->validator->getErrors();
        }

        return true;
    }
}
