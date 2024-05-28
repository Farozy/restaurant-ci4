<?php

namespace App\Controllers\Api;

use App\Models\CategoryModel;
use App\Models\MenuModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Images\Handlers\BaseHandler;
use CodeIgniter\RESTful\ResourceController;
use Config\Services;

class MenuApi extends ResourceController
{
    use ResponseTrait;

    protected $format = 'json';
    private MenuModel $menu;
    private CategoryModel $category;
    protected BaseHandler $image;

    public function __construct()
    {
        helper('response');
        $this->menu = new MenuModel();
        $this->category = new CategoryModel();
        $this->image = Services::image();
    }

    public function index()
    {
        try {
            $menu = $this->menu->getMenu();

            $msg = successResponse(ResponseInterface::HTTP_OK, 'Fetch All Menu', $menu);

            return $this->respond($msg, ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            log_message('error', 'Error fetching menu');
            return $this->failServerError($e->getMessage());
        }
    }

    public function create()
    {
        try {
            $input = $this->request->getVar();

            $validationResult = $this->validation();

            if ($validationResult !== true) {
                return $this->failValidationErrors($validationResult);
            }

            $file = $this->request->getFile('image');

            $category = $this->category
                ->where('id', $input['category'])
                ->orWhere('name', $input['category'])
                ->first();

            if (!$category) return $this->failNotFound('Category not found');

            $image = $file->getRandomName();
            $this->uploadedImage($file, $image);

            $data = [
                'name' => $input['name'],
                'category_id' => $category->id,
                'stock' => $input['stock'],
                'cost' => str_replace('.', '', $input['cost']),
                'sell' => str_replace('.', '', $input['sell']),
                'discount' => str_replace('%', '', $input['discount']),
                'image' => $image,
            ];

            if (!$this->menu->insert($data)) {
                return $this->failServerError('Failed to create new menu');
            }

            $newMenuId = $this->menu->getInsertID();
            $newMenu = $this->menu->getMenu($newMenuId);

            $msg = successResponse(ResponseInterface::HTTP_CREATED, 'Create new menu', $newMenu);

            return $this->respondCreated($msg);

        } catch (\Exception $e) {
            log_message('error', 'Error creating menu');
            return $this->failServerError($e->getMessage());
        }
    }

    public function update($id = null)
    {
        try {
            $input = $this->request->getVar();
            $file = $this->request->getFile('image');

            $checkName = !empty($input['name']) ? $input['name'] : null;
            $checkImage = $file !== null;

            $validationResult = $this->validation($checkName, $checkImage);

            if ($validationResult !== true) {
                return $this->failValidationErrors($validationResult);
            }

            $menu = $this->menu->find($id);

            if (!$menu) return $this->failNotFound('Menu not found');

            $category = $this->category
                ->where('name', $input['category'])
                ->orWhere('name', $input['category'])
                ->first();

            if (!$category) return $this->failNotFound('Category not found');

            if ($file->getError() == 4) {
                $image = $menu->image;
            } else {
                unlink('uploads/images/menu/' . $menu->image);
                $image = $file->getRandomName();
                $this->uploadedImage($file, $image);
            }

            $data = [
                'name' => $input['name'],
                'category_id' => $category->id,
                'stock' => $input['stock'],
                'cost' => str_replace('.', '', $input['cost']),
                'sell' => str_replace('.', '', $input['sell']),
                'discount' => str_replace('%', '', $input['discount']),
                'image' => $image
            ];

            if (!$this->menu->update($id, $data)) {
                return $this->failServerError('Failed to update menu');
            }

            $updatedMenu = $this->menu->find($id);

            $msg = successResponse(ResponseInterface::HTTP_OK, 'Updated data menu', $updatedMenu);

            return $this->respondUpdated($msg);

        } catch (\Exception $e) {
            log_message('error', 'Error updating menu');
            return $this->failServerError($e->getMessage());
        }
    }

    public function delete($id = null)
    {
        try {
            $menu = $this->menu->find($id);

            if (!$menu) return $this->failNotFound('Menu not found');

            if (!$this->menu->delete($id)) {
                return $this->failServerError('Failed to delete menu by ID');
            }

            $imagePath = 'uploads/images/menu/' . $menu->image;
            if (file_exists($imagePath)) {
                if (!unlink($imagePath)) {
                    return $this->respondDeleted('Menu deleted, but failed to delete image');
                }
            }

            $msg = successResponse(ResponseInterface::HTTP_OK, 'Delete data menu');

            return $this->respondDeleted($msg);
        } catch (\Exception $e) {
            log_message('error', 'Error deleting menu');
            return $this->failServerError($e->getMessage());
        }
    }

    public function show($id = null)
    {
        try {
            $menu = $this->menu->getMenu($id);

            if (!$menu) return $this->failNotFound('Menu not found');

            $msg = successResponse(ResponseInterface::HTTP_OK, 'Find data menu by ID', $menu);

            return $this->respond($msg, ResponseInterface::HTTP_OK);
        } catch (\Exception $e) {
            log_message('error', 'Error fetching by id menu');
            return $this->failServerError($e->getMessage());
        }
    }

    public function validation($name = null, $isUpdate = false)
    {
        $rules = [
            'name' => "required|is_unique[menus.name,name,$name]",
            'category' => 'required',
            'stock' => 'required|is_natural',
            'cost' => 'required',
            'sell' => 'required',
            'discount' => 'required',
            'image' => !$isUpdate ? 'uploaded[image]|' : '' . 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]'
        ];

        if (!$this->validate($rules)) {
            return $this->validator->getErrors();
        }

        return true;
    }

    private function uploadedImage($file, $image)
    {
        $file->move('uploads/images', $image);
        $imagePath = 'uploads/images/' . $image;

        $this->image
            ->withFile('uploads/images/' . $image)
            ->resize(750, 500, false, 'width')
            ->save('uploads/images/menu/' . $image);

        unlink($imagePath);
    }
}
