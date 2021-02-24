<?php


namespace Exrs\Pricer;


use Exrs\Pricer\Entity\OrderPriceEntity;

class Denormalizer
{
    /**
     * @var OrderPriceEntity[]
     */
    private array $orders;

    /**
     * @var OrderPriceEntity[]
     */
    private array $denormalizedOrders;

    /**
     * Denormalizer constructor.
     *
     * @param OrderPriceEntity[] $orders
     */
    public function __construct(array $orders)
    {
        $this->orders = $orders;
    }

    /**
     * @return static
     */
    public function transform(): self
    {
        $this->sortOrdersByDeliveryFromDate();

        foreach ($this->orders as $orderPrice) {
            $this->entry($orderPrice);
        }

        return $this;
    }

    /**
     * @param OrderPriceEntity $entryOrder
     */
    private function entry(OrderPriceEntity $entryOrder): void
    {
        foreach ($this->orders as $order) {
            if ($this->isSkipCurrentOrder($entryOrder, $order)) {
                continue;
            }

            if ($entryOrder->getDeliveryDateFrom() < $order->getDeliveryDateFrom()) {
               $this->passDeliveryTo($entryOrder, $order);

                if ($entryOrder->getOrderDateFrom() < $order->getOrderDateFrom()) {
                    $this->passOrderTo($entryOrder, $order);
                }

                return;
            }
        }

        $this->denormalizedOrders[] = $entryOrder;
    }

    /**
     * @param OrderPriceEntity $entryOrder
     * @param OrderPriceEntity $order
     * @return bool
     */
    private function isSkipCurrentOrder(OrderPriceEntity $entryOrder, OrderPriceEntity $order): bool
    {
        return $entryOrder === $order || $order->getId() != $entryOrder->getId();
    }

    /**
     * @param OrderPriceEntity $entryOrder
     * @param OrderPriceEntity $order
     */
    private function passDeliveryTo(OrderPriceEntity $entryOrder, OrderPriceEntity $order): void
    {
        $dnOrder = OrderPriceFactory::fromImmutableValues($entryOrder);

        $dnOrder->setDeliveryDateTo(Time::subDay($order->getDeliveryDateFrom()));
        $dnOrder->setDeliveryDateFrom($entryOrder->getDeliveryDateFrom());

        $this->denormalizedOrders[] = $dnOrder;
    }

    /**
     * @param OrderPriceEntity $entryOrder
     * @param OrderPriceEntity $order
     */
    private function passOrderTo(OrderPriceEntity $entryOrder, OrderPriceEntity $order): void
    {
        $dnOrder = OrderPriceFactory::fromImmutableValues($entryOrder);

        $dnOrder->setOrderDateTo(Time::subDay($order->getOrderDateFrom()));
        $dnOrder->setDeliveryDateFrom($order->getDeliveryDateFrom());

        $this->denormalizedOrders[] = $dnOrder;
    }

    /**
     * @return void
     */
    private function sortOrdersByDeliveryFromDate(): void
    {
        usort($this->orders,
            fn(OrderPriceEntity $a, OrderPriceEntity $b): bool => $a->getDeliveryDateFrom() > $b->getDeliveryDateFrom()
        );
    }

    /**
     * @return OrderPriceEntity[]
     */
    public function getDenormalizedOrders(): array
    {
        return $this->denormalizedOrders;
    }
}