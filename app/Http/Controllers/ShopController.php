<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Http\Service\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShopController extends Controller
{
    protected $product;
    public function __construct(ProductService $productService)
    {
        $this->product = $productService;
    }

    function index() {
//        session()->flush();
        $products = $this->product->all();
        return view('shop.shop',compact('products'));
    }

    function showCart() {
        $cart = Session::get('cart');
        return view('shop.cart.index', compact('cart'));
    }

    public function addToCart($productId)
    {
        $product = $this->product->findOrFail($productId);

        if (Session::has('cart')) {
            $oldCart = Session::get('cart');
        } else {
            $oldCart = null;
        }
        //khoi tao gio hang
        $cart = new Cart($oldCart);
        $cart->add($product, $product->id);

        //luu du lieu gio hang vao session
        Session::put('cart', $cart);
        Session::flash('success', 'Thêm sản phẩm khỏi giỏ hàng thành công');
        return redirect()->back();
    }

    public function removeProductIntoCart($productId)
    {
        if (Session::has('cart')) {
            $oldCart = Session::get('cart');
            if (count($oldCart->items) > 0) {
                $cart = new Cart($oldCart);
                $cart->remove($productId);
                Session::put('cart', $cart);
                Session::flash('success', 'Xóa sản phẩm khỏi giỏ hàng thành công');
            } else {
                Session::flash('delete_error', 'Bạn chưa mua sản phẩm nào');
            }
        } else {
            Session::flash('delete_error', 'Bạn chưa mua sản phẩm nào');
        }
        return redirect()->back();
    }

    function checkOut() {

    }
}
