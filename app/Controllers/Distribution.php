<?php

namespace App\Controllers;

use App\Models\DistributionModel;
use App\Validation\DistributionValidation;
use CodeIgniter\Validation\Validation;
use Config\Services;

class Distribution extends BaseController
{
    private DistributionModel $distribution;
    protected Validation $validation;
    private DistributionValidation $distributionValidation;

    public function __construct()
    {
        $this->distribution = new DistributionModel();
        $this->validation = Services::validation();
        $this->distributionValidation = new DistributionValidation();
    }

    public function dataDistribution($index = null)
    {
        $distributions = $this->distribution->orderBy('id', 'desc')->findAll();

        $view = !empty($index) ? 'index' : 'data';

        return view("distribution/$view", [
            'title' => 'Distribusi',
            'distribution' => $distributions
        ]);
    }

    public function index()
    {
        return $this->dataDistribution('index');
    }

    public function create()
    {
        if ($this->request->isAjax()) {
            return $this->response->setJSON([
                view('distribution/add', ['title' => 'Tambah Distribution'])
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function save()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $input = $this->request->getVar();

        $errors = [];
        if (!$this->validate($this->distributionValidation->rules, $this->distributionValidation->messages)) {
            $errors = $this->validation->getErrors();
        } else {
            $this->distribution->insert([
                'name' => $input['name'],
                'cost' => str_replace('.', '', $input['cost']),
            ]);
        }

        return $this->response->setJSON(
            !empty($errors) ? $errors : [$this->dataDistribution()]
        );
    }

    public function edit()
    {
        if ($this->request->isAjax()) {
            $id = $this->request->getVar('id');

            $distribution = $this->distribution->find($id);

            if (empty($distribution)) return $this->failNotFound('Distribution not found');

            return $this->response->setJSON([
                view('distribution/edit', [
                    'title' => 'Edit Distribusi',
                    'distribution' => $this->distribution->find($id),
                ])
            ]);
        } else {
            return redirect()->back();
        }
    }

    public function update()
    {
        if ($this->request->isAjax()) {

            $input = $this->request->getVar();

            $errors = [];
            if (!$this->validate($this->distributionValidation->rules, $this->distributionValidation->messages)) {
                $errors = $this->validation->getErrors();
            } else {
                $distribution = $this->distribution->find($input['id']);

                if (empty($distribution)) return $this->failNotFound('Distribution not found');

                $this->distribution->update([
                    'id' => $input['id']
                ], [
                    'name' => $input['name'],
                    'cost' => str_replace('.', '', $input['cost']),
                ]);
            }

            return $this->response->setJSON(
                !empty($errors) ? $errors : [$this->dataDistribution()]
            );
        } else {
            return redirect()->back();
        }
    }

    public function delete()
    {
        if (!$this->request->isAjax()) {
            return redirect()->back()->with('error', 'Forbidden');
        }

        $id = $this->request->getVar('id');

        $distribution = $this->distribution->find($id);

        if (empty($distribution)) return $this->failNotFound('Distribution not found');

        $this->distribution->delete($id);

        return $this->response->setJSON([$this->dataDistribution()]);
    }
}
