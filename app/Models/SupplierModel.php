<?php

namespace App\Models;

use CodeIgniter\Model;

class SupplierModel extends Model
{
    protected $table = 'suppliers';
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
            'required' => 'Nama supplier wajib diisi',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Get supplier with product count
     */
    public function getWithProductCount()
    {
        return $this->select('fm_suppliers.*, COUNT(fm_products.id) as product_count')
            ->join('fm_products', 'fm_products.supplier_id = fm_suppliers.id', 'left')
            ->groupBy('fm_suppliers.id')
            ->findAll();
    }
}
