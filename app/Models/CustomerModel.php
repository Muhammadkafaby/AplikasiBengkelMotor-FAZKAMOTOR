<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['name', 'phone', 'email', 'address'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
        'phone' => 'permit_empty|max_length[20]',
        'email' => 'permit_empty|valid_email',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama customer wajib diisi',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Get customer with transaction count and total spent
     */
    public function getWithTransactionStats()
    {
        return $this->select('fm_customers.*, COUNT(fm_transactions.id) as transaction_count, COALESCE(SUM(fm_transactions.grand_total), 0) as total_spent')
            ->join('fm_transactions', 'fm_transactions.customer_id = fm_customers.id', 'left')
            ->groupBy('fm_customers.id')
            ->findAll();
    }

    /**
     * Search customers by name or phone
     */
    public function search(string $keyword)
    {
        return $this->like('name', $keyword)
            ->orLike('phone', $keyword)
            ->findAll(10);
    }
}
