<?php

namespace Exrs\Pricer\Entity;

use DateTimeInterface;
use JsonSerializable;

class OrderPriceEntity implements JsonSerializable
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var DateTimeInterface
     */
    private DateTimeInterface $orderDateFrom;

    /**
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $orderDateTo;

    /**
     * @var DateTimeInterface
     */
    private DateTimeInterface $deliveryDateFrom;

    /**
     * @var DateTimeInterface|null
     */
    private ?DateTimeInterface $deliveryDateTo;

    /**
     * @var float
     */
    private float $price;

    /**
     * @return DateTimeInterface
     */
    public function getOrderDateFrom(): DateTimeInterface
    {
        return $this->orderDateFrom;
    }

    /**
     * @param DateTimeInterface $orderDateFrom
     */
    public function setOrderDateFrom(DateTimeInterface $orderDateFrom): void
    {
        $this->orderDateFrom = $orderDateFrom;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDeliveryDateFrom(): DateTimeInterface
    {
        return $this->deliveryDateFrom;
    }

    /**
     * @param DateTimeInterface $deliveryDateFrom
     */
    public function setDeliveryDateFrom(DateTimeInterface $deliveryDateFrom): void
    {
        $this->deliveryDateFrom = $deliveryDateFrom;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getOrderDateTo(): ?DateTimeInterface
    {
        return isset($this->orderDateTo) ? $this->orderDateTo : null;
    }

    /**
     * @param DateTimeInterface $orderDateTo
     */
    public function setOrderDateTo(DateTimeInterface $orderDateTo): void
    {
        $this->orderDateTo = $orderDateTo;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getDeliveryDateTo(): ?DateTimeInterface
    {
        return isset($this->deliveryDateTo) ? $this->deliveryDateTo : null;
    }

    /**
     * @param DateTimeInterface $deliveryDateTo
     */
    public function setDeliveryDateTo(DateTimeInterface $deliveryDateTo): void
    {
        $this->deliveryDateTo = $deliveryDateTo;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'position_id' => $this->getId(),
            'order_date_from' => $this->getOrderDateFrom()->format('Y-m-d'),
            'order_date_to' => $this->getOrderDateTo() ? $this->getOrderDateTo()->format('Y-m-d') : '',
            'delivery_date_from' => $this->getDeliveryDateFrom()->format('Y-m-d'),
            'delivery_date_to' => $this->getDeliveryDateTo() ? $this->getDeliveryDateTo()->format('Y-m-d') : '',
            'price' => $this->getPrice(),
        ];
    }
}