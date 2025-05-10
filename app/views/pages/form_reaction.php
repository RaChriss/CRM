<div class="container">
    <div class="page-inner">
        <?php if (!empty($message)): ?>
            <div class="alert alert-<?= strpos($message, 'Erreur') !== false ? 'danger' : 'success' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Insertion De Reactions
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form action="<?= $base_url ?>/crm/reaction/insert" method="post">


                                    <div class="form-group">
                                        <label for="action">Actions</label>
                                        <select
                                            class="form-select"
                                            id="action"
                                            name="action_id"
                                            required>
                                            <option value="">Sélectionner une Action</option>
                                            <?php foreach ($actions as $action): ?>
                                                <option value="<?= $action['id_action'] ?>">ID:<?= $action['id_action'] ?>,<?= $action['description'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="type_reaction">Type Reaction</label>
                                        <select
                                            class="form-select"
                                            id="type_reaction"
                                            name="type_reaction_id"
                                            required>
                                            <option value="">Sélectionner un Type</option>
                                            <?php foreach ($types as $type): ?>
                                                <option value="<?= $type['id_type_reaction'] ?>"><?= $type['description'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="montant">Montant (Ar)</label>
                                        <input
                                            type="number"
                                            name="montant"
                                            class="form-control"
                                            id="montant"
                                            required
                                            min="0" />
                                    </div>

                                    <div class="form-group">
                                        <label for="date-action">Date de la Reaction</label>
                                        <input
                                            type="date"
                                            name="created_at"
                                            class="form-control"
                                            required
                                            id="date-action" />
                                    </div>

                                    <div class="form-group">
                                        <label for="descri">Commentaire</label>
                                        <input
                                            type="text"
                                            name="commentaire"
                                            class="form-control"
                                            id="descri"
                                            required
                                            placeholder="..." />
                                    </div>

                                    <input type="hidden" name="created_by" value="<?= $_SESSION['user_id'] ?>" />
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