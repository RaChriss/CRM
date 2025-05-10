/**
 * Utilitaires pour le tableau de bord
 */

/**
 * Affiche une alerte dans le conteneur d'alertes
 * @param {string} type - Type d'alerte (success, info, warning, danger)
 * @param {string} message - Message à afficher
 */
function showAlert(type, message) {
    const alert = $(`
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `);
    $('#alerts-container').append(alert);
    setTimeout(() => alert.alert('close'), 5000);
}

/**
 * Formate une date en format français
 * @param {Date} date - Date à formater
 * @returns {string} - Date formatée
 */
function formatDate(date) {
    if (!(date instanceof Date) || isNaN(date.getTime())) {
        return 'Date invalide';
    }
    
    const options = {
        weekday: 'short',
        day: 'numeric',
        month: 'short',
        hour: '2-digit',
        minute: '2-digit'
    };
    return date.toLocaleDateString('fr-FR', options);
}

/**
 * Génère une couleur aléatoire avec transparence
 * @returns {string} - Couleur au format hexadécimal avec transparence
 */
function getRandomColor() {
    const letters = '0123456789ABCDEF';
    let color = '#';
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color + '80'; // Ajouter de la transparence
}

/**
 * Vérifie si une valeur est vide (null, undefined, chaîne vide, tableau vide)
 * @param {*} value - Valeur à vérifier
 * @returns {boolean} - true si la valeur est vide, false sinon
 */
function isEmpty(value) {
    if (value === null || value === undefined) return true;
    if (typeof value === 'string' && value.trim() === '') return true;
    if (Array.isArray(value) && value.length === 0) return true;
    if (typeof value === 'object' && Object.keys(value).length === 0) return true;
    return false;
}

/**
 * Convertit une valeur en nombre
 * @param {*} value - Valeur à convertir
 * @param {number} defaultValue - Valeur par défaut si la conversion échoue
 * @returns {number} - Nombre converti ou valeur par défaut
 */
function toNumber(value, defaultValue = 0) {
    const number = parseFloat(value);
    return isNaN(number) ? defaultValue : number;
}

/**
 * Formate un nombre pour l'affichage
 * @param {number} value - Valeur à formater
 * @param {number} decimals - Nombre de décimales
 * @param {boolean} withEuro - Ajouter le symbole € à la fin
 * @returns {string} - Nombre formaté
 */
function formatNumber(value, decimals = 2, withEuro = false) {
    if (value === null || value === undefined || isNaN(value)) {
        return '-';
    }
    
    const formattedNumber = Number(value).toFixed(decimals);
    return withEuro ? `${formattedNumber}€` : formattedNumber;
}

/**
 * Vérifie si un tableau ou un objet est valide et non vide
 * @param {*} data - Données à vérifier
 * @param {boolean} allowEmpty - Autoriser les tableaux vides
 * @returns {boolean} - true si les données sont valides, false sinon
 */
function isValidData(data, allowEmpty = false) {
    if (data === null || data === undefined) return false;
    if (Array.isArray(data) && !allowEmpty && data.length === 0) return false;
    if (typeof data === 'object' && !Array.isArray(data) && Object.keys(data).length === 0) return false;
    return true;
}

/**
 * Génère un tableau de couleurs pour les graphiques
 * @param {number} count - Nombre de couleurs à générer
 * @returns {string[]} - Tableau de couleurs
 */
function generateColors(count) {
    // Couleurs prédéfinies pour une meilleure cohérence visuelle
    const baseColors = [
        'rgba(54, 162, 235, 0.7)',   // bleu
        'rgba(255, 99, 132, 0.7)',   // rouge
        'rgba(255, 206, 86, 0.7)',   // jaune
        'rgba(75, 192, 192, 0.7)',   // vert
        'rgba(153, 102, 255, 0.7)',  // violet
        'rgba(255, 159, 64, 0.7)'    // orange
    ];
    
    const colors = [];
    
    // Si on a besoin de plus de couleurs que celles prédéfinies
    for (let i = 0; i < count; i++) {
        if (i < baseColors.length) {
            colors.push(baseColors[i]);
        } else {
            colors.push(getRandomColor());
        }
    }
    
    return colors;
}