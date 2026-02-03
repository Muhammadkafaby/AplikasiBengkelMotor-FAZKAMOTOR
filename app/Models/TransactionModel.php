<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'transactions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'invoice_no',
        'customer_id',
        'user_id',
        'total',
        'discount',
        'tax',
        'grand_total',
        'paid',
        'change_amount',
        'payment_method',
        'status',
        'notes'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $skipValidation = true;

    /**
     * Generate invoice number
     */
    public function generateInvoiceNo(): string
    {
        $prefix = 'INV' . date('Ymd');
        $lastTransaction = $this->like('invoice_no', $prefix, 'after')
            ->orderBy('id', 'DESC')
            ->first();

        if ($lastTransaction) {
            $lastNumber = (int) substr($lastTransaction['invoice_no'], -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get transactions with relations
     */
    public function getWithRelations(array $filters = [])
    {
        $builder = $this->select('fm_transactions.*, fm_customers.name as customer_name, fm_users.name as cashier_name')
            ->join('fm_customers', 'fm_customers.id = fm_transactions.customer_id', 'left')
            ->join('fm_users', 'fm_users.id = fm_transactions.user_id', 'left');

        if (!empty($filters['date_from'])) {
            $builder->where('DATE(fm_transactions.created_at) >=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $builder->where('DATE(fm_transactions.created_at) <=', $filters['date_to']);
        }

        if (!empty($filters['customer_id'])) {
            $builder->where('fm_transactions.customer_id', $filters['customer_id']);
        }

        if (!empty($filters['status'])) {
            $builder->where('fm_transactions.status', $filters['status']);
        }

        return $builder->orderBy('fm_transactions.created_at', 'DESC')->findAll();
    }

    /**
     * Get today's sales
     */
    public function getTodaySales(): array
    {
        $today = date('Y-m-d');
        $result = $this->selectSum('grand_total', 'total')
            ->selectCount('id', 'count')
            ->where('DATE(created_at)', $today)
            ->where('status', 'completed')
            ->first();

        return [
            'total' => (float) ($result['total'] ?? 0),
            'count' => (int) ($result['count'] ?? 0),
        ];
    }

    /**
     * Get monthly sales
     */
    public function getMonthlySales(): array
    {
        $month = date('Y-m');
        $result = $this->selectSum('grand_total', 'total')
            ->selectCount('id', 'count')
            ->where('DATE_FORMAT(created_at, "%Y-%m")', $month)
            ->where('status', 'completed')
            ->first();

        return [
            'total' => (float) ($result['total'] ?? 0),
            'count' => (int) ($result['count'] ?? 0),
        ];
    }

    /**
     * Get sales chart data (last 7 days)
     */
    public function getSalesChartData(int $days = 7): array
    {
        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days"));
            $result = $this->selectSum('grand_total', 'total')
                ->where('DATE(created_at)', $date)
                ->where('status', 'completed')
                ->first();

            $data[] = [
                'date' => date('d M', strtotime($date)),
                'total' => (float) ($result['total'] ?? 0),
            ];
        }

        return $data;
    }

    /**
     * Get transaction with details
     */
    public function getWithDetails(int $id): ?array
    {
        $transaction = $this->select('fm_transactions.*, fm_customers.name as customer_name, fm_customers.phone as customer_phone, fm_users.name as cashier_name')
            ->join('fm_customers', 'fm_customers.id = fm_transactions.customer_id', 'left')
            ->join('fm_users', 'fm_users.id = fm_transactions.user_id', 'left')
            ->find($id);

        if (!$transaction) {
            return null;
        }

        $detailModel = new TransactionDetailModel();
        $transaction['details'] = $detailModel->getByTransaction($id);

        return $transaction;
    }
}
