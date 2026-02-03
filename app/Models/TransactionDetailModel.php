<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionDetailModel extends Model
{
    protected $table = 'transaction_details';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'transaction_id',
        'product_id',
        'product_name',
        'qty',
        'price',
        'discount',
        'subtotal'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $skipValidation = true;

    /**
     * Get details by transaction
     */
    public function getByTransaction(int $transactionId): array
    {
        return $this->select('fm_transaction_details.*, fm_products.code as product_code, fm_products.unit')
            ->join('fm_products', 'fm_products.id = fm_transaction_details.product_id', 'left')
            ->where('transaction_id', $transactionId)
            ->findAll();
    }

    /**
     * Get best selling products
     */
    public function getBestSelling(int $limit = 5): array
    {
        return $this->select('fm_products.id, fm_products.code, fm_products.name, fm_products.image, SUM(fm_transaction_details.qty) as total_sold, SUM(fm_transaction_details.subtotal) as total_revenue')
            ->join('fm_products', 'fm_products.id = fm_transaction_details.product_id')
            ->join('fm_transactions', 'fm_transactions.id = fm_transaction_details.transaction_id')
            ->where('fm_transactions.status', 'completed')
            ->groupBy('fm_products.id')
            ->orderBy('total_sold', 'DESC')
            ->findAll($limit);
    }
}
