<div class="container">
    <div class="page-inner">
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?= strpos($message, 'Erreur') !== false ? 'danger' : 'success' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Statistiques des Actions Clients</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Filtres</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Filtre phase -->
                        <form method="get" id="phaseFilterForm">
                            <div class="row align-items-end">
                                <div class="col-md-4">
                                    <label for="phase" class="form-label">Filtrer par phase :</label>
                                    <select name="phase" id="phase" class="form-select">
                                        <option value="">Toutes les phases</option>
                                        <option value="1" <?= isset($selectedPhase) && $selectedPhase == 1 ? 'selected' : '' ?>>Avant l'échange</option>
                                        <option value="2" <?= isset($selectedPhase) && $selectedPhase == 2 ? 'selected' : '' ?>>Pendant l'échange</option>
                                        <option value="3" <?= isset($selectedPhase) && $selectedPhase == 3 ? 'selected' : '' ?>>Après l'échange</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary">Filtrer</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Actions</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form id="importActionsBaseForm" class="d-flex align-items-center gap-2" enctype="multipart/form-data">
                                    <input type="file" name="csv_file" accept=".csv" required class="form-control">
                                    <button type="submit" class="btn btn-primary">Importer CSV</button>
                                </form>
                            </div>
                            <div class="col-md-6 text-end">
                                <form id="exportActionsBasePdfForm">
                                    <button type="submit" class="btn btn-success">Exporter PDF</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Effectuer des actions</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <form id="importActionsForm" class="d-flex align-items-center gap-2" enctype="multipart/form-data">
                                    <input type="file" name="csv_file" accept=".csv" required class="form-control">
                                    <button type="submit" class="btn btn-primary">Importer CSV</button>
                                </form>
                            </div>
                            <div class="col-md-6 text-end">
                                <form id="exportActionsPdfForm">
                                    <button type="submit" class="btn btn-success">Exporter PDF</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Fréquence des actions</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="actionsTable" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>Phase</th>
                                        <th>Coût</th>
                                        <th>Nombre d'exécutions</th>
                                        <th>Nombre de clients distincts</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($frequencies as $action): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($action['description']) ?></td>
                                            <td><?= htmlspecialchars($action['phase']) ?></td>
                                            <td><?= htmlspecialchars($action['cout']) ?></td>
                                            <td><?= htmlspecialchars($action['frequence']) ?></td>
                                            <td><?= htmlspecialchars($action['nb_clients']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Actions les plus fréquentes par tranche d'âge</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <?php foreach ($byAgeRange as $range => $actions): ?>
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header">Tranche d'âge : <?= htmlspecialchars($range) ?> ans</div>
                                        <div class="card-body">
                                            <canvas id="chart-<?= $range ?>"></canvas>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>