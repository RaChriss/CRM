<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                    <div>
                        <h3 class="fw-bold mb-3">Statistiques</h3>
                        <h6 class="op-7 mb-2">Réactions Clients</h6>
                    </div>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-round">
                            <div class="card-header">
                                <div class="card-head-row">
                                    <div class="card-title">Filtres</div>
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="get" id="phaseFilterForm">
                                    <div class="row align-items-end">
                                        <div class="col-md-4">
                                            <label for="phase" class="form-label">Filtrer par phase :</label>
                                            <select name="phase" id="phase" class="form-select form-control-sm">
                                                <option value="">Toutes les phases</option>
                                                <option value="1" <?= isset($selectedPhase) && $selectedPhase == 1 ? 'selected' : '' ?>>Avant l'échange</option>
                                                <option value="2" <?= isset($selectedPhase) && $selectedPhase == 2 ? 'selected' : '' ?>>Pendant l'échange</option>
                                                <option value="3" <?= isset($selectedPhase) && $selectedPhase == 3 ? 'selected' : '' ?>>Après l'échange</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary btn-sm">Filtrer</button>
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
                                    <div class="card-title">Réactions</div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <form id="importReactionsBaseForm" class="d-flex align-items-center gap-2" enctype="multipart/form-data">
                                            <input type="file" name="csv_file" accept=".csv" required class="form-control">
                                            <button type="submit" class="btn btn-primary btn-sm">Importer CSV</button>
                                        </form>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <form id="exportReactionsBasePdfForm">
                                            <button type="submit" class="btn btn-success btn-sm">Exporter PDF</button>
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
                                    <div class="card-title">Effectuer des réactions</div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <form id="importReactionsForm" class="d-flex align-items-center gap-2" enctype="multipart/form-data">
                                            <input type="file" name="csv_file" accept=".csv" required class="form-control">
                                            <button type="submit" class="btn btn-primary btn-sm">Importer CSV</button>
                                        </form>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <form id="exportReactionsPdfForm">
                                            <button type="submit" class="btn btn-success btn-sm">Exporter PDF</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <a href="<?= htmlspecialchars(Flight::get('flight.base_url') . '/reaction-client/effectuer-reaction') ?>" class="btn btn-primary btn-sm">
                                        Effectuer Réaction
                                    </a>
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
                                    <div class="card-title">Fréquence des réactions</div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="reactionsTable" class="display table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>Réaction</th>
                                                <th>Phase</th>
                                                <th>Coût</th>
                                                <th>Nombre d'exécutions</th>
                                                <th>Nombre de clients distincts</th>
                                                <th>Voir impact</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($frequencies as $reaction): ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($reaction['description']) ?></td>
                                                    <td><?= htmlspecialchars($reaction['phase']) ?></td>
                                                    <td><?= htmlspecialchars($reaction['cout'] ?? '') ?></td>
                                                    <td><?= htmlspecialchars($reaction['frequence']) ?></td>
                                                    <td><?= htmlspecialchars($reaction['nb_clients']) ?></td>
                                                    <td>
                                                        <a href="reaction-impact?reaction_id=<?= $reaction['id'] ?>" class="btn btn-outline-primary btn-sm">Voir impact</a>
                                                    </td>
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
                                    <div class="card-title">Réactions les plus fréquentes par tranche d'âge</div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php foreach ($byAgeRange as $range => $reactions): ?>
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
    </div>
</div>