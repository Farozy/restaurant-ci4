<?php

namespace App\Controllers\Api;

use App\Models\CategoryModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class CategoryApi extends ResourceController
{
    use ResponseTrait;

    protected $format = 'json';
    private CategoryModel $category;

    public function __construct()
    {
        helper('response');
        $this->category = new CategoryModel();
    }

    public function index()
    {
        try {
            $category = $this->category->findAll();

            $msg = successResponse(ResponseInterface::HTTP_OK, 'Fetch All Category', $category);

            return $this->respond($msg, ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            log_message('error', 'Error fetching category');
            return $this->failServerError($e->getMessage());
        }
    }

    public function create()
    {
        try {
            $rules = ['name' => 'required|is_unique[categories.name]'];

            if (!$this->validate($rules)) return $this->validation();

            $data = [
                'name' => trim($this->request->getVar('name') ?? '')
            ];

            if (!$this->category->insert($data)) {
                return $this->failServerError('Failed to create new category');
            }

            $newCategoryId = $this->category->getInsertID();
            $newCategory = $this->category->find($newCategoryId);

            $msg = successResponse(ResponseInterface::HTTP_CREATED, 'Create new category', $newCategory);

            return $this->respondCreated($msg);
        } catch (\Exception $e) {
            log_message('error', 'Error creating category');
            return $this->failServerError($e->getMessage());
        }
    }

    public function update($id = null)
    {
        try {
            $rules = ['name' => 'required'];

            if (!$this->validate($rules)) return $this->validation();

            $category = $this->category->find($id);

            if (!$category) return $this->failNotFound('Category not found');

            $data = [
                'name' => trim($this->request->getVar('name') ?? '')
            ];

            if (!$this->category->update($id, $data)) {
                return $this->failServerError('Failed to update category');
            }

            $updatedCategory = $this->category->find($id);

            $msg = successResponse(ResponseInterface::HTTP_OK, 'Updated data category', $updatedCategory);

            return $this->respondUpdated($msg);
        } catch (\Exception $e) {
            log_message('error', 'Error updating category');
            return $this->failServerError($e->getMessage());
        }
    }

    public function delete($id = null)
    {
        try {
            $category = $this->category->find($id);

            if (!$category) return $this->failNotFound('Category not found');

            if (!$this->category->delete($id)) {
                return $this->failServerError('Failed to delete category by ID');
            }

            $msg = successResponse(ResponseInterface::HTTP_OK, 'Delete data category');

            return $this->respond($msg);
        } catch (\Exception $e) {
            log_message('error', 'Error deleting category');
            return $this->failServerError($e->getMessage());
        }
    }

    public function show($id = null)
    {
        try {
            $category = $this->category->find($id);

            if (!$category) return $this->failNotFound('Category not found');

            $msg = successResponse(ResponseInterface::HTTP_OK, 'Find data category by ID', $category);

            return $this->respond($msg, ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            log_message('error', 'Error fetching by id category');
            return $this->failServerError($e->getMessage());
        }
    }

    public function validation()
    {
        return $this->failValidationErrors($this->validator->getErrors());
    }
}
