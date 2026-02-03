<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\SupplierModel;
use App\Models\StockMovementModel;

class Product extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $supplierModel;
    protected $stockMovementModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->supplierModel = new SupplierModel();
        $this->stockMovementModel = new StockMovementModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Daftar Produk',
            'products' => $this->productModel->getWithRelations(),
        ];

        return view('product/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Produk',
            'categories' => $this->categoryModel->findAll(),
            'suppliers' => $this->supplierModel->findAll(),
            'code' => $this->productModel->generateCode(),
        ];

        return view('product/create', $data);
    }

    public function store()
    {
        $rules = [
            'code' => 'required|max_length[50]|is_unique[products.code]',
            'name' => 'required|min_length[2]|max_length[200]',
            'type' => 'required|in_list[sparepart,jasa]',
            'sell_price' => 'required|numeric|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'category_id' => $this->request->getPost('category_id') ?: null,
            'supplier_id' => $this->request->getPost('supplier_id') ?: null,
            'code' => $this->request->getPost('code'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'type' => $this->request->getPost('type'),
            'buy_price' => $this->request->getPost('buy_price') ?: 0,
            'sell_price' => $this->request->getPost('sell_price'),
            'stock' => $this->request->getPost('stock') ?: 0,
            'min_stock' => $this->request->getPost('min_stock') ?: 5,
            'unit' => $this->request->getPost('unit') ?: 'pcs',
            'is_active' => 1,
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            $newName = $image->getRandomName();
            $image->move('uploads/products', $newName);
            $data['image'] = $newName;
        }

        $this->productModel->save($data);

        return redirect()->to('/product')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->to('/product')->with('error', 'Produk tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Produk',
            'product' => $product,
            'categories' => $this->categoryModel->findAll(),
            'suppliers' => $this->supplierModel->findAll(),
        ];

        return view('product/edit', $data);
    }

    public function update($id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->to('/product')->with('error', 'Produk tidak ditemukan');
        }

        $rules = [
            'code' => 'required|max_length[50]|is_unique[products.code,id,' . $id . ']',
            'name' => 'required|min_length[2]|max_length[200]',
            'type' => 'required|in_list[sparepart,jasa]',
            'sell_price' => 'required|numeric|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'category_id' => $this->request->getPost('category_id') ?: null,
            'supplier_id' => $this->request->getPost('supplier_id') ?: null,
            'code' => $this->request->getPost('code'),
            'name' => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'type' => $this->request->getPost('type'),
            'buy_price' => $this->request->getPost('buy_price') ?: 0,
            'sell_price' => $this->request->getPost('sell_price'),
            'min_stock' => $this->request->getPost('min_stock') ?: 5,
            'unit' => $this->request->getPost('unit') ?: 'pcs',
        ];

        // Handle image upload
        $image = $this->request->getFile('image');
        if ($image && $image->isValid() && !$image->hasMoved()) {
            // Delete old image
            if ($product['image'] && file_exists('uploads/products/' . $product['image'])) {
                unlink('uploads/products/' . $product['image']);
            }
            $newName = $image->getRandomName();
            $image->move('uploads/products', $newName);
            $data['image'] = $newName;
        }

        $this->productModel->update($id, $data);

        return redirect()->to('/product')->with('success', 'Produk berhasil diupdate');
    }

    public function delete($id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return redirect()->to('/product')->with('error', 'Produk tidak ditemukan');
        }

        // Delete image
        if ($product['image'] && file_exists('uploads/products/' . $product['image'])) {
            unlink('uploads/products/' . $product['image']);
        }

        $this->productModel->delete($id);

        return redirect()->to('/product')->with('success', 'Produk berhasil dihapus');
    }

    public function search()
    {
        $keyword = $this->request->getGet('q');
        $products = $this->productModel->search($keyword);

        return $this->response->setJSON($products);
    }

    public function lowStock()
    {
        $data = [
            'title' => 'Stok Menipis',
            'products' => $this->productModel->getLowStock(),
        ];

        return view('product/low_stock', $data);
    }
}
