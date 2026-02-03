<?php

namespace App\Controllers;

use App\Models\SupplierModel;

class Supplier extends BaseController
{
    protected $supplierModel;

    public function __construct()
    {
        $this->supplierModel = new SupplierModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Supplier',
            'suppliers' => $this->supplierModel->getWithProductCount(),
        ];

        return view('supplier/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Supplier',
        ];

        return view('supplier/create', $data);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'email' => 'permit_empty|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->supplierModel->save([
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'address' => $this->request->getPost('address'),
        ]);

        return redirect()->to('/supplier')->with('success', 'Supplier berhasil ditambahkan');
    }

    public function edit($id)
    {
        $supplier = $this->supplierModel->find($id);

        if (!$supplier) {
            return redirect()->to('/supplier')->with('error', 'Supplier tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Supplier',
            'supplier' => $supplier,
        ];

        return view('supplier/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'name' => 'required|min_length[2]|max_length[100]',
            'email' => 'permit_empty|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->supplierModel->update($id, [
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'address' => $this->request->getPost('address'),
        ]);

        return redirect()->to('/supplier')->with('success', 'Supplier berhasil diupdate');
    }

    public function delete($id)
    {
        $supplier = $this->supplierModel->find($id);

        if (!$supplier) {
            return redirect()->to('/supplier')->with('error', 'Supplier tidak ditemukan');
        }

        $this->supplierModel->delete($id);

        return redirect()->to('/supplier')->with('success', 'Supplier berhasil dihapus');
    }
}
