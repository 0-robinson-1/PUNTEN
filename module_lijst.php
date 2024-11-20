<?php

declare(strict_types=1);

require_once 'module.php';
require_once 'database.php';

class ModuleLijst
{
    private mysqli $conn;

    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function getAllModules(): array
    {
        $modules = [];
        $query = "SELECT id, naam, prijs FROM modules";
        $result = $this->conn->query($query);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $modules[] = new Module((int)$row['id'], $row['naam'], (float)$row['prijs']);
            }
        } else {
            error_log("Failed to fetch modules: " . $this->conn->error);
        }
        return $modules;
    }



}