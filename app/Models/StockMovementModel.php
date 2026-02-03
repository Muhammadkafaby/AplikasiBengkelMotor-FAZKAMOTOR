<?php

namespace App\Models;

use CodeIgniter\Model;

class StockMovementModel extends Model
{
    protected $table = 'stock_movements';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'product_id',
        'user_id',
        'type',
        'qty',
        'stock_before',
        'stock_after',
        'reference',
        'note'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $skipValidation = true;

    /**
     * Get movements with relations
     */
    public function getWithRelations(array $filters = [])
    {
        $builder = $this->select('stock_movements.*, products.code as product_code, products.name as product_name, users.name as user_name')
            ->join('products', 'products.id = stock_movements.product_id')
            ->join('users', 'users.id = stock_movements.user_id');

        if (!empty($filters['product_id'])) {
            $builder->where('stock_movements.product_id', $filters['product_id']);
        }

        if (!empty($filters['type'])) {
            $builder->where('stock_movements.type', $filters['type']);
        }

        if (!empty($filters['date_from'])) {
            $builder->where('DATE(stock_movements.created_at) >=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $builder->where('DATE(stock_movements.created_at) <=', $filters['date_to']);
        }

        return $builder->orderBy('stock_movements.created_at', 'DESC')->findAll();
    }

    /**
     * Record stock movement
     */
    public function recordMovement(int $productId, int $userId, string $type, int $qty, string $reference = null, string $note = null): bool
    {
        $productModel = new ProductModel();
        $product = $productModel->find($productId);

        if (!$product) {
            return false;
        }

        $stockBefore = $product['stock'];
        $stockAfter = $type === 'in' ? $stockBefore + $qty : $stockBefore - $qty;

        if ($stockAfter < 0) {
            return false;
        }

        // Update product stock
        $productModel->update($productId, ['stock' => $stockAfter]);

        // Record movement
        return $this->insert([
            'product_id' => $productId,
            'user_id' => $userId,
            'type' => $type,
            'qty' => $qty,
            'stock_before' => $stockBefore,
            'stock_after' => $stockAfter,
            'reference' => $reference,
            'note' => $note,
        ]);
    }
}
