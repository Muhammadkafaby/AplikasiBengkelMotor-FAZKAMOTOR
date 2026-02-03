<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'category_id',
        'supplier_id',
        'code',
        'name',
        'description',
        'type',
        'buy_price',
        'sell_price',
        'stock',
        'min_stock',
        'unit',
        'image',
        'is_active'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'code' => 'required|max_length[50]|is_unique[products.code,id,{id}]',
        'name' => 'required|min_length[2]|max_length[200]',
        'type' => 'required|in_list[sparepart,jasa]',
        'sell_price' => 'required|numeric|greater_than[0]',
        'buy_price' => 'permit_empty|numeric|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'code' => [
            'required' => 'Kode produk wajib diisi',
            'is_unique' => 'Kode produk sudah digunakan',
        ],
        'name' => [
            'required' => 'Nama produk wajib diisi',
        ],
        'sell_price' => [
            'required' => 'Harga jual wajib diisi',
            'greater_than' => 'Harga jual harus lebih dari 0',
        ],
    ];

    protected $skipValidation = false;

    /**
     * Get products with category and supplier names
     */
    public function getWithRelations()
    {
        return $this->select('fm_products.*, fm_categories.name as category_name, fm_suppliers.name as supplier_name')
            ->join('fm_categories', 'fm_categories.id = fm_products.category_id', 'left')
            ->join('fm_suppliers', 'fm_suppliers.id = fm_products.supplier_id', 'left')
            ->where('fm_products.is_active', 1)
            ->findAll();
    }

    /**
     * Get products with low stock
     */
    public function getLowStock()
    {
        return $this->select('fm_products.*, fm_categories.name as category_name')
            ->join('fm_categories', 'fm_categories.id = fm_products.category_id', 'left')
            ->where('fm_products.type', 'sparepart')
            ->where('fm_products.stock <=', 'fm_products.min_stock', false)
            ->where('fm_products.is_active', 1)
            ->findAll();
    }

    /**
     * Search products by code or name
     */
    public function search(string $keyword, int $limit = 10)
    {
        return $this->select('fm_products.*, fm_categories.name as category_name')
            ->join('fm_categories', 'fm_categories.id = fm_products.category_id', 'left')
            ->where('fm_products.is_active', 1)
            ->groupStart()
            ->like('fm_products.code', $keyword)
            ->orLike('fm_products.name', $keyword)
            ->groupEnd()
            ->findAll($limit);
    }

    /**
     * Get products by category
     */
    public function getByCategory(int $categoryId)
    {
        return $this->where('category_id', $categoryId)
            ->where('is_active', 1)
            ->findAll();
    }

    /**
     * Generate unique product code
     */
    public function generateCode(string $prefix = 'PRD'): string
    {
        $lastProduct = $this->like('code', $prefix, 'after')
            ->orderBy('id', 'DESC')
            ->first();

        if ($lastProduct) {
            $lastNumber = (int) substr($lastProduct['code'], strlen($prefix));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }

    /**
     * Update stock
     */
    public function updateStock(int $productId, int $qty, string $type = 'out'): bool
    {
        $product = $this->find($productId);
        if (!$product) {
            return false;
        }

        $newStock = $type === 'in'
            ? $product['stock'] + $qty
            : $product['stock'] - $qty;

        if ($newStock < 0) {
            return false;
        }

        return $this->update($productId, ['stock' => $newStock]);
    }
}
