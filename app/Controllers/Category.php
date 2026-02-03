<?php

namespace App\Controllers;

use App\Models\CategoryModel;

class Category extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kategori Produk',
            'categories' => $this->categoryModel->getWithProductCount(),
        ];

        return view('category/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Kategori',
        ];

        return view('category/create', $data);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoryModel->save([
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/category')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return redirect()->to('/category')->with('error', 'Kategori tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Kategori',
            'category' => $category,
        ];

        return view('category/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoryModel->update($id, [
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('/category')->with('success', 'Kategori berhasil diupdate');
    }

    public function delete($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return redirect()->to('/category')->with('error', 'Kategori tidak ditemukan');
        }

        $this->categoryModel->delete($id);

        return redirect()->to('/category')->with('success', 'Kategori berhasil dihapus');
    }
}
