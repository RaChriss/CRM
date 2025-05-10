<?php

namespace app\controllers;

use Flight;

class ReactionClientController
{
    public function refuseReaction()
    {
        $generaliserModel = Flight::generaliserModel();
        try {
            $reactionId = (int)$_POST['reaction_effectue_id'];
            if (empty($reactionId)) {
                throw new \Exception('ID de la réaction effectuée manquant.');
            }
            $generaliserModel->updateTableData('reactions', ['statut' => 'rejete'], ['id_reaction' => $reactionId]);
        } catch (\Exception $e) {
            Flight::set('message', 'Erreur : ' . $e->getMessage());
            return;
        } finally {
            Flight::redirect('/crm/reaction/validation');
        }
    }

    public function listeToValidate()
    {
        $generaliserModel = Flight::generaliserModel();

        $conditions = ['statut' => 'en attente'];
        $join = [
            ['type_reactions', [['reactions.type_reaction_id', 'type_reactions.id_type_reaction']]],
        ];
        $reactions = $generaliserModel->getTableData('reactions', $conditions, [], $join);

        Flight::render('template', [
            'pageName' => 'liste_reaction_pending',
            'pageTitle' => 'Liste des Réactions à Valider',
            'reactions' => $reactions
        ]);
    }

    public function saveReaction()
    {
        $generaliserModel = Flight::generaliserModel();
        try {
            $createdAt = isset($_POST['created_at']) ? date('Y-m-d H:i:s', strtotime($_POST['created_at'])) : null;
            $actionId = isset($_POST['action_id']) ? (int)$_POST['action_id'] : null;
            $data = [
                'action_id' => $actionId,
                'created_at' => $createdAt,
                'montant' => isset($_POST['montant']) ? number_format((float)$_POST['montant'], 2, '.', '') : null,
                'type_reaction_id' => isset($_POST['type_reaction_id']) ? (int)$_POST['type_reaction_id'] : null,
                'commentaire' => $_POST['commentaire'] ?? '',
                'valide_par' => isset($_POST['created_by']) ? (int)$_POST['created_by'] : null,
            ];
            $reactionModel = Flight::reactionModel();
            $reactionModel->checkDateReaction($actionId, $createdAt);
            $result = $generaliserModel->insererDonnee('reactions', $data);
            if ($result['status'] === 'success') {
                Flight::set('message', 'Réaction insérée avec succès.');
            } else {
                Flight::set('message', 'Erreur lors de l\'insertion de la réaction : ' . $result['message']);
            }
        } catch (\Exception $e) {
            Flight::set('message', 'Erreur : ' . $e->getMessage());
            return;
        } finally {
            Flight::redirect('/crm/reaction/insert');
        }
    }

    public function insertPage()
    {
        $modelGeneraliser = Flight::generaliserModel();
        $actions = $modelGeneraliser->getTableData('actions', []);
        $types = $modelGeneraliser->getTableData('type_reactions', []);
        Flight::render('template', [
            'pageName' => 'form_reaction',
            'pageTitle' => 'Ajouter une Reaction',
            'actions' => $actions,
            'types' => $types,
            'message' => Flight::get('message') ?? null,
        ]);
    }

    public function showReactionStats()
    {
        $phase = (isset($_GET['phase']) && $_GET['phase'] !== '') ? (int)$_GET['phase'] : null;
        $reactionModel = Flight::reactionModel();
        $frequencies = $reactionModel->getReactionFrequencies($phase);
        $byAgeRange = $reactionModel->getReactionFrequenciesByAgeRange($phase);


        Flight::render('template', [
            'pageName' => 'reaction_client',
            'pageTitle' => 'Statistiques Réactions Clients',
            'frequencies' => $frequencies,
            'byAgeRange' => $byAgeRange,
            'selectedPhase' => $phase
        ]);
    }

    public function showEffectuerReactionForm()
    {
        $generaliserModel = Flight::generaliserModel();

        // Récupérer les actions effectuées avec un JOIN pour inclure les informations des actions et des utilisateurs
        $join = [
            ['action', [['action_effectue.action_id', 'action.id']]],
            ['client', [['action_effectue.user_id', 'client.id']]]
        ];
        $actions = $generaliserModel->getTableData('action_effectue', [], [], $join);

        // Récupérer les réactions
        $reactions = $generaliserModel->getTableData('reaction', []);

        // Rendre la vue avec les données
        Flight::render('template', [
            'pageName' => 'effectuer_reaction',
            'pageTitle' => 'Effectuer Réaction',
            'actions' => $actions,
            'reactions' => $reactions
        ]);
    }

    public function importReactionsEffectueesCsv()
    {
        if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['csv_file']['tmp_name'];
            $generaliserModel = Flight::generaliserModel();
            $reactionModel = Flight::reactionModel();
            $result = $generaliserModel->importCsv($fileTmpPath, ',');

            if ($result['status'] === 'success') {
                $data = $result['data'];
                foreach ($data as $row) {
                    // CSV doit contenir : reaction_id, action_effectue_id, date_reaction (optionnel)
                    $reactionEffectue = [
                        'reaction_id' => $row['reaction_id'] ?? null,
                        'action_effectue_id' => $row['action_effectue_id'] ?? null,
                        'date_reaction' => $row['date_reaction'] ?? null
                    ];
                    $reactionModel->reactionEffectueAvecBudget($reactionEffectue["reaction_id"], $reactionEffectue["action_effectue_id"], $reactionEffectue["date_reaction"]);
                }
                Flight::set('message', 'Import CSV terminé.');
            } else {
                Flight::set('message', 'Erreur import CSV : ' . $result['message']);
            }
        } else {
            Flight::set('message', 'Erreur lors de l\'upload du fichier.');
        }
        Flight::redirect('/reaction-client');
    }

    public function exportReactionsEffectueesPdf()
    {
        $generaliserModel = Flight::generaliserModel();
        $join = [
            ['reaction', [['reaction_effectue.reaction_id', 'reaction.id']]],
            ['action_effectue', [['reaction_effectue.action_effectue_id', 'action_effectue.id']]],
            ['client', [['action_effectue.user_id', 'client.id']]]
        ];
        $reactions = $generaliserModel->getTableData('reaction_effectue', [], [], $join);

        require_once('assets/fpdf/fpdf.php');
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Liste des réactions effectuées', 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(90, 8, 'Réaction', 1);
        $pdf->Cell(30, 8, 'Coût (Ar)', 1);
        $pdf->Cell(40, 8, 'Client', 1);
        $pdf->Cell(35, 8, 'Date', 1);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 9);
        foreach ($reactions as $r) {
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            $pdf->MultiCell(90, 8, $r['description'], 1);
            $pdf->SetXY($x + 90, $y);
            $pdf->Cell(30, 8, isset($r['cout']) ? $r['cout'] . ' Ar' : '', 1);
            $pdf->Cell(40, 8, ($r['nom'] ?? '') . ' ' . ($r['prenom'] ?? ''), 1);
            $pdf->Cell(35, 8, $r['date_reaction'] ?? '', 1);
            $pdf->Ln();
        }
        $pdf->Output('I', 'reactions_effectuees.pdf');
        exit;
    }


    public function importReactionsCsv()
    {
        if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['csv_file']['tmp_name'];
            $generaliserModel = Flight::generaliserModel();
            $result = $generaliserModel->importCsv($fileTmpPath, ',');

            if ($result['status'] === 'success') {
                $data = $result['data'];
                foreach ($data as $row) {
                    // CSV doit contenir : description, phase
                    $reaction = [
                        'description' => $row['description'] ?? '',
                        'phase' => isset($row['phase']) ? (int)$row['phase'] : null,
                        'cout' => isset($row['cout']) ? (int)$row['cout'] : null
                    ];

                    // Insérer la réaction
                    $generaliserModel->insererDonnee('reaction', $reaction);
                }
                Flight::set('message', 'Import CSV réaction terminé.');
            } else {
                Flight::set('message', 'Erreur import CSV réaction : ' . $result['message']);
            }
        } else {
            Flight::set('message', 'Erreur lors de l\'upload du fichier réaction.');
        }
        Flight::redirect('/reaction-client');
    }

    public function exportReactionsPdf()
    {
        $generaliserModel = Flight::generaliserModel();
        $reactions = $generaliserModel->getTableData('reaction', []);
        require_once('assets/fpdf/fpdf.php');
        $pdf = new \FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Liste des réactions', 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(80, 8, 'Description', 1);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 9);
        foreach ($reactions as $r) {
            $pdf->Cell(80, 8, $r['description'], 1);
            $pdf->Ln();
        }
        $pdf->Output();
        exit;
    }


    public function handleEffectuerReactionForm()
    {
        // Vérifier si les données du formulaire sont présentes
        if (isset($_POST['reaction'], $_POST['reaction_date'], $_POST['action_id'])) {
            $reactionId = (int)$_POST['reaction'];
            $reactionDate = $_POST['reaction_date'];
            $actionId = (int)$_POST['action_id'];

            // Utiliser ReactionModel pour obtenir id_exercice et num_periode
            $reactionModel = Flight::reactionModel();

            try {
                // Appeler la fonction pour gérer la réaction et le budget
                $reactionModel->reactionEffectueAvecBudget($reactionId, $actionId, $reactionDate);

                if (Flight::request()->ajax) {
                    Flight::json(['status' => 'success', 'message' => 'Réaction effectuée avec succès et transaction enregistrée.']);
                } else {
                    Flight::set('message', 'Réaction effectuée avec succès et transaction enregistrée.');
                    Flight::redirect('/reaction-client');
                }
            } catch (\Exception $e) {
                if (Flight::request()->ajax) {
                    Flight::json(['status' => 'error', 'message' => 'Erreur : ' . $e->getMessage()]);
                } else {
                    Flight::set('message', 'Erreur : ' . $e->getMessage());
                    Flight::redirect('/reaction-client');
                }
            }
        } else {
            if (Flight::request()->ajax) {
                Flight::json(['status' => 'error', 'message' => 'Tous les champs du formulaire sont requis.']);
            } else {
                Flight::set('message', 'Erreur : Tous les champs du formulaire sont requis.');
                Flight::redirect('/reaction-client');
            }
        }
    }

    public function validateReaction()
    {
        $generaliserModel = Flight::generaliserModel();
        $reactionModel = Flight::reactionModel();

        try {
            $reactionEffectueId = (int)$_POST['reaction_effectue_id'];
            if (empty($reactionEffectueId)) {
                throw new \Exception('Erreur : ID de la réaction effectuée manquant.');
            }

            // Récupérer les informations de la réaction effectuée
            $reactionEffectue = $generaliserModel->getTableData('reactions', ['id_reaction' => $reactionEffectueId]);
            if (empty($reactionEffectue)) {
                throw new \Exception('Erreur : Réaction effectuée introuvable.');
            }

            $reactionEffectue = $reactionEffectue[0]; // Récupérer la première ligne
            $dateReaction = date('Y-m-d');
            $coutReaction = $reactionEffectue['montant'];

            // Obtenir l'exercice et le numéro de période correspondant à la date de la réaction
            $exerciseId = $reactionModel->getExerciseIdByDate($dateReaction);
            $periodNum = $reactionModel->getPeriodNumberByDate($dateReaction);

            if ($exerciseId === null || $periodNum === null) {
                throw new \Exception('Erreur : Impossible de déterminer l\'exercice ou la période pour la date donnée.');
            }

            // Récupérer l'ID du budget_element pour le département CRM (department_id = 4)
            $budgetElement = $generaliserModel->getTableData('budget_element', ['department_id' => 4]);
            if (empty($budgetElement)) {
                throw new \Exception('Erreur : Budget élément pour le département CRM introuvable.');
            }

            $budgetElementId = $budgetElement[0]['budget_element_id'];

            // Vérifier si une transaction existe déjà pour cet exercice, période et budget_element
            $transaction = $generaliserModel->getTableData('transaction', [
                'exercise_id' => $exerciseId,
                'period_num' => $periodNum,
                'budget_element_id' => $budgetElementId,
                'nature' => 2 // Réalisation
            ]);

            if (!empty($transaction)) {
                // Mettre à jour le montant de la transaction existante
                $transactionId = $transaction[0]['transaction_id'];
                $newAmount = $transaction[0]['amount'] + $coutReaction;

                $generaliserModel->updateTableData('transaction', ['amount' => $newAmount], ['transaction_id' => $transactionId]);
            } else {
                // Insérer une nouvelle transaction
                $generaliserModel->insererDonnee('transaction', [
                    'nature' => 2,
                    'exercise_id' => $exerciseId,
                    'budget_element_id' => $budgetElementId,
                    'period_num' => $periodNum,
                    'amount' => $coutReaction,
                    'status' => 1,
                    'priority_id' => 2
                ]);
            }

            // Mettre à jour le statut de la réaction effectuée à validée
            $generaliserModel->updateTableData('reactions', ['statut' => 'valide'], ['id_reaction' => $reactionEffectueId]);

            Flight::set('message', 'Réaction validée avec succès.');
        } catch (\Exception $e) {
            Flight::set('message', $e->getMessage());
        } finally {
            Flight::redirect('/crm/reaction/validation');
        }
    }
}
