<?php

declare(strict_types=1);

namespace Tests\Acceptance;

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
     * @name testCreateProduct
     * @brief         Test CreateProduct
     *
     * @author        Liu
     * @date          2021-01-27
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

        $Unit->seeRecord('products', ['name' =>'Jack-test'] );

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

        $Unit->dontSeeRecord('products', ['name' =>'Jack-test'] );

    }

}
