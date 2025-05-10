<div class="container mt-4">
<?php if (!empty($message)): ?>
            <div class="alert alert-<?= strpos($message, 'Erreur') !== false ? 'danger' : 'success' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
    <h1 class="mb-4">Liste des Réactions en Attente</h1>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID Reaction</th>
                <th>ID Action</th>
                <th>Type Reaction</th>
                <th>Montant (Ar)</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reactions)): ?>
                <?php foreach ($reactions as $reaction):
                    $id_reaction = $reaction['id_reaction'];
                ?>
                    <tr>
                        <td>
                            <a href="<?= $base_url ?>/crm/reaction/details?idReaction=<?= $id_reaction ?>">
                                <?= htmlspecialchars($id_reaction) ?></a>
                        </td>
                        <td>
                            <a href="<?= $base_url ?>/crm/action/details?idAction=<?= $reaction['action_id'] ?>">
                                <?= htmlspecialchars($reaction['action_id']) ?></a>
                        </td>
                        <td><?= htmlspecialchars($reaction['description']) ?></td>`
                        <td><?= htmlspecialchars($reaction['montant']) ?></td>
                        <td>
                            <form method="post" action="<?= $base_url ?>/crm/reaction/validate" class="d-inline">
                                <input type="hidden" name="reaction_effectue_id" value="<?= $id_reaction ?>">
                                <button type="submit" class="btn btn-success btn-sm">Valider</button>
                            </form>
                            <form method="post" action="<?= $base_url ?>/crm/reaction/refuse" class="d-inline">
                                <input type="hidden" name="reaction_effectue_id" value="<?= $id_reaction ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Refuser</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Aucune réaction en attente.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>