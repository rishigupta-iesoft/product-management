<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'description', 'price', 'category_id'];
    protected $validationRules = [
        'name' => 'required|min_length[3]',
        'description' => 'permit_empty',
        'price' => 'required|decimal',
        'category_id' => 'required|integer',
    ];

    public function getProductsWithCategory()
    {
        return $this->db->table('products')
            ->select('products.id, products.name, products.description, products.price, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id')
            ->get()
            ->getResultArray();
    }

    public function getVariants()
    {
        return $this->db->table('variants')
            ->select('id, name')
            ->get()
            ->getResultArray();
    }

    public function getProductVariants($productId)
    {
        return $this->db->table('product_variants')
            ->select('variants.name as variant_name')
            ->join('variants', 'variants.id = product_variants.variant_id')
            ->where('product_variants.product_id', $productId)
            ->get()
            ->getResultArray();
    }

    public function saveProductVariants($productId, $variantIds)
    {
        $this->db->table('product_variants')
            ->where('product_id', $productId)
            ->delete();

        $data = [];
        foreach ($variantIds as $variantId) {
            $data[] = [
                'product_id' => $productId,
                'variant_id' => $variantId,
            ];
        }

        return $this->db->table('product_variants')->insertBatch($data);
    }

    public function saveVariant($variantName)
    {
        $data = ['name' => $variantName];
        return $this->db->table('variants')->insert($data);
    }
}
