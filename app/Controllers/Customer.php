<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\TransactionModel;

class Customer extends BaseController
{
    protected $customerModel;
    protected $transactionModel;

    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->transactionModel = new TransactionModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Customer',
            'customers' => $this->customerModel->getWithTransactionStats(),
        ];

        return view('customer/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Customer',
        ];

        return view('customer/create', $data);
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

        $this->customerModel->save([
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'address' => $this->request->getPost('address'),
        ]);

        return redirect()->to('/customer')->with('success', 'Customer berhasil ditambahkan');
    }

    public function edit($id)
    {
        $customer = $this->customerModel->find($id);

        if (!$customer) {
            return redirect()->to('/customer')->with('error', 'Customer tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Customer',
            'customer' => $customer,
        ];

        return view('customer/edit', $data);
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

        $this->customerModel->update($id, [
            'name' => $this->request->getPost('name'),
            'phone' => $this->request->getPost('phone'),
            'email' => $this->request->getPost('email'),
            'address' => $this->request->getPost('address'),
        ]);

        return redirect()->to('/customer')->with('success', 'Customer berhasil diupdate');
    }

    public function delete($id)
    {
        $customer = $this->customerModel->find($id);

        if (!$customer) {
            return redirect()->to('/customer')->with('error', 'Customer tidak ditemukan');
        }

        $this->customerModel->delete($id);

        return redirect()->to('/customer')->with('success', 'Customer berhasil dihapus');
    }

    public function search()
    {
        $keyword = $this->request->getGet('q');
        $customers = $this->customerModel->search($keyword);

        return $this->response->setJSON($customers);
    }

    public function show($id)
    {
        $customer = $this->customerModel->find($id);

        if (!$customer) {
            return redirect()->to('/customer')->with('error', 'Customer tidak ditemukan');
        }

        $transactions = $this->transactionModel->getWithRelations(['customer_id' => $id]);

        $data = [
            'title' => 'Detail Customer',
            'customer' => $customer,
            'transactions' => $transactions,
        ];

        return view('customer/show', $data);
    }
}
