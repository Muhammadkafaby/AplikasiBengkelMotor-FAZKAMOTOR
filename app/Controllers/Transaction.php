<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class Transaction extends BaseController
{
    protected $transactionModel;
    protected $transactionDetailModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
    }

    public function index()
    {
        $filters = [
            'date_from' => $this->request->getGet('date_from'),
            'date_to' => $this->request->getGet('date_to'),
            'customer_id' => $this->request->getGet('customer_id'),
            'status' => $this->request->getGet('status'),
        ];

        $data = [
            'title' => 'Riwayat Transaksi',
            'transactions' => $this->transactionModel->getWithRelations($filters),
            'filters' => $filters,
        ];

        return view('transaction/index', $data);
    }

    public function show($id)
    {
        $transaction = $this->transactionModel->getWithDetails($id);

        if (!$transaction) {
            return redirect()->to('/transaction')->with('error', 'Transaksi tidak ditemukan');
        }

        $data = [
            'title' => 'Detail Transaksi',
            'transaction' => $transaction,
        ];

        return view('transaction/show', $data);
    }

    public function print($id)
    {
        $transaction = $this->transactionModel->getWithDetails($id);

        if (!$transaction) {
            return redirect()->to('/transaction')->with('error', 'Transaksi tidak ditemukan');
        }

        $data = [
            'title' => 'Cetak Struk',
            'transaction' => $transaction,
        ];

        return view('transaction/print', $data);
    }

    public function cancel($id)
    {
        $transaction = $this->transactionModel->find($id);

        if (!$transaction) {
            return redirect()->to('/transaction')->with('error', 'Transaksi tidak ditemukan');
        }

        if ($transaction['status'] !== 'completed') {
            return redirect()->to('/transaction')->with('error', 'Transaksi tidak dapat dibatalkan');
        }

        // Only admin can cancel
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/transaction')->with('error', 'Hanya admin yang dapat membatalkan transaksi');
        }

        $this->transactionModel->update($id, ['status' => 'cancelled']);

        // Restore stock
        $details = $this->transactionDetailModel->getByTransaction($id);
        $productModel = new \App\Models\ProductModel();
        $stockMovementModel = new \App\Models\StockMovementModel();

        foreach ($details as $detail) {
            $product = $productModel->find($detail['product_id']);
            if ($product && $product['type'] === 'sparepart') {
                $currentStock = $product['stock'];
                $newStock = $currentStock + $detail['qty'];

                $productModel->update($detail['product_id'], ['stock' => $newStock]);

                $stockMovementModel->insert([
                    'product_id' => $detail['product_id'],
                    'user_id' => session()->get('user_id'),
                    'type' => 'in',
                    'qty' => $detail['qty'],
                    'stock_before' => $currentStock,
                    'stock_after' => $newStock,
                    'reference' => $transaction['invoice_no'],
                    'note' => 'Pembatalan transaksi - ' . $transaction['invoice_no'],
                ]);
            }
        }

        return redirect()->to('/transaction')->with('success', 'Transaksi berhasil dibatalkan');
    }
}
