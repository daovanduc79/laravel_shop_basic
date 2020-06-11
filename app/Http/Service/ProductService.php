<?php


namespace App\Http\Service;


use App\Http\Repository\ProductRepository;
use App\Product;

class ProductService extends Service
{
    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct($productRepository);
    }

    public function create($request)
    {
        $product = $this->repository->create();
        $product->product_code = $request->product_code;
        $product->origination = $request->origination;
        $product->fur_color = $request->fur_color;
        $product->weight = $request->weight;
        $product->longevity = $request->longevity;
        $product->characteristics = $request->characteristics;

        if ($request->hasFile('image')) {
            $file = $request->image;
            $path = $file->store('images', 'public');
            $product->image = $path;
        } else {
            $product->image = 'images/default.png';
        }

        return $product;
    }

    public function update($id , $request)
    {
        $product = Product::findOrFail($id);
        $product->product_code = $request->product_code;
        $product->origination = $request->origination;
        $product->fur_color = $request->fur_color;
        $product->weight = $request->weight;
        $product->longevity = $request->longevity;
        $product->characteristics = $request->characteristics;

        if ($request->hasFile('image')) {
            $file = $request->image;
            $path = $file->store('images', 'public');
            $product->image = $path;
        } else {
            $product->image = 'images/default.png';
        }

        $this->save($product);
    }

    public function delete($id)
    {
        return parent::delete($id); // TODO: Change the autogenerated stub
    }
}
