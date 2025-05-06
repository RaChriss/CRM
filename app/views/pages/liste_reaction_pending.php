<div class="container mt-4">
    <h1 class="mb-4">Liste des Réactions en Attente</h1>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Réaction</th>
                <th>Client</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($reactions)): ?>
                <?php foreach ($reactions as $reaction): ?>
                    <tr>
                        <td><?= htmlspecialchars($reaction['description']) ?></td>
                        <td><?= htmlspecialchars($reaction['nom'] . ' ' . $reaction['prenom']) ?></td>
                        <td><?= htmlspecialchars($reaction['date_reaction']) ?></td>
                        <td>
                            <form method="post" action="<?= htmlspecialchars(Flight::get('flight.base_url') . '/reaction-client/accepter-reaction') ?>" class="d-inline">
                                <input type="hidden" name="reaction_effectue_id" value="<?= $reaction['id'] ?>">
                                <button type="submit" class="btn btn-success btn-sm">Valider</button>
                            </form>
                            <form method="post" action="<?= htmlspecialchars(Flight::get('flight.base_url') . '/reaction-client/refuser-reaction') ?>" class="d-inline">
                                <input type="hidden" name="reaction_effectue_id" value="<?= $reaction['id'] ?>">
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