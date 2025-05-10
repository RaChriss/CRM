<div class="container">
    <div class="page-inner">
        <?php if (!empty($message)): ?>
            <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Insertion D'Actions
                            <?php if (isset($message)): ?>
                                <span class="text-muted"><?= htmlspecialchars($message) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?= $base_url ?>/crm/action/insert" method="post">

                                    <div class="form-group">
                                        <label for="descri">Descriptions</label>
                                        <input
                                            type="text"
                                            name="description"
                                            class="form-control"
                                            id="descri"
                                            required
                                            placeholder="..." />
                                    </div>
                                    <div class="form-group">
                                        <label for="date-action">Date de l'Action</label>
                                        <input
                                            type="date"
                                            name="created_at"
                                            class="form-control"
                                            required
                                            id="date-action" />
                                    </div>
                                    <div class="form-group">
                                        <label for="client">Clients</label>
                                        <select
                                            class="form-select"
                                            id="client"
                                            name="client_id"
                                            required>
                                            <option value="">Sélectionner un client</option>
                                            <?php foreach ($clients as $client): ?>
                                                <option value="<?= $client['id'] ?>"><?= $client['nom'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="type_action">Type Action</label>
                                        <select
                                            class="form-select"
                                            id="type_action"
                                            name="type_action_id"
                                            required>
                                            <?php foreach ($types as $type): ?>
                                                <option value="<?= $type['id'] ?>"><?= $type['description'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        </select>
                                    </div>
                                    <div class="card-action">
                                        <button class="btn btn-success">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>