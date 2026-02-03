<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\ProductModel;
use App\Models\StockMovementModel;
use Dompdf\Dompdf;

class Report extends BaseController
{
    protected $transactionModel;
    protected $transactionDetailModel;
    protected $productModel;
    protected $stockMovementModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
        $this->productModel = new ProductModel();
        $this->stockMovementModel = new StockMovementModel();
    }

    public function sales()
    {
        $dateFrom = $this->request->getGet('date_from') ?: date('Y-m-01');
        $dateTo = $this->request->getGet('date_to') ?: date('Y-m-d');

        $transactions = $this->transactionModel->getWithRelations([
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'status' => 'completed',
        ]);

        $totalSales = array_sum(array_column($transactions, 'grand_total'));
        $totalTransactions = count($transactions);

        $data = [
            'title' => 'Laporan Penjualan',
            'transactions' => $transactions,
            'totalSales' => $totalSales,
            'totalTransactions' => $totalTransactions,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ];

        return view('report/sales', $data);
    }

    public function stock()
    {
        $products = $this->productModel->select('fm_products.*, fm_categories.name as category_name')
            ->join('fm_categories', 'fm_categories.id = fm_products.category_id', 'left')
            ->where('fm_products.type', 'sparepart')
            ->where('fm_products.is_active', 1)
            ->findAll();

        $totalValue = 0;
        foreach ($products as $product) {
            $totalValue += $product['stock'] * $product['buy_price'];
        }

        $data = [
            'title' => 'Laporan Stok',
            'products' => $products,
            'totalValue' => $totalValue,
        ];

        return view('report/stock', $data);
    }

    public function bestSelling()
    {
        $dateFrom = $this->request->getGet('date_from') ?: date('Y-m-01');
        $dateTo = $this->request->getGet('date_to') ?: date('Y-m-d');

        $products = $this->transactionDetailModel
            ->select('fm_products.id, fm_products.code, fm_products.name, fm_products.image, SUM(fm_transaction_details.qty) as total_sold, SUM(fm_transaction_details.subtotal) as total_revenue')
            ->join('fm_products', 'fm_products.id = fm_transaction_details.product_id')
            ->join('fm_transactions', 'fm_transactions.id = fm_transaction_details.transaction_id')
            ->where('fm_transactions.status', 'completed')
            ->where('DATE(fm_transactions.created_at) >=', $dateFrom)
            ->where('DATE(fm_transactions.created_at) <=', $dateTo)
            ->groupBy('fm_products.id')
            ->orderBy('total_sold', 'DESC')
            ->findAll(20);

        $data = [
            'title' => 'Produk Terlaris',
            'products' => $products,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ];

        return view('report/best_selling', $data);
    }

    public function exportSalesPdf()
    {
        $dateFrom = $this->request->getGet('date_from') ?: date('Y-m-01');
        $dateTo = $this->request->getGet('date_to') ?: date('Y-m-d');

        $transactions = $this->transactionModel->getWithRelations([
            'date_from' => $dateFrom,
            'date_to' => $dateTo,
            'status' => 'completed',
        ]);

        $totalSales = array_sum(array_column($transactions, 'grand_total'));
        $totalTransactions = count($transactions);

        $data = [
            'title' => 'Laporan Penjualan',
            'transactions' => $transactions,
            'totalSales' => $totalSales,
            'totalTransactions' => $totalTransactions,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
        ];

        $html = view('report/sales_pdf', $data);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return $this->response
            ->setHeader('Content-Type', 'application/pdf')
            ->setBody($dompdf->output());
    }

    public function exportStockExcel()
    {
        $products = $this->productModel->select('fm_products.*, fm_categories.name as category_name')
            ->join('fm_categories', 'fm_categories.id = fm_products.category_id', 'left')
            ->where('fm_products.type', 'sparepart')
            ->where('fm_products.is_active', 1)
            ->findAll();

        $filename = 'laporan_stok_' . date('Y-m-d') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Header
        fputcsv($output, ['Kode', 'Nama Produk', 'Kategori', 'Stok', 'Min Stok', 'Satuan', 'Harga Beli', 'Harga Jual', 'Nilai Stok']);

        foreach ($products as $product) {
            fputcsv($output, [
                $product['code'],
                $product['name'],
                $product['category_name'] ?? '-',
                $product['stock'],
                $product['min_stock'],
                $product['unit'],
                $product['buy_price'],
                $product['sell_price'],
                $product['stock'] * $product['buy_price'],
            ]);
        }

        fclose($output);
        exit;
    }
}
