<?php

namespace Tests;

use Exrs\Pricer\Denormalizer;
use Exrs\Pricer\Entity\OrderPriceEntity;
use Exrs\Pricer\OrderPriceFactory;

class CaseTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @test
     */
    public function testSomeFunc()
    {
        $inputData = [
            [
                'position_id' => 1,
                'order_date_from' => '2019-02-01',
                'delivery_date_from' => '2019-03-01',
                'price' => 100,
            ],
            [
                'position_id' => 1,
                'order_date_from' => '2019-02-10',
                'delivery_date_from' => '2019-03-10',
                'price' => 200,
            ],
            [
                'position_id' => 1,
                'order_date_from' => '2019-02-20',
                'delivery_date_from' => '2019-02-25',
                'price' => 130,
            ]
        ];

        $a = OrderPriceFactory::fromJsonInput($inputData);
        $denorm = new Denormalizer($a);

        $jsonDenorm = json_encode($denorm->transform()->getDenormalizedOrders());


        $this->assertJson($jsonDenorm);
    }
}