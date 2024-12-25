<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\VariantModel;

class ProductController extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $variantModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->variantModel = new VariantModel();
    }

    // Index - View all products
    public function index(): string
    {
        // Fetch products with categories
        $products = $this->productModel->getProductsWithCategory();

        // Fetch variants for each product
        foreach ($products as &$product) {
            $product['variants'] = $this->productModel->getProductVariants($product['id']);
        }

        return view('products/index', ['products' => $products]);
    }

    // Create - Show form to add a new product
    public function create(): string
    {
        $categories = $this->categoryModel->findAll();
        $variants = $this->variantModel->findAll();
        return view('products/create', ['categories' => $categories, 'variants' => $variants]);
    }

    // Store - Save the new product
    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'        => 'required|min_length[3]',
            'description' => 'permit_empty',
            'price'       => 'required|decimal',
            'category_id' => 'required|integer',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Save product data
        $productData = [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'category_id' => $this->request->getPost('category_id'),
        ];
        $productId = $this->productModel->insert($productData);  // Save product and get its ID

        // Save product variants
        $variantIds = $this->request->getPost('variants');
        if ($variantIds) {
            $this->productModel->saveProductVariants($productId, $variantIds);  // Save variants for the product
        }

        return redirect()->to('/products')->with('success', 'Product added successfully.');
    }

    // Edit - Show form to edit an existing product
    public function edit($id)
    {
        $product = $this->productModel->find($id);
        
        if ($product) {
            $categories = $this->categoryModel->findAll();
            $variants = $this->variantModel->findAll();
            $productVariants = $this->productModel->getProductVariants($id);

            return view('products/edit', [
                'product' => $product,
                'categories' => $categories,
                'variants' => $variants,
                'productVariants' => $productVariants
            ]);
        } else {
            return redirect()->to('/products')->with('error', 'Product not found.');
        }
    }

    // Update - Save the updated product data
    public function update($id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name'        => 'required|min_length[3]',
            'description' => 'permit_empty',
            'price'       => 'required|decimal',
            'category_id' => 'required|integer',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        // Update product data
        $productData = [
            'name'        => $this->request->getPost('name'),
            'description' => $this->request->getPost('description'),
            'price'       => $this->request->getPost('price'),
            'category_id' => $this->request->getPost('category_id'),
        ];
        $this->productModel->update($id, $productData);

        // Update product variants
        $variantIds = $this->request->getPost('variants');
        if ($variantIds) {
            $this->productModel->saveProductVariants($id, $variantIds);  // Update variants for the product
        }

        return redirect()->to('/products')->with('success', 'Product updated successfully.');
    }
    public function delete($id)
    {
        // Log product ID for debugging
        log_message('debug', "Attempting to delete product with ID: $id");
    
        // Check if the product exists
        $product = $this->productModel->find($id);
    
        if ($product) {
            log_message('debug', "Product found: " . json_encode($product));
    
            // Delete the product (associated variants will be deleted via ON DELETE CASCADE)
            if ($this->productModel->delete($id)) {
                return redirect()->to('/products');
            }
        }
    }

}    