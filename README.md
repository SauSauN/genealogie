
# Projet Laravel — Site de Généalogie avec Modération Communautaire

## Objectif

Ce projet est un site de généalogie qui permet aux utilisateurs de :

- Créer des fiches "personne"
- Définir des relations parent/enfant
- Inviter d'autres membres de la famille à rejoindre la plateforme
- Proposer des modifications (ajout de relations, corrections d'information)
- Participer à la modération communautaire des propositions

---

## Structure de la base de données

Le schéma de la base de données a été conçu pour gérer :

- Les utilisateurs
- Les fiches personnes
- Les relations de parenté
- Les propositions de modifications
- Les votes sur ces propositions

**Visualiser le schéma ici :**  
[dbdiagram.io — Modèle de données](https://dbdiagram.io/d/6802d2321ca52373f588da12)

---

## Tables principales

### `users`

Contient les utilisateurs du site (nom, email, mot de passe, etc.)

### `people`

Fiches représentant des personnes dans l’arbre généalogique

### `relationships`

Relations de type parent/enfant entre les personnes

### `proposals`

Propositions de modification d'une fiche ou d'une relation (en attente de validation)

### `proposal_votes`

Votes de la communauté pour chaque proposition (`approve` ou `reject`)

---

## Évolution des données dans les cas d’usage

### Cas 1 : Propositions de modification

Lorsqu’un utilisateur propose :
Une **modification de fiche ou l'ajout d’une relation**, une entrée est créée dans la table `proposals` avec :

- `user_id` (l'auteur)
- `type` ("person_update" ou "add_relationship")
- Les champs concernés (dans `content`)
- `status = "pending"`

---

### Cas 2 : Validation des modifications

Chaque utilisateur peut ensuite voter (1 seule fois) :

- **3 votes "approve"** → La modification est appliquée et `status = "approved"`
  
- **3 votes "reject"** → La modification est rejetée et `status = "rejected"`

Les votes sont stockés dans `proposal_votes`.

---

## Sécurité & intégrité

- Seuls les utilisateurs connectés peuvent proposer des modifications.
- Les modifications sont **modérées** par la communauté.
- Un utilisateur ne peut voter **qu'une seule fois** par proposition.
- L’historique des décisions est conservé dans les tables `proposals` et `proposal_votes`.

---

## Technologies utilisées

- Laravel 10
- MySQL
- Blade (Vue Laravel)
- Tailwind CSS
- PHP 8.1+
