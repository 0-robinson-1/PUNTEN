<?php

declare(strict_types=1);

class Module
{
    private int $moduleID;
    private string $naam;
    private float $prijs;

    public function __construct(int $moduleID, string $naam, float $prijs)
    {
        $this->moduleID = $moduleID;
        $this->naam = $naam;
        $this->prijs = $prijs;
    }

    public function getIdModule(): int
    {
        return $this->moduleID;
    }

    public function getNaamModule(): string
    {
        return $this->naam;
    }
}
?>