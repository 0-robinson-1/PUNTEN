<?php

 declare(strict_types=1);

class Punten
{
    private int $moduleID;
    private int $persoonID;
    private int $punt;

    public function __construct(int $moduleID, int $persoonID, int $punt)
    {
        $this->moduleID = $moduleID;
        $this->persoonID = $persoonID;
        $this->punt = $punt;
    }

    public function getModuleID(): int
    {
        return $this->moduleID;
    }

    public function getPersoonID(): int
    {
        return $this->persoonID;
    }

    public function getPunt(): int
    {
        return $this->punt;
    }
}



?>