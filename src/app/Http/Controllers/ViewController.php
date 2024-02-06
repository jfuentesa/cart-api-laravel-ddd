<?php

namespace App\Http\Controllers;

use App\CartAPI\Domain\Enum\Products;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Container\BindingResolutionException;

/**
 * Vista principal
 */
class ViewController extends Controller
{
    /**
     * Index de la página
     * @return View|Factory
     */
    public function index()
    {
        $products = (new Products())->getProducts();

        return view('store', [
            "products" => $products
        ]);
    }
}
