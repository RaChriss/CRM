/**
 * Gestion des tableaux du tableau de bord
 */

/**
 * Met à jour les statistiques principales
 * @param {Object} data - Données d'état de l'entreprise
 */
function updateMainStats(data) {
    if (!isValidData(data, true)) {
        console.warn('Données manquantes pour updateMainStats');
        return;
    }
    
    // Valeurs par défaut
    const stats = {
        animaux_disponibles: toNumber(data.animaux_disponibles),
        chiffre_affaires_annee: toNumber(data.chiffre_affaires_annee),
        clients_actifs: toNumber(data.clients_actifs),
        alertes_stocks: toNumber(data.alertes_stocks)
    };
    
    $('#main-stats').html(`
        <div class="col-md-3">
            <div class="stat-card card card-body bg-primary text-white mb-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="mb-1">Animaux Disponibles</h5>
                        <h2 class="mb-0">${stats.animaux_disponibles}</h2>
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
                        <h2 class="mb-0">${formatNumber(stats.chiffre_affaires_annee, 2, true)}</h2>
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
                        <h2 class="mb-0">${stats.clients_actifs}</h2>
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
                        <h2 class="mb-0">${stats.alertes_stocks}</h2>
                    </div>
                    <i class="fas fa-exclamation-triangle fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    `);
}

/**
 * Met à jour le tableau de résolution des problèmes
 * @param {Array} data - Données de résolution des problèmes
 */
function updateProblemResolutionTable(data) {
    const tbody = $('#problemResolutionTable tbody');
    tbody.empty();
    
    if (!isValidData(data)) {
        tbody.append('<tr><td colspan="3" class="text-muted text-center">Aucune donnée disponible</td></tr>');
        return;
    }
    
    data.forEach(item => {
        const taux = toNumber(item.taux_resolution);
        const delai = toNumber(item.delai_moyen_resolution);
        
        tbody.append(`
            <tr>
                <td>${item.type_probleme || 'Type inconnu'}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="progress progress-thin w-100 me-2">
                            <div class="progress-bar bg-success" 
                                role="progressbar" 
                                style="width: ${taux}%" 
                                aria-valuenow="${taux}" 
                                aria-valuemin="0" 
                                aria-valuemax="100">
                            </div>
                        </div>
                        <span>${Math.round(taux)}%</span>
                    </div>
                </td>
                <td>${formatNumber(delai, 1)} jours</td>
            </tr>
        `);
    });
}

/**
 * Met à jour le tableau de performance des animaux
 * @param {Array} data - Données de performance des animaux
 */
function updateAnimalPerformanceTable(data) {
    const tbody = $('#animalPerformanceTable tbody');
    tbody.empty();
    
    if (!isValidData(data)) {
        tbody.append('<tr><td colspan="3" class="text-muted text-center">Aucune donnée disponible</td></tr>');
        return;
    }
    
    data.forEach(item => {
        const taux = toNumber(item.taux_vente);
        
        tbody.append(`
            <tr>
                <td>${item.espece || ''} ${item.race || ''}</td>
                <td>${formatNumber(taux, 1)}%</td>
                <td>${formatNumber(item.prix_moyen_vente, 2, true)}</td>
            </tr>
        `);
    });
}

/**
 * Met à jour le tableau des interventions à venir
 * @param {Array} data - Données des interventions à venir
 */
function updateUpcomingInterventions(data) {
    const tbody = $('#upcomingInterventions tbody');
    tbody.empty();
    
    if (!isValidData(data)) {
        tbody.append('<tr><td colspan="4" class="text-muted text-center">Aucune intervention à venir</td></tr>');
        return;
    }
    
    data.forEach(item => {
        let dateObj;
        
        try {
            dateObj = new Date(item.date_intervention);
            if (isNaN(dateObj.getTime())) {
                throw new Error('Date invalide');
            }
        } catch (e) {
            console.warn('Date d\'intervention invalide:', item.date_intervention);
            dateObj = new Date(); // Date actuelle comme fallback
        }
        
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        let badgeClass = 'bg-primary';
        if (dateObj.toDateString() === today.toDateString()) {
            badgeClass = 'bg-warning text-dark';
        } else if (dateObj < today) {
            badgeClass = 'bg-danger';
        }
        
        tbody.append(`
            <tr>
                <td>
                    <span class="badge ${badgeClass} intervention-badge">
                        ${formatDate(dateObj)}
                    </span>
                </td>
                <td>${item.type || 'Type inconnu'}</td>
                <td>${item.client || 'Non spécifié'}</td>
                <td>
                    <button class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-info-circle"></i> Détails
                    </button>
                </td>
            </tr>
        `);
    });
}