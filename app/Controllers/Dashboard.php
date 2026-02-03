<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\ProductModel;
use App\Models\CustomerModel;

class Dashboard extends BaseController
{
    protected $transactionModel;
    protected $transactionDetailModel;
    protected $productModel;
    protected $customerModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
        $this->transactionDetailModel = new TransactionDetailModel();
        $this->productModel = new ProductModel();
        $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'todaySales' => $this->transactionModel->getTodaySales(),
            'monthlySales' => $this->transactionModel->getMonthlySales(),
            'todayProfit' => $this->transactionModel->getTodayProfit(),
            'monthlyProfit' => $this->transactionModel->getMonthlyProfit(),
            'lowStock' => $this->productModel->getLowStock(),
            'bestSelling' => $this->transactionDetailModel->getBestSelling(5),
            'chartData' => $this->transactionModel->getSalesChartData(7),
            'totalProducts' => $this->productModel->where('is_active', 1)->countAllResults(),
            'totalCustomers' => $this->customerModel->countAllResults(),
            'recentTransactions' => $this->transactionModel->getWithRelations(['status' => 'completed']),
        ];

        // Limit recent transactions
        $data['recentTransactions'] = array_slice($data['recentTransactions'], 0, 5);

        return view('dashboard/index', $data);
    }
}
