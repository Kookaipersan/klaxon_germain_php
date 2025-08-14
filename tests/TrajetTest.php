<?php

use PHPUnit\Framework\TestCase;
use App\Models\Trajet;

class TrajetTest extends TestCase
{
    public function testFindByIdReturnsNullIfNotFound()
    {
        $trajet = Trajet::findById(-1);
        $this->assertNull($trajet);
    }

    public function testCreateReturnsValidId()
    {
        $id = Trajet::create([
            'agence_depart_id' => 1,
            'agence_arrivee_id' => 2,
            'date_heure_depart' => '2025-08-14 10:00:00',
            'date_heure_arrivee' => '2025-08-14 12:00:00',
            'nombres_places_total' => 4,
            'nombres_places_dispo' => 4,
            'utilisateur_id' => 1
        ]);
        $this->assertIsInt($id);
    }
}
