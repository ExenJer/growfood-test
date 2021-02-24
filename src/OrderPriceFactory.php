<?php


namespace Exrs\Pricer;


use DateTime;
use Exrs\Pricer\Entity\OrderPriceEntity;
use Exrs\Pricer\Exceptions\ValidationException;

class OrderPriceFactory
{
    /**
     * @param array $input
     * @return OrderPriceEntity[]
     * @throws ValidationException
     */
    public static function fromJsonInput(array $input): array
    {
        $orderPriceEntities = [];

        foreach ($input as $value) {
            if (
                !isset($value['position_id']) || !isset($value['delivery_date_from'])
                || !isset($value['order_date_from']) || !isset($value['price'])
            ) {
                throw new ValidationException();
            }

            $orderPriceEntity = new OrderPriceEntity();

            $orderPriceEntity->setId((int) $value['position_id']);
            $orderPriceEntity->setDeliveryDateFrom(
                DateTime::createFromFormat('Y-m-d', $value['delivery_date_from'])
            );
            $orderPriceEntity->setOrderDateFrom(
                DateTime::createFromFormat('Y-m-d', $value['order_date_from'])
            );
            $orderPriceEntity->setPrice((float) $value['price']);

            $orderPriceEntities[] = $orderPriceEntity;
        }

        return $orderPriceEntities;
    }

    /**
     * @param OrderPriceEntity $order
     * @return OrderPriceEntity
     */
    public static function fromImmutableValues(OrderPriceEntity $order): OrderPriceEntity
    {
        $entity = new OrderPriceEntity();

        $entity->setId($order->getId());
        $entity->setPrice($order->getPrice());
        $entity->setOrderDateFrom($order->getOrderDateFrom());

        return $entity;
    }
}