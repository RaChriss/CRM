<div class="container">
    <div class="page-inner">
    <?php if (!empty($message)): ?>
            <div class="alert alert-<?= strpos($message, 'Erreur') !== false ? 'danger' : 'success' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <!-- Titre -->
        <div class="d-flex align-items-start align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Gestion des Clients</h3>
            </div>
        </div>

        <!-- Message flash -->
        <div class="row mb-3">
            <div class="col-12" id="client-message">
                <?php if (!empty($message)): ?>
                    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Section Import / Export -->
        <div class="row mb-4 align-items-center">
            <!-- Formulaire d'import CSV -->
            <div class="col-md-6">
                <form id="importClientsForm" class="d-flex align-items-center gap-2" enctype="multipart/form-data">
                    <input type="file" name="csv_file" accept=".csv" required class="form-control">
                    <button type="submit" class="btn btn-primary btn-round">Importer CSV</button>
                </form>
            </div>

            <!-- Formulaire d'export PDF -->
            <div class="col-md-6">
                <form id="exportClientsPdfForm" class="d-flex justify-content-md-end justify-content-start">
                    <button type="submit" class="btn btn-success btn-round">Exporter PDF</button>
                </form>
            </div>
        </div>

        <!-- Tableau des clients -->
        <div class="card mb-4">
            <div class="card-header">Liste des clients</div>
            <div class="card-body">
                <table id="clientsTable" class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Âge</th>
                            <th>Type de cheveux</th>
                            <th>Préférences</th>
                            <th>Taux de fidélité (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $c): ?>
                            <tr>
                                <td><?= htmlspecialchars($c['nom']) ?></td>
                                <td><?= htmlspecialchars($c['prenom']) ?></td>
                                <td><?= htmlspecialchars($c['age']) ?></td>
                                <td><?= htmlspecialchars($c['TypeCheveux'] ?? '') ?></td>
                                <td><?= htmlspecialchars($c['preferences']) ?></td>
                                <td><?= isset($c['taux_fidelite']) ? $c['taux_fidelite'] : '0' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Statistiques globales -->
        <div class="card mb-4">
            <div class="card-header">Statistiques globales</div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Taux de réservation global</label>
                        <canvas id="gaugeReservation" width="180" height="120"></canvas>
                        <div><strong id="gaugeReservationValue"><?= $taux_reservation_global ?>%</strong></div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Taux d'arrivée au salon global</label>
                        <canvas id="gaugeArrivee" width="180" height="120"></canvas>
                        <div><strong id="gaugeArriveeValue"><?= $taux_arrivee_global ?>%</strong></div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Taux de fidélité global</label>
                        <canvas id="gaugeFidelite" width="180" height="120"></canvas>
                        <div><strong id="gaugeFideliteValue"><?= $taux_fidelite_global ?>%</strong></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Graphiques détaillés -->
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">Répartition par âge</div>
                    <div class="card-body">
                        <canvas id="ageChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header">Types de cheveux</div>
                    <div class="card-body">
                        <canvas id="typecheveuxChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
