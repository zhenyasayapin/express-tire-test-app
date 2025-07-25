<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\ManufacturerFactory;
use App\Factory\ModelFactory;
use App\Factory\ProductFactory;
use App\Factory\TypeFactory;
use Zenstruck\Foundry\Test\Factories;

class ProductTest extends ApiTestCase
{
    use Factories;

    public function setUp(): void
    {
        self::$alwaysBootKernel = false;
    }

    public function testGetProductsByType(): void
    {
        $client = static::createClient();

        ProductFactory::createMany(10);

        $products = ProductFactory::createMany(5, [
            'model' => ModelFactory::createOne(
                [
                    'type' => $type = TypeFactory::createOne(),
                    'manufacturer' => ManufacturerFactory::createOne(),
                ]
            )
        ]);

        $response = $client->request('GET', '/product/type/'. $type->getId());

        $this->assertResponseIsSuccessful();
        $this->assertCount(count(json_decode($response->getContent())), $products);
    }
}
