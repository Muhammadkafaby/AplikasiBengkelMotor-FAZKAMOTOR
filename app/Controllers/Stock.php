<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\StockMovementModel;

class Stock extends BaseController
{
    protected $productModel;
    protected $stockMovementModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->stockMovementModel = new StockMovementModel();
    }

    public function index()
    {
        $filters = [
            'product_id' => $this->request->getGet('product_id'),
            'type' => $this->request->getGet('type'),
            'date_from' => $this->request->getGet('date_from'),
            'date_to' => $this->request->getGet('date_to'),
        ];

        $data = [
            'title' => 'Riwayat Stok',
            'movements' => $this->stockMovementModel->getWithRelations($filters),
            'products' => $this->productModel->where('type', 'sparepart')->findAll(),
            'filters' => $filters,
        ];

        return view('stock/index', $data);
    }

    public function stockIn()
    {
        $data = [
            'title' => 'Stock In',
            'products' => $this->productModel->where('type', 'sparepart')->where('is_active', 1)->findAll(),
        ];

        return view('stock/stock_in', $data);
    }

    public function processStockIn()
    {
        $rules = [
            'product_id' => 'required|numeric',
            'qty' => 'required|numeric|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $productId = $this->request->getPost('product_id');
        $qty = (int) $this->request->getPost('qty');
        $note = $this->request->getPost('note');
        $userId = session()->get('user_id');

        $result = $this->stockMovementModel->recordMovement(
            $productId,
            $userId,
            'in',
            $qty,
            null,
            $note
        );

        if ($result) {
            return redirect()->to('/stock')->with('success', 'Stock berhasil ditambahkan');
        }

        return redirect()->back()->with('error', 'Gagal menambahkan stock');
    }

    public function stockOut()
    {
        $data = [
            'title' => 'Stock Out',
            'products' => $this->productModel->where('type', 'sparepart')->where('is_active', 1)->findAll(),
        ];

        return view('stock/stock_out', $data);
    }

    public function processStockOut()
    {
        $rules = [
            'product_id' => 'required|numeric',
            'qty' => 'required|numeric|greater_than[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $productId = $this->request->getPost('product_id');
        $qty = (int) $this->request->getPost('qty');
        $note = $this->request->getPost('note');
        $userId = session()->get('user_id');

        // Check stock availability
        $product = $this->productModel->find($productId);
        if ($product['stock'] < $qty) {
            return redirect()->back()->withInput()->with('error', 'Stok tidak mencukupi. Stok tersedia: ' . $product['stock']);
        }

        $result = $this->stockMovementModel->recordMovement(
            $productId,
            $userId,
            'out',
            $qty,
            null,
            $note
        );

        if ($result) {
            return redirect()->to('/stock')->with('success', 'Stock berhasil dikurangi');
        }

        return redirect()->back()->with('error', 'Gagal mengurangi stock');
    }

    public function adjustment()
    {
        $data = [
            'title' => 'Stock Adjustment',
            'products' => $this->productModel->where('type', 'sparepart')->where('is_active', 1)->findAll(),
        ];

        return view('stock/adjustment', $data);
    }

    public function processAdjustment()
    {
        $rules = [
            'product_id' => 'required|numeric',
            'actual_stock' => 'required|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $productId = $this->request->getPost('product_id');
        $actualStock = (int) $this->request->getPost('actual_stock');
        $note = $this->request->getPost('note');
        $userId = session()->get('user_id');

        $product = $this->productModel->find($productId);
        $currentStock = $product['stock'];
        $difference = $actualStock - $currentStock;

        if ($difference === 0) {
            return redirect()->back()->with('info', 'Stok sudah sesuai, tidak ada perubahan');
        }

        $type = $difference > 0 ? 'in' : 'out';
        $qty = abs($difference);

        // Record movement
        $this->stockMovementModel->insert([
            'product_id' => $productId,
            'user_id' => $userId,
            'type' => 'adjustment',
            'qty' => $difference,
            'stock_before' => $currentStock,
            'stock_after' => $actualStock,
            'note' => $note ?: 'Stock adjustment',
        ]);

        // Update product stock
        $this->productModel->update($productId, ['stock' => $actualStock]);

        return redirect()->to('/stock')->with('success', 'Stock adjustment berhasil');
    }
}
