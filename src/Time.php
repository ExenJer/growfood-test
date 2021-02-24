<?php


namespace Exrs\Pricer;


class Time
{
    /**
     * @param \DateTimeInterface $time
     * @return \DateTimeInterface
     */
    public static function subDay(\DateTimeInterface $time): \DateTimeInterface
    {
        return (clone $time)->modify('-1 day');
    }
}