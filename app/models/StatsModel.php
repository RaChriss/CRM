<?php

namespace app\models;

use Flight;
use PDO;

class StatsModel
{
    private $db;

    public function __construct($db1)
    {
        $this->db = $db1;
    }

    public function getPendingActions()
    {
        $stmt = $this->db->query("SELECT * FROM stats_actions_en_attente");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveClients()
    {
        $stmt = $this->db->query("SELECT * FROM stats_clients_actifs");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCompanyStatus()
    {
        $stmt = $this->db->query("SELECT * FROM stats_etat_entreprise");
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOngoingActions()
    {
        $stmt = $this->db->query("SELECT * FROM stats_actions_en_cours");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getReactionTimes()
    {
        $stmt = $this->db->query("SELECT * FROM stats_temps_reaction");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWorkload()
    {
        $stmt = $this->db->query("SELECT * FROM stats_charge_travail");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSatisfaction()
    {
        $stmt = $this->db->query("SELECT * FROM stats_satisfaction");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProblemResolution()
    {
        $stmt = $this->db->query("SELECT * FROM stats_resolution_problemes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAnimalPerformance()
    {
        $stmt = $this->db->query("SELECT * FROM stats_performance_animaux");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSanitaryInterventions()
    {
        $stmt = $this->db->query("SELECT * FROM stats_interventions_sanitaires");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getClientProfitability()
    {
        $stmt = $this->db->query("SELECT * FROM stats_rentabilite_clients");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
