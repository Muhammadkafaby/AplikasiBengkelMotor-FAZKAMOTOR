<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['name', 'description'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'name' => 'required|min_length[2]|max_length[100]',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'Nama kategori wajib diisi',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Get category with product count
     */
    public function getWithProductCount()
    {
        return $this->select('fm_categories.*, COUNT(fm_products.id) as product_count')
            ->join('fm_products', 'fm_products.category_id = fm_categories.id', 'left')
            ->groupBy('fm_categories.id')
            ->findAll();
    }
}
