<?php

declare(strict_types=1);

require_once 'module_lijst.php';
require_once 'persoon_lijst.php';
require_once 'database.php';

class PuntenLijst
{
    private mysqli $conn;
    
    public function __construct(mysqli $conn)
    {
        $this->conn = $conn;
    }

    public function addPunten(int $persoonId, int $moduleId, int $grade): bool
    {
        // Check if the entry already exists
        $stmt = $this->conn->prepare('SELECT * FROM punten WHERE persoonID = ? AND moduleID = ?');
        $stmt->bind_param('ii', $persoonId, $moduleId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Entry already exists, throw an exception
            throw new Exception('Grade already exists for this person and module.');
        } else {
            // Insert a new entry
            $stmt = $this->conn->prepare('INSERT INTO punten (persoonID, moduleID, punt) VALUES (?, ?, ?)');
            $stmt->bind_param('iii', $persoonId, $moduleId, $grade);
            return $stmt->execute();
        }
    }

    public function getGradesByModule(int $moduleId): array
    {
        $stmt = $this->conn->prepare('SELECT p.voornaam, p.familienaam, pt.punt FROM punten pt JOIN personen p ON pt.persoonID = p.id WHERE pt.moduleID = ?');
        $stmt->bind_param('i', $moduleId);
        $stmt->execute();
        $result = $stmt->get_result();
        $grades = [];
        while ($row = $result->fetch_assoc()) {
            $grades[] = $row;
        }
        return $grades;
    }

        
    public function getGradesByPerson(int $persoonId): array
    {
        $stmt = $this->conn->prepare('SELECT m.naam, pt.punt FROM punten pt JOIN modules m ON pt.moduleID = m.id WHERE pt.persoonID = ?');
        $stmt->bind_param('i', $persoonId);
        $stmt->execute();
        $result = $stmt->get_result();
        $grades = [];
        while ($row = $result->fetch_assoc()) {
            $grades[] = $row;
        }
        return $grades;
    }

}
?>