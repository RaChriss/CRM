/**
 * Fichier principal pour l'initialisation du tableau de bord
 */

/**
 * Initialise le tableau de bord avec les données fournies
 * @param {Object} data - Données du tableau de bord
 */
function initDashboard(data) {
    try {
        console.log('Dashboard Data:', data);
        
        // Vérifier que les données sont bien structurées
        const beforeReaction = data.beforeReaction || {};
        const duringReaction = data.duringReaction || {};
        const afterReaction = data.afterReaction || {};
        const livestock = data.livestock || {};
        
        // Mettre à jour les composants
        updateMainStats(beforeReaction.company_status || {});
        updatePendingActionsChart(beforeReaction.pending_actions || []);
        updateActiveClientsChart(beforeReaction.active_clients || []);
        updateWorkloadChart(duringReaction.workload || []);
        updateReactionTimeChart(duringReaction.reaction_times || []);
        updateSatisfactionChart(afterReaction.satisfaction || []);
        updateProblemResolutionTable(afterReaction.problem_resolution || []);
        updateAnimalPerformanceChart(livestock.animal_performance || []);
        updateAnimalPerformanceTable(livestock.animal_performance || []);
        updateUpcomingInterventions(livestock.sanitary_interventions || []);
        
        showAlert('success', 'Tableau de bord chargé avec succès');
    } catch (error) {
        console.error('Erreur lors de l\'initialisation du dashboard:', error);
        showAlert('danger', 'Erreur lors du chargement des données. Veuillez réessayer.');
    }
}

/**
 * Rafraîchit une section spécifique du tableau de bord
 * @param {string} section - Section à rafraîchir (beforeReaction, duringReaction, afterReaction, livestock)
 */
function refreshSection(section) {
    try {
        showAlert('info', `Actualisation de ${section} en cours...`);
        
        // Remplacer par un appel AJAX à votre API
        $.ajax({
            url: `/api/stats/${section}`,
            method: 'GET',
            success: function(response) {
                switch(section) {
                    case 'beforeReaction':
                        updateMainStats(response.company_status || {});
                        updatePendingActionsChart(response.pending_actions || []);
                        updateActiveClientsChart(response.active_clients || []);
                        break;
                    case 'duringReaction':
                        updateWorkloadChart(response.workload || []);
                        updateReactionTimeChart(response.reaction_times || []);
                        break;
                    case 'afterReaction':
                        updateSatisfactionChart(response.satisfaction || []);
                        updateProblemResolutionTable(response.problem_resolution || []);
                        break;
                    case 'livestock':
                        updateAnimalPerformanceChart(response.animal_performance || []);
                        updateAnimalPerformanceTable(response.animal_performance || []);
                        updateUpcomingInterventions(response.sanitary_interventions || []);
                        break;
                }
                showAlert('success', `${section} actualisé avec succès`);
            },
            error: function(xhr, status, error) {
                console.error(`Erreur lors de l'actualisation de ${section}:`, error);
                showAlert('danger', `Erreur lors de l'actualisation de ${section}`);
            }
        });
    } catch (error) {
        console.error(`Erreur lors de l'actualisation de ${section}:`, error);
        showAlert('danger', `Erreur lors de l'actualisation de ${section}`);
    }
}