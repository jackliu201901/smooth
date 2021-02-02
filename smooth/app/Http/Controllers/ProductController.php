<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

/**
 * @class        ProductController
 * @brief        Product Controller
 *
 * @author
 * @copyright (C) 2021 Smooth
 *
 * @version       1.0
 * @date          2021-01-27
 */
class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth'])->only(['createProduct', 'updateProduct','deleteProduct']);
    }

    /**
     * @name Product List
     * @brief       Product List
     * @param   object $product
     *
     * @return json
     * @author        Liu
     * @date          2021-01-27
     */
    public function productList(Product $product)
    {
        return response()->json(
            [
                'code' => '1',
                'msg' => 'ok',
                'data' => $product
            ],
            200,
        );
    }

    /**
     * @name getOneProduct
     * @brief    retrieve a single product
     * @param   object $request
     *
     * @return json
     * @author        Liu
     * @date          2021-01-27
     */
    public function getOneProduct(Request $request)
    {
        $productId = $request->get('id');
        $perPage = $request->post('per_page', 10);

        $products = Product::latest()->Where('id', $productId)->paginate($perPage);

        return response()->json(
            [
                'code' => '1',
                'msg' => 'ok',
                'data' => [
                    'products' =>$products
                ]
            ],
            200,
            );
    }

    /**
     * @name create Product
     * @brief    create Product
     * @param   object $request
     *
     * @return json
     * @author        Liu
     * @date          2021-01-27
     */
    public function createProduct(Request $request)
    {
        $productName = $request->post('productName');
        $category = $request->post('category');
        $sku = $request->post('sku');
        $price = $request->post('price');

        $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
            'sku' => 'required',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        $insertData = [
            'name' => $productName,
            'category' => $category,
            'sku' => $sku,
            'price' => $price,
            'create_at' =>  date('Y-m-d H:i:s'),
            'update_at' => date('Y-m-d H:i:s'),
        ];

        $product = Product::create($insertData);
        $lastProductId = $product -> id;

        if($lastProductId > 0){

            $returnData = [
                'code' => '1',
                'msg' => 'ok',
                'data' => [
                    'product_id' => $lastProductId
                ]
            ];
        }
        else{

            $returnData = [
                'code' => '2',
                'msg' => 'error',
                'data' => [
                    'product_id' => 0
                ]
            ];
        }

        return response()->json( $returnData,200);
    }

    /**
     * @name update Product
     * @brief    Allow the API users to update one or more attributes of a product at once
     * @param   object $request
     *
     * @return json
     * @author        Liu
     * @date          2021-01-27
     */
    public function updateProduct(Request $request)
    {
        $productId = $request->post('id');
        $productName = $request->post('name');
        $sku = $request->post('sku');
        $category = $request->post('category');
        $price = $request->post('price');

        $this->validate($request, [
            'name' => 'required',
            'category' => 'required',
            'sku' => 'required',
            'price' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ]);

        $updateData = [
            'name' => $productName,
            'category' => $category,
            'sku' => $sku,
            'price' => $price,
            'update_at' => date('Y-m-d H:i:s'),
        ];

        $updateRes = Product::where('id', $productId)
            ->update($updateData);

        if($updateRes > 0){

            $returnData = [
                'code' => '1',
                'msg' => 'ok',
                'data' => [
                    'product_id' => $productId
                ]
            ];
        }
        else
        {
            $returnData = [
                'code' => '2',
                'msg' => 'error',
                'data' => [
                    'product_id' => 0
                ]
            ];
        }


        return response()->json( $returnData,200);
    }

    /**
     * @name deleteProduct
     * @brief   delete Product
     * @param   object $request,$product
     *
     * @return json
     * @author        Liu
     * @date          2021-01-27
     */
    public function deleteProduct(Request $request,Product $product)
    {

        $this->authorize('delete', $product);

        $productId = $request->post('productId');

        $delResult = $product->where('id', '=', $productId)->delete();


        if($delResult  === 1){

            $returnData = [
                'code' => '1',
                'msg' => 'ok',
                'data' => [
                    'product_id' => $productId
                ]
            ];
        }
        else
        {
            $returnData = [
                'code' => '2',
                'msg' => 'error',
                'data' => [
                    'product_id' => $productId
                ]
            ];
        }

        return response()->json( $returnData,200);
    }
}
