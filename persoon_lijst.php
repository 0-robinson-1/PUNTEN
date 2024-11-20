<?php

declare(strict_types=1);

require_once 'Persoon.php';
require_once 'database.php';

class PersoonLijst
{
    private mysqli $conn;
    
    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }
    
    public function getAllPersonen(): array
    {
        $sql = 'SELECT * FROM personen';
        $result = $this->conn->query($sql);
        $personen = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $personen[] = new Persoon((int)$row['id'], $row['voornaam'], $row['familienaam']);
            }
        }
        return $personen;
    }


}

?>