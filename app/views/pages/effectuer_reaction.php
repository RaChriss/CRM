<div class="container">
    <div class="page-inner">
    <?php if (!empty($message)): ?>
            <div class="alert alert-<?= strpos($message, 'Erreur') !== false ? 'danger' : 'success' ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>
        <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
                <h3 class="fw-bold mb-3">Effectuer une Réaction</h3>
                <h6 class="op-7 mb-2">Gérer les réactions des clients pour les actions enregistrées</h6>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card card-round">
                    <div class="card-header">
                        <div class="card-head-row">
                            <div class="card-title">Liste des Actions</div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="actionsTable" class="table align-items-center mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">Description de l'Action</th>
                                        <th scope="col">Client</th>
                                        <th scope="col">Date de l'Action</th>
                                        <th scope="col">Réaction</th>
                                        <th scope="col">Date de Réaction</th>
                                        <th scope="col">Valider</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($actions as $action): ?>
                                        <tr>
                                            <form method="post" class="effectuer-reaction-form">
                                                <td><?= htmlspecialchars($action['description']) ?></td>
                                                <td><?= htmlspecialchars($action['nom'] . ' ' . $action['prenom']) ?></td>
                                                <td><?= htmlspecialchars($action['date_action']) ?></td>
                                                <td>
                                                    <select name="reaction" class="form-select" required>
                                                        <option value="">Sélectionnez une réaction</option>
                                                        <?php foreach ($reactions as $reaction): ?>
                                                            <option value="<?= $reaction['id'] ?>">
                                                                <?= htmlspecialchars($reaction['description']) ?> (<?= htmlspecialchars($reaction['cout']) ?> Ar)
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="date" name="reaction_date" class="form-control" required>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="action_id" value="<?= $action['id'] ?>">
                                                    <button type="submit" class="btn btn-icon btn-round btn-primary btn-sm">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </td>
                                            </form>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div id="responseMessage" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Initialiser DataTable
        $('#actionsTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json"
            }
        });

        // Gestion AJAX pour valider une réaction
        $('.effectuer-reaction-form').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const formData = form.serialize();

            $.ajax({
                url: window.baseUrl + '/reaction-client/valider-reaction',
                type: 'POST',
                data: formData,
                success: function(response) {
                    $('#responseMessage').html('<div class="alert alert-success">Réaction effectuée avec succès.</div>');
                    form.closest('tr').fadeOut(1000, function() {
                        $(this).remove();
                    });
                    swal("Succès!", "La réaction a été validée avec succès.", "success");
                },
                error: function() {
                    $('#responseMessage').html('<div class="alert alert-danger">Erreur lors de l\'exécution de la réaction.</div>');
                    swal("Erreur!", "Une erreur s'est produite lors de la validation.", "error");
                }
            });
        });
    });
</script>