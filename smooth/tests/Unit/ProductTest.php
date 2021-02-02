<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\UnitTester;
use App\Dao\ProductDao;
use App\Dao\ProductClassDao;

/**
 * @class         ProductTest
 * @brief         PHPUnit Test class for Product
 *
 * @author        Changhu,Liu
 * @copyright (C) 2021 Smooth
 *
 * @version       1.0
 * @date          2021-01-27
 */
class ProductTest extends TestCase
{

    /**
     * @name testListAllProduct
     * @brief         Test ListAllProduct
     *
     * @author        Liu
     * @date           2021-01-27
     */
    function testProductList(UnitTester $Unit)
    {
        $firstProduct  = [
                "name" => "Jack-test",
                "category" => "category-jack",
                "sku" => "DISH775TGHY",
                "price" => 20,
                "add_time" => "2021-01-28 10:38:28",
                "last_update_time" => "2021-01-28 10:38:28"
        ];

        $Unit->haveRecord(Product::class, $firstProduct);

        $productDao = new ProductDao();
        $productList =  $productDao->productList();

        $this->assertContains( $firstProduct, $productList['data'] );

        $secondProduct  = [
            "name" => "Liu-test",
            "category" => "China, Meat, Beef, Fish, Tofu, Sichuan pepper",
            "sku" => "DISH234ZFDR",
            "price" => 11.99,
            "add_time" => "2021-01-28 11:38:28",
            "last_update_time" => "2021-01-28 11:38:28"
        ];
        $Unit->haveRecord(Product::class, $secondProduct);
        $productList =  $productDao->productList();
        $this->assertContains( $secondProduct, $productList['data']);

    }

    /**
     * @name testcategoryList
     * @brief         Test categoryList
     *
     * @author        Liu
     * @date         2021-01-27
     */
    function testcategoryList(UnitTester $Unit)
    {
        $firstCategory  = [
            "gc_id" => 10001,
            "gc_name" => "liu"
        ];

        $Unit->haveRecord(Product::class, $firstCategory);

        $productClassDao = new ProductClassDao();
        $categoryList = $productClassDao->categoryList();

        $this->assertContains( $firstCategory, $categoryList['data'] );

        $secondCategory  = [
            "gc_id" => 10002,
            "gc_name" => "changhu"
        ];
        $Unit->haveRecord(Product::class, $secondCategory);
        $categoryList =  $productClassDao->productList();
        $this->assertContains( $secondCategory, $categoryList['data']);
    }


    /**
     * @name testProductSearch
     * @brief         Test productSearch
     *
     * @author        Liu
     * @date           2021-01-27
     */
    function testProductSearch(UnitTester $Unit)
    {
        $Expection  = [
            "name" => "Jack-test",
            "category" => 2,
            "sku" => "DISH775TGHY",
            "price" => 20,
            "add_time" => "2021-01-28 10:38:28",
            "last_update_time" => "2021-01-28 10:38:28"
        ];
        $product = new Product();
        $product->createProduct($Expection);

        $result = $product->productSearch("Jack-test");

        $this->assertEquals('ok',$result['msg']);
    }


    /**
     * @name testCreateProduct
     * @brief         Test CreateProduct
     *
     * @author        Liu
     * @date           2021-01-27
     */
    function testCreateProduct(UnitTester $Unit)
    {
        $Expection  = [
            "name" => "Jack-test",
            "category" => 2,
            "sku" => "DISH775TGHY",
            "price" => 20
        ];

        $product = new Product();

        $product->createProduct($Expection);

        $result = $product->productSearch("Jack-test");

        $this->assertEquals('ok',$result['msg']);

    }

    /**
     * @name testdelProduct
     * @brief         Test DelProduct
     *
     * @author        Liu
     * @date           2021-01-27
     */
    function testDelProduct(UnitTester $Unit)
    {
        $Expection  = [
            "name" => "Jack-test",
            "category" => 2,
            "sku" => "DISH775TGHY",
            "price" => 20
        ];

        $product = new Product();
        $product = $product->createProduct($Expection);

        $product->delProduct($product['data']['product_id']);

        $result = $product->productSearch("Jack-test");

        $this->assertEquals('ok',$result['msg']);

        //$Unit->dontSeeRecord('products', ['id' => $product['data']['product_id']]);

    }

}
