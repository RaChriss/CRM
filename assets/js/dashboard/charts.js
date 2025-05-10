/**
 * Gestion des graphiques du tableau de bord
 */

// Objet pour stocker les instances de graphiques
const charts = {
    pendingActions: null,
    activeClients: null,
    workload: null,
    reactionTime: null,
    satisfaction: null,
    animalPerformance: null
};

/**
 * Met à jour le graphique des actions en attente
 * @param {Array} data - Données des actions en attente
 */
function updatePendingActionsChart(data) {
    if (!isValidData(data)) {
        console.warn('Aucune donnée pour pendingActionsChart');
        $('#pendingActionsChart').closest('.card-body').html('<p class="text-muted text-center">Aucune donnée disponible</p>');
        return;
    }

    const ctx = document.getElementById('pendingActionsChart').getContext('2d');
    
    if (charts.pendingActions) {
        charts.pendingActions.destroy();
    }
    
    const labels = data.map(item => item.type_action || 'Type inconnu');
    const values = data.map(item => toNumber(item.nombre_actions));
    
    charts.pendingActions = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Nombre d\'actions',
                data: values,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Nombre d\'actions'
                    }
                }
            }
        }
    });
}

/**
 * Met à jour le graphique des clients actifs
 * @param {Array} data - Données des clients actifs
 */
function updateActiveClientsChart(data) {
    if (!isValidData(data)) {
        console.warn('Aucune donnée pour activeClientsChart');
        $('#activeClientsChart').closest('.card-body').html('<p class="text-muted text-center">Aucune donnée disponible</p>');
        return;
    }

    const ctx = document.getElementById('activeClientsChart').getContext('2d');
    
    if (charts.activeClients) {
        charts.activeClients.destroy();
    }
    
    const labels = data.map(item => item.type_client || 'Type inconnu');
    const values = data.map(item => toNumber(item.nombre_clients));
    
    charts.activeClients = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: values,
                backgroundColor: generateColors(values.length),
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
}

/**
 * Met à jour le graphique de charge de travail
 * @param {Array} data - Données de charge de travail
 */
function updateWorkloadChart(data) {
    if (!isValidData(data)) {
        console.warn('Aucune donnée pour workloadChart');
        $('#workloadChart').closest('.card-body').html('<p class="text-muted text-center">Aucune donnée disponible</p>');
        return;
    }

    const ctx = document.getElementById('workloadChart').getContext('2d');
    
    if (charts.workload) {
        charts.workload.destroy();
    }
    
    charts.workload = new Chart(ctx, {
        type: 'bar', // 'horizontalBar' est déprécié, on utilise 'bar' avec indexAxis: 'y'
        data: {
            labels: data.map(item => item.departement || 'Inconnu'),
            datasets: [{
                label: 'Actions en cours',
                data: data.map(item => toNumber(item.actions_en_cours)),
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }, {
                label: 'Part du total (%)',
                data: data.map(item => toNumber(item.pourcentage_total)),
                backgroundColor: 'rgba(153, 102, 255, 0.7)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y', // Ceci remplace le type 'horizontalBar'
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: {
                    beginAtZero: true
                }
            }
        }
    });
}

/**
 * Met à jour le graphique des temps de réaction
 * @param {Array} data - Données des temps de réaction
 */
function updateReactionTimeChart(data) {
    if (!isValidData(data)) {
        console.warn('Aucune donnée pour reactionTimeChart');
        $('#reactionTimeChart').closest('.card-body').html('<p class="text-muted text-center">Aucune donnée disponible</p>');
        return;
    }

    const ctx = document.getElementById('reactionTimeChart').getContext('2d');
    
    if (charts.reactionTime) {
        charts.reactionTime.destroy();
    }
    
    charts.reactionTime = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: data.map(item => item.type_action || 'Type inconnu'),
            datasets: [{
                label: 'Temps moyen (jours)',
                data: data.map(item => toNumber(item.temps_moyen_jours)),
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2
            }, {
                label: 'Temps minimum',
                data: data.map(item => toNumber(item.temps_min_jours)),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2
            }, {
                label: 'Temps maximum',
                data: data.map(item => toNumber(item.temps_max_jours)),
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    beginAtZero: true
                }
            }
        }
    });
}

/**
 * Met à jour le graphique de satisfaction
 * @param {Array} data - Données de satisfaction
 */
function updateSatisfactionChart(data) {
    if (!isValidData(data)) {
        console.warn('Aucune donnée pour satisfactionChart');
        $('#satisfactionChart').closest('.card-body').html('<p class="text-muted text-center">Aucune donnée disponible</p>');
        return;
    }

    const ctx = document.getElementById('satisfactionChart').getContext('2d');
    
    if (charts.satisfaction) {
        charts.satisfaction.destroy();
    }
    
    // Filtrer les données globales
    const globalData = data.find(item => item.type_action === 'GLOBAL') || {};
    const typeData = data.filter(item => item.type_action !== 'GLOBAL');
    
    if (!isValidData(typeData)) {
        console.warn('Données insuffisantes pour le graphique de satisfaction');
        $('#satisfactionChart').closest('.card-body').html('<p class="text-muted text-center">Aucune donnée disponible</p>');
        return;
    }
    
    const globalNoteMoyenne = toNumber(globalData.note_moyenne);
    const globalPourcentageSatisfaits = toNumber(globalData.pourcentage_satisfaits);
    
    charts.satisfaction = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: typeData.map(item => item.type_action || 'Type inconnu'),
            datasets: [{
                label: 'Note moyenne',
                data: typeData.map(item => toNumber(item.note_moyenne)),
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                yAxisID: 'y'
            }, {
                label: '% Satisfaits',
                data: typeData.map(item => toNumber(item.pourcentage_satisfaits)),
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                type: 'line',
                yAxisID: 'y1'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 5,
                    title: {
                        display: true,
                        text: 'Note (sur 5)'
                    }
                },
                y1: {
                    beginAtZero: true,
                    max: 100,
                    position: 'right',
                    grid: {
                        drawOnChartArea: false
                    },
                    title: {
                        display: true,
                        text: '% Satisfaits'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: `Satisfaction globale: ${globalNoteMoyenne.toFixed(1)}/5 (${globalPourcentageSatisfaits.toFixed(0)}% satisfaits)`,
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                }
            }
        }
    });
}

/**
 * Met à jour le graphique de performance des animaux
 * @param {Array} data - Données de performance des animaux
 */
function updateAnimalPerformanceChart(data) {
    if (!isValidData(data)) {
        console.warn('Aucune donnée pour animalPerformanceChart');
        $('#animalPerformanceChart').closest('.card-body').html('<p class="text-muted text-center">Aucune donnée disponible</p>');
        return;
    }

    const ctx = document.getElementById('animalPerformanceChart').getContext('2d');
    
    if (charts.animalPerformance) {
        charts.animalPerformance.destroy();
    }
    
    // Grouper par espèce
    const species = [...new Set(data.map(item => item.espece))];
    const datasets = species.map(specie => {
        const specieData = data.filter(item => item.espece === specie);
        return {
            label: specie,
            data: specieData.map(item => toNumber(item.taux_vente)),
            backgroundColor: getRandomColor()
        };
    });
    
    const labels = [...new Set(data.map(item => item.race))];
    
    charts.animalPerformance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Taux de vente (%)'
                    }
                }
            }
        }
    });
}