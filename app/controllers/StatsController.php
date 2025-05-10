<?php

namespace app\controllers;

use Flight;

class StatsController
{

    public function showDashboard()
    {
        $statsModel = Flight::statsModel();

        $data = [
            'beforeReaction' => [
                'pending_actions' => $statsModel->getPendingActions(),
                'active_clients' => $statsModel->getActiveClients(),
                'company_status' => $statsModel->getCompanyStatus()
            ],
            'duringReaction' => [
                'ongoing_actions' => $statsModel->getOngoingActions(),
                'reaction_times' => $statsModel->getReactionTimes(),
                'workload' => $statsModel->getWorkload()
            ],
            'afterReaction' => [
                'satisfaction' => $statsModel->getSatisfaction(),
                'problem_resolution' => $statsModel->getProblemResolution()
            ],
            'livestock' => [
                'animal_performance' => $statsModel->getAnimalPerformance(),
                'sanitary_interventions' => $statsModel->getSanitaryInterventions(),
                'client_profitability' => $statsModel->getClientProfitability()
            ]
        ];

        Flight::render(
            'template',
            array_merge(
                [
                    'pageName' => 'home_crm',
                    'pageTitle' => 'Dashboard CRM'
                ],
                $data
            )
        );
    }


    public function getBeforeReactionStats()
    {
        $data = [
            'pending_actions' => Flight::statsModel()->getPendingActions(),
            'active_clients' => Flight::statsModel()->getActiveClients(),
            'company_status' => Flight::statsModel()->getCompanyStatus()
        ];
        Flight::json($data);
    }

    public function getDuringReactionStats()
    {
        $data = [
            'ongoing_actions' => Flight::statsModel()->getOngoingActions(),
            'reaction_times' => Flight::statsModel()->getReactionTimes(),
            'workload' => Flight::statsModel()->getWorkload()
        ];
        Flight::json($data);
    }

    public function getAfterReactionStats()
    {
        $data = [
            'satisfaction' => Flight::statsModel()->getSatisfaction(),
            'problem_resolution' => Flight::statsModel()->getProblemResolution()
        ];
        Flight::json($data);
    }

    public function getLivestockSpecificStats()
    {
        $data = [
            'animal_performance' => Flight::statsModel()->getAnimalPerformance(),
            'sanitary_interventions' => Flight::statsModel()->getSanitaryInterventions(),
            'client_profitability' => Flight::statsModel()->getClientProfitability()
        ];
        Flight::json($data);
    }
}
