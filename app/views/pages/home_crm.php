<?php
// Récupérer les données passées par le contrôleur
$beforeReaction = $beforeReaction ?? [];
$duringReaction = $duringReaction ?? [];
$afterReaction = $afterReaction ?? [];
$livestock = $livestock ?? [];

// Fonctions utilitaires
function formatNumber($value, $decimals = 2) {
    return is_numeric($value) ? number_format($value, $decimals, ',', ' ') : '-';
}

function formatDateFr($dateString) {
    if (empty($dateString)) return '-';
    $date = new DateTime($dateString);
    return $date->format('d/m/Y H:i');
}
?>

<div class="container">
    <div class="page-inner">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold mb-0">Tableau de Bord</h1>
            <div>
                <button id="refresh-all" class="btn btn-primary btn-round" onclick="location.reload()">
                    <i class="fas fa-sync-alt"></i> Actualiser
                </button>
            </div>
        </div>

        <!-- Section 1: Statistiques principales -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round mb-4">
                    <div class="card-header bg-light">
                        <h4 class="card-title mb-0">Aperçu Global</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="stat-card card card-body bg-primary text-white mb-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="mb-1">Animaux Disponibles</h5>
                                            <h2 class="mb-0"><?= $beforeReaction['company_status']['animaux_disponibles'] ?? 0 ?></h2>
                                        </div>
                                        <i class="fas fa-cow fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card card card-body bg-success text-white mb-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="mb-1">Chiffre d'Affaires</h5>
                                            <h2 class="mb-0"><?= formatNumber($beforeReaction['company_status']['chiffre_affaires_annee'] ?? 0) ?>€</h2>
                                        </div>
                                        <i class="fas fa-euro-sign fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card card card-body bg-info text-white mb-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="mb-1">Clients Actifs</h5>
                                            <h2 class="mb-0"><?= $beforeReaction['company_status']['clients_actifs'] ?? 0 ?></h2>
                                        </div>
                                        <i class="fas fa-users fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card card card-body bg-warning text-dark mb-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <h5 class="mb-1">Alertes Stocks</h5>
                                            <h2 class="mb-0"><?= $beforeReaction['company_status']['alertes_stocks'] ?? 0 ?></h2>
                                        </div>
                                        <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 2: Avant Réaction -->
        <div class="row">
            <div class="col-md-8">
                <div class="card card-round mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Actions en Attente</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($beforeReaction['pending_actions'])): ?>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Type d'action</th>
                                        <th>Nombre</th>
                                        <th>Jours d'attente moyen</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($beforeReaction['pending_actions'] as $action): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($action['type_action'] ?? '') ?></td>
                                            <td><?= $action['nombre_actions'] ?? 0 ?></td>
                                            <td><?= formatNumber($action['jours_attente_moyens'] ?? 0, 1) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="text-muted">Aucune action en attente</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-round mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Clients Actifs</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($beforeReaction['active_clients'])): ?>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Type de client</th>
                                        <th>Nombre</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($beforeReaction['active_clients'] as $client): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($client['type_client'] ?? '') ?></td>
                                            <td><?= $client['nombre_clients'] ?? 0 ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="text-muted">Aucun client actif</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 3: Pendant Réaction -->
        <div class="row">
            <div class="col-md-6">
                <div class="card card-round mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Charge de Travail</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($duringReaction['workload'])): ?>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Département</th>
                                        <th>Actions en cours</th>
                                        <th>Part du total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($duringReaction['workload'] as $work): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($work['departement'] ?? '') ?></td>
                                            <td><?= $work['actions_en_cours'] ?? 0 ?></td>
                                            <td><?= formatNumber($work['pourcentage_total'] ?? 0) ?>%</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="text-muted">Aucune donnée de charge de travail</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-round mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Temps de Réaction</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($duringReaction['reaction_times'])): ?>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Type d'action</th>
                                        <th>Temps moyen (jours)</th>
                                        <th>Min</th>
                                        <th>Max</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($duringReaction['reaction_times'] as $time): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($time['type_action'] ?? '') ?></td>
                                            <td><?= formatNumber($time['temps_moyen_jours'] ?? 0, 1) ?></td>
                                            <td><?= $time['temps_min_jours'] ?? 0 ?></td>
                                            <td><?= $time['temps_max_jours'] ?? 0 ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="text-muted">Aucune donnée de temps de réaction</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 4: Après Réaction -->
        <div class="row">
            <div class="col-md-6">
                <div class="card card-round mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Satisfaction Client</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($afterReaction['satisfaction'])): ?>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Type d'action</th>
                                        <th>Note moyenne</th>
                                        <th>% Satisfaits</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($afterReaction['satisfaction'] as $sat): ?>
                                        <?php if ($sat['type_action'] !== 'GLOBAL'): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($sat['type_action'] ?? '') ?></td>
                                                <td><?= formatNumber($sat['note_moyenne'] ?? 0, 1) ?>/5</td>
                                                <td><?= formatNumber($sat['pourcentage_satisfaits'] ?? 0) ?>%</td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <?php 
                            $globalSat = array_filter($afterReaction['satisfaction'], fn($item) => $item['type_action'] === 'GLOBAL');
                            if (!empty($globalSat)): 
                                $global = reset($globalSat);
                            ?>
                                <div class="mt-3 p-2 bg-light rounded">
                                    <strong>Satisfaction globale :</strong> 
                                    <?= formatNumber($global['note_moyenne'] ?? 0, 1) ?>/5 
                                    (<?= formatNumber($global['pourcentage_satisfaits'] ?? 0) ?>% satisfaits)
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <p class="text-muted">Aucune donnée de satisfaction client</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-round mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Résolution des Problèmes</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($afterReaction['problem_resolution'])): ?>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Type</th>
                                        <th>Taux</th>
                                        <th>Délai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($afterReaction['problem_resolution'] as $problem): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($problem['type_probleme'] ?? '') ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress progress-thin w-100 me-2">
                                                        <div class="progress-bar bg-success" 
                                                             role="progressbar" 
                                                             style="width: <?= $problem['taux_resolution'] ?? 0 ?>%" 
                                                             aria-valuenow="<?= $problem['taux_resolution'] ?? 0 ?>" 
                                                             aria-valuemin="0" 
                                                             aria-valuemax="100">
                                                        </div>
                                                    </div>
                                                    <span><?= formatNumber($problem['taux_resolution'] ?? 0) ?>%</span>
                                                </div>
                                            </td>
                                            <td><?= formatNumber($problem['delai_moyen_resolution'] ?? 0, 1) ?> jours</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="text-muted">Aucune donnée de résolution de problèmes</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 5: Spécifique Élevage -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round mb-4">
                    <div class="card-header">
                        <h4 class="card-title">Performance des Animaux</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php if (!empty($livestock['animal_performance'])): ?>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Espèce</th>
                                                <th>Race</th>
                                                <th>Taux Vente</th>
                                                <th>Prix Moyen</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($livestock['animal_performance'] as $animal): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($animal['espece'] ?? '') ?></td>
                                                    <td><?= htmlspecialchars($animal['race'] ?? '') ?></td>
                                                    <td><?= formatNumber($animal['taux_vente'] ?? 0) ?>%</td>
                                                    <td><?= $animal['prix_moyen_vente'] ? formatNumber($animal['prix_moyen_vente'], 2).'€' : '-' ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                <?php else: ?>
                                    <p class="text-muted">Aucune donnée de performance animale</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section 6: Interventions -->
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <h4 class="card-title">Interventions à Venir</h4>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($livestock['sanitary_interventions'])): ?>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Client</th>
                                            <th>Coût moyen</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($livestock['sanitary_interventions'] as $intervention): ?>
                                            <tr>
                                                <td><?= formatDateFr($intervention['date_intervention'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($intervention['type'] ?? '') ?></td>
                                                <td><?= htmlspecialchars($intervention['client'] ?? 'Tous') ?></td>
                                                <td><?= formatNumber($intervention['cout_moyen'] ?? 0, 2) ?>€</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">Aucune intervention à venir</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>