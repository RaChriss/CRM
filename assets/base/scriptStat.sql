-- Nombre total d'actions et réactions par type
SELECT 
    c.type AS type_client,
    ta.description AS type_action,
    COUNT(a.id_action) AS nombre_actions,
    COUNT(r.id_reaction) AS nombre_reactions,
    AVG(DATEDIFF(r.created_at, a.created_at)) AS temps_reaction_moyen_jours,
    SUM(r.montant) AS montant_total_reactions
FROM 
    clients c
LEFT JOIN 
    actions a ON c.id_client = a.client_id
LEFT JOIN 
    type_actions ta ON a.type_action_id = ta.id_type_action
LEFT JOIN 
    reactions r ON a.id_action = r.action_id
GROUP BY 
    c.type, ta.description
ORDER BY 
    c.type, nombre_actions DESC;



-- Activité des clients avant et après une réaction
SELECT 
    c.id_client,
    c.nom,
    c.type,
    COUNT(DISTINCT a_avant.id_action) AS actions_avant_reaction,
    COUNT(DISTINCT r.id_reaction) AS reactions_recues,
    COUNT(DISTINCT a_apres.id_action) AS actions_apres_reaction,
    CASE 
        WHEN COUNT(DISTINCT a_apres.id_action) > COUNT(DISTINCT a_avant.id_action) THEN 'Augmentation'
        WHEN COUNT(DISTINCT a_apres.id_action) < COUNT(DISTINCT a_avant.id_action) THEN 'Diminution'
        ELSE 'Stable'
    END AS evolution_engagement
FROM 
    clients c
LEFT JOIN 
    actions a_avant ON c.id_client = a_avant.client_id
LEFT JOIN 
    reactions r ON a_avant.id_action = r.action_id
LEFT JOIN 
    actions a_apres ON c.id_client = a_apres.client_id 
    AND a_apres.created_at > r.created_at
    AND DATEDIFF(a_apres.created_at, r.created_at) <= 30 -- 30 jours après la réaction
GROUP BY 
    c.id_client, c.nom, c.type;


-- Efficacité des différents types de réactions
SELECT 
    tr.description AS type_reaction,
    COUNT(r.id_reaction) AS nombre_reactions,
    AVG(DATEDIFF(a_apres.created_at, r.created_at)) AS delai_reengagement_moyen,
    COUNT(DISTINCT CASE WHEN a_apres.id_action IS NOT NULL THEN c.id_client END) AS clients_reengages,
    COUNT(DISTINCT c.id_client) AS clients_total,
    ROUND(COUNT(DISTINCT CASE WHEN a_apres.id_action IS NOT NULL THEN c.id_client END) / 
          COUNT(DISTINCT c.id_client) * 100, 2) AS taux_reengagement
FROM 
    type_reactions tr
LEFT JOIN 
    reactions r ON tr.id_type_reaction = r.type_reaction_id
LEFT JOIN 
    actions a ON r.action_id = a.id_action
LEFT JOIN 
    clients c ON a.client_id = c.id_client
LEFT JOIN 
    actions a_apres ON c.id_client = a_apres.client_id 
    AND a_apres.created_at > r.created_at
    AND DATEDIFF(a_apres.created_at, r.created_at) <= 30
GROUP BY 
    tr.description
ORDER BY 
    taux_reengagement DESC;


-- Temps de réponse moyen par type d'action et type de client
SELECT 
    c.type AS type_client,
    ta.description AS type_action,
    AVG(DATEDIFF(r.created_at, a.created_at)) AS delai_reaction_moyen_jours,
    MIN(DATEDIFF(r.created_at, a.created_at)) AS delai_min,
    MAX(DATEDIFF(r.created_at, a.created_at)) AS delai_max
FROM 
    actions a
JOIN 
    clients c ON a.client_id = c.id_client
JOIN 
    type_actions ta ON a.type_action_id = ta.id_type_action
JOIN 
    reactions r ON a.id_action = r.action_id
GROUP BY 
    c.type, ta.description
ORDER BY 
    c.type, delai_reaction_moyen_jours;


-- Réactions en attente de validation
SELECT 
    c.type AS type_client,
    ta.description AS type_action,
    tr.description AS type_reaction,
    COUNT(r.id_reaction) AS nombre_en_attente,
    AVG(DATEDIFF(CURRENT_DATE, r.created_at)) AS delai_attente_moyen_jours,
    SUM(r.montant) AS montant_total_en_attente
FROM 
    reactions r
JOIN 
    actions a ON r.action_id = a.id_action
JOIN 
    clients c ON a.client_id = c.id_client
JOIN 
    type_actions ta ON a.type_action_id = ta.id_type_action
JOIN 
    type_reactions tr ON r.type_reaction_id = tr.id_type_reaction
WHERE 
    r.statut = 'en attente'
    AND tr.besoin_validation = TRUE
GROUP BY 
    c.type, ta.description, tr.description
ORDER BY 
    delai_attente_moyen_jours DESC;


-- Top 10 des Clients par Nombre d'Actions
SELECT 
    c.id_client,
    c.nom,
    c.type,
    COUNT(a.id_action) AS nombre_actions,
    COUNT(r.id_reaction) AS nombre_reactions_recues,
    MIN(a.created_at) AS premiere_action,
    MAX(a.created_at) AS derniere_action
FROM 
    clients c
LEFT JOIN 
    actions a ON c.id_client = a.client_id
LEFT JOIN 
    reactions r ON a.id_action = r.action_id
GROUP BY 
    c.id_client, c.nom, c.type
ORDER BY 
    nombre_actions DESC
LIMIT 10;


-- Clients avec le Plus d'Interactions Récentes (30 derniers jours)
SELECT 
    c.id_client,
    c.nom,
    c.type,
    COUNT(a.id_action) AS actions_30j,
    COUNT(r.id_reaction) AS reactions_recues_30j,
    DATEDIFF(CURRENT_DATE, MAX(a.created_at)) AS jours_depuis_derniere_action
FROM 
    clients c
JOIN 
    actions a ON c.id_client = a.client_id
LEFT JOIN 
    reactions r ON a.id_action = r.action_id
WHERE 
    a.created_at >= DATE_SUB(CURRENT_DATE, INTERVAL 30 DAY)
GROUP BY 
    c.id_client, c.nom, c.type
ORDER BY 
    actions_30j DESC
LIMIT 10;


-- Clients avec le Meilleur Taux de Réponse de l'Entreprise
SELECT 
    c.id_client,
    c.nom,
    c.type,
    COUNT(a.id_action) AS nombre_actions,
    COUNT(r.id_reaction) AS nombre_reponses,
    ROUND(COUNT(r.id_reaction) / COUNT(a.id_action) * 100, 2) AS taux_reponse,
    AVG(DATEDIFF(r.created_at, a.created_at)) AS delai_reponse_moyen_jours
FROM 
    clients c
JOIN 
    actions a ON c.id_client = a.client_id
LEFT JOIN 
    reactions r ON a.id_action = r.action_id
GROUP BY 
    c.id_client, c.nom, c.type
HAVING 
    COUNT(a.id_action) >= 3  -- Au moins 3 actions pour éviter les faux positifs
ORDER BY 
    taux_reponse DESC, nombre_actions DESC
LIMIT 10;


-- Clients les Plus Actifs par Type
SELECT 
    c.type,
    c.id_client,
    c.nom,
    COUNT(a.id_action) AS nombre_actions,
    RANK() OVER (PARTITION BY c.type ORDER BY COUNT(a.id_action) DESC) AS classement
FROM 
    clients c
JOIN 
    actions a ON c.id_client = a.client_id
GROUP BY 
    c.type, c.id_client, c.nom
HAVING 
    COUNT(a.id_action) > 0
ORDER BY 
    c.type, classement;


-- Clients avec le Plus Haut Engagement (Actions + Réactions)
SELECT 
    c.id_client,
    c.nom,
    c.type,
    COUNT(DISTINCT a.id_action) AS nombre_actions,
    COUNT(DISTINCT r.id_reaction) AS nombre_reactions_recues,
    SUM(r.montant) AS montant_total_reactions,
    COUNT(DISTINCT a.id_action) + COUNT(DISTINCT r.id_reaction) AS score_engagement
FROM 
    clients c
LEFT JOIN 
    actions a ON c.id_client = a.client_id
LEFT JOIN 
    reactions r ON a.id_action = r.action_id
GROUP BY 
    c.id_client, c.nom, c.type
ORDER BY 
    score_engagement DESC
LIMIT 10;


