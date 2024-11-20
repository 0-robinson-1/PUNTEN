<?php

declare(strict_types=1);

class Persoon
{
    private int $persoonID;
    private string $voornaam;
    private string $familienaam;

    public function __construct(int $persoonID, string $voornaam, string $familienaam)
    {
        $this->persoonID = $persoonID;
        $this->voornaam = $voornaam;
        $this->familienaam = $familienaam;
    }

    public function getId(): int
    {
        return $this->persoonID;
    }

    public function getNaam(): string
    {
        return $this->voornaam . ' ' . $this->familienaam;
    }
}
?>