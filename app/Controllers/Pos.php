<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CustomerModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\StockMovementModel;

class Pos extends BaseController
{
    protected $productModel;
    protected $customerModel;
    protected $transactionModel;
    protected $transactionDetailModel;
    protected $stockMovementModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->customerModel = new CustomerModel();
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
        $this->stockMovementModel = new StockMovementModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Kasir - POS',
            'products' => $this->productModel->getWithRelations(),
            'customers' => $this->customerModel->findAll(),
        ];

        return view('pos/index', $data);
    }

    public function searchProduct()
    {
        $keyword = $this->request->getGet('q');
        $products = $this->productModel->search($keyword, 20);

        return $this->response->setJSON([
            'success' => true,
            'data' => $products,
        ]);
    }

    public function searchCustomer()
    {
        $keyword = $this->request->getGet('q');
        $customers = $this->customerModel->search($keyword);

        return $this->response->setJSON([
            'success' => true,
            'data' => $customers,
        ]);
    }

    public function getProduct($id)
    {
        $product = $this->productModel->find($id);

        if (!$product) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Produk tidak ditemukan',
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $product,
        ]);
    }

    public function processTransaction()
    {
        $cartData = $this->request->getJSON(true);

        if (empty($cartData['items'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Keranjang masih kosong',
            ]);
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Generate invoice number
            $invoiceNo = $this->transactionModel->generateInvoiceNo();

            // Calculate totals
            $total = 0;
            foreach ($cartData['items'] as $item) {
                $total += $item['subtotal'];
            }

            $discount = (float) ($cartData['discount'] ?? 0);
            $tax = (float) ($cartData['tax'] ?? 0);
            $grandTotal = $total - $discount + $tax;
            $paid = (float) ($cartData['paid'] ?? $grandTotal);
            $change = $paid - $grandTotal;

            // Create transaction
            $transactionData = [
                'invoice_no' => $invoiceNo,
                'customer_id' => $cartData['customer_id'] ?: null,
                'user_id' => session()->get('user_id'),
                'total' => $total,
                'discount' => $discount,
                'tax' => $tax,
                'grand_total' => $grandTotal,
                'paid' => $paid,
                'change_amount' => $change,
                'payment_method' => $cartData['payment_method'] ?? 'cash',
                'status' => 'completed',
                'notes' => $cartData['notes'] ?? null,
            ];

            $this->transactionModel->insert($transactionData);
            $transactionId = $this->transactionModel->getInsertID();

            // Insert transaction details and update stock
            foreach ($cartData['items'] as $item) {
                $product = $this->productModel->find($item['product_id']);

                // Insert detail
                $this->transactionDetailModel->insert([
                    'transaction_id' => $transactionId,
                    'product_id' => $item['product_id'],
                    'product_name' => $product['name'],
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'discount' => $item['discount'] ?? 0,
                    'subtotal' => $item['subtotal'],
                ]);

                // Update stock for sparepart type
                if ($product['type'] === 'sparepart') {
                    $currentStock = $product['stock'];
                    $newStock = $currentStock - $item['qty'];

                    $this->productModel->update($item['product_id'], ['stock' => $newStock]);

                    // Record stock movement
                    $this->stockMovementModel->insert([
                        'product_id' => $item['product_id'],
                        'user_id' => session()->get('user_id'),
                        'type' => 'sale',
                        'qty' => $item['qty'],
                        'stock_before' => $currentStock,
                        'stock_after' => $newStock,
                        'reference' => $invoiceNo,
                        'note' => 'Penjualan - ' . $invoiceNo,
                    ]);
                }
            }

            $db->transCommit();

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Transaksi berhasil',
                'transaction_id' => $transactionId,
                'invoice_no' => $invoiceNo,
            ]);

        } catch (\Exception $e) {
            $db->transRollback();

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    public function addCustomer()
    {
        $name = $this->request->getPost('name');
        $phone = $this->request->getPost('phone');

        $this->customerModel->insert([
            'name' => $name,
            'phone' => $phone,
        ]);

        $customerId = $this->customerModel->getInsertID();

        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'id' => $customerId,
                'name' => $name,
                'phone' => $phone,
            ],
        ]);
    }
}
