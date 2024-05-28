<?php

namespace App\Controllers\Api;

use App\Models\DistributionModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class DistributionApi extends ResourceController
{
    use ResponseTrait;

    protected $format = 'json';
    private DistributionModel $distribution;

    public function __construct()
    {
        $this->distribution = new DistributionModel();
        helper('response');
    }

    public function index()
    {
        try {
            $distribution = $this->distribution->findAll();

            $msg = successResponse(ResponseInterface::HTTP_OK, 'Fetch All Distribution', $distribution);

            return $this->respond($msg, ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            log_message('error', 'Error fetching distribution');
            return $this->failServerError($e->getMessage());
        }
    }

    public function create()
    {
        try {
            $rules = [
                'name' => 'required|is_unique[distributions.name]',
                'cost' => 'required'
            ];

            if (!$this->validate($rules)) return $this->validation();

            $data = [
                'name' => trim($this->request->getVar('name') ?? ''),
                'cost' => str_replace('.', '', trim($this->request->getVar('cost') ?? ''))
            ];

            if (!$this->distribution->insert($data)) {
                return $this->failServerError('Failed to create new distribution');
            }

            $newDistributionId = $this->distribution->getInsertID();
            $newDistribution = $this->distribution->find($newDistributionId);

            $msg = successResponse(ResponseInterface::HTTP_CREATED, 'Create new distribution', $newDistribution);

            return $this->respondCreated($msg);
        } catch (\Exception $e) {
            log_message('error', 'Error creating distribution');
            return $this->failServerError($e->getMessage());
        }
    }

    public function update($id = null)
    {
        try {
            $rules = [
                'name' => 'required',
                'cost' => 'required'
            ];

            if (!$this->validate($rules)) return $this->validation();

            $distribution = $this->distribution->find($id);

            if (!$distribution) return $this->failNotFound('Distribution not found');

            $data = [
                'name' => trim($this->request->getVar('name') ?? ''),
                'cost' => str_replace('.', '', trim($this->request->getVar('cost') ?? ''))
            ];

            if (!$this->distribution->update($id, $data)) {
                return $this->failServerError('Failed to update distribution');
            }

            $updatedDistribution = $this->distribution->find($id);

            $msg = successResponse(ResponseInterface::HTTP_OK, 'Updated data distribution', $updatedDistribution);

            return $this->respondUpdated($msg);
        } catch (\Exception $e) {
            log_message('error', 'Error updating distribution');
            return $this->failServerError($e->getMessage());
        }
    }

    public function delete($id = null)
    {
        try {
            $distribution = $this->distribution->find($id);

            if (!$distribution) return $this->failNotFound('Distribution not found');

            if (!$this->distribution->delete($id)) {
                return $this->failServerError('Failed to delete distribution by ID');
            }

            $msg = successResponse(ResponseInterface::HTTP_OK, 'Delete data distribution');

            return $this->respondDeleted($msg);
        } catch (\Exception $e) {
            log_message('error', 'Error deleting distribution');
            return $this->failServerError($e->getMessage());
        }
    }

    public function show($id = null)
    {
        try {
            $distribution = $this->distribution->find($id);

            if (!$distribution) return $this->failNotFound('Distribution not found');

            $msg = successResponse(ResponseInterface::HTTP_OK, 'Find data distribution by ID', $distribution);

            return $this->respond($msg, ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            log_message('error', 'Error fetching by id distribution');
            return $this->failServerError($e->getMessage());
        }
    }

    public function validation()
    {
        return $this->failValidationErrors($this->validator->getErrors());
    }
}
