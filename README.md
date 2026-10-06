# CUB — Application web de suivi de production

Projet PHP / MySQL développé pour centraliser et simplifier le suivi d’un flux de production : dossiers de fabrication, commandes, clients, réceptions, tickets et paramètres métier.

> Projet présenté dans le cadre de ma recherche d’alternance en développement web fullstack.

## Pourquoi ce projet ?

CUB répond à un besoin concret : disposer d’une interface web unique pour consulter, filtrer et mettre à jour les informations utiles au suivi de production. Le projet m’a permis de travailler sur une application existante orientée métier, de comprendre ses règles de fonctionnement et de développer des fonctionnalités côté back-end comme côté interface.

## Fonctionnalités principales

- authentification et gestion de session ;
- planning de production avec filtres (client, commande, référence, statut et dates) ;
- création et suivi de dossiers de fabrication ;
- gestion des clients et des informations de commande ;
- gestion des réceptions et historique ;
- système de tickets et réponses ;
- paramètres métier administrables ;
- appels AJAX pour mettre à jour certaines données sans recharger toute la page ;
- journalisation de requêtes et historique d’actions.

## Stack technique

- PHP
- MySQL / MariaDB
- PDO
- HTML5 / CSS3
- JavaScript / jQuery
- AJAX
- Bootstrap 5
- WAMP pour l’environnement local

## Ce que ce projet démontre

CUB illustre notamment ma capacité à :

- comprendre et reprendre une base de code PHP existante ;
- manipuler une base de données relationnelle ;
- construire des écrans métier avec filtres et formulaires ;
- relier front-end et back-end via AJAX ;
- analyser un besoin utilisateur et le traduire en fonctionnalités ;
- rechercher des solutions de manière autonome et faire évoluer progressivement une application.

## Architecture simplifiée

```text
cub/
├── index.php                 # planning de production
├── fabForm.php               # dossier de fabrication
├── reception.php             # réception
├── tickets.php / ticket.php  # gestion des tickets
├── param-*.php               # paramètres métier
├── lib/
│   ├── db.php                # accès aux données et logique SQL
│   ├── ajax.php              # actions AJAX
│   └── tools.php             # fonctions utilitaires
├── views/                    # vues et tableaux chargés dynamiquement
├── css/
└── img/
```

## Installation locale

Le projet a été développé pour un environnement PHP + MySQL/MariaDB de type WAMP.

1. Placer le dossier dans le répertoire web local.
2. Créer une base MySQL/MariaDB nommée `cub` et importer le schéma/données de démonstration si disponibles.
3. Adapter les paramètres de connexion dans `lib/db.php` à votre environnement local.
4. Démarrer Apache et MySQL/MariaDB.
5. Ouvrir l’application depuis votre serveur local.

> Le dump SQL n’est pas inclus dans cette version du dépôt. L’application nécessite donc le schéma de base de données associé pour être exécutée complètement.

## Axes d’amélioration identifiés

Ce projet reflète une application réalisée dans un contexte d’apprentissage et constitue aussi une base de progression. Les prochaines évolutions que je souhaite y apporter sont notamment :

- requêtes préparées PDO et validation systématique des entrées ;
- mots de passe stockés avec `password_hash()` / `password_verify()` ;
- configuration de la base via variables d’environnement ;
- séparation plus nette entre accès aux données, logique métier et vues ;
- API REST pour certaines ressources ;
- tests automatisés ;
- conteneurisation Docker et pipeline CI/CD.

Cette démarche est importante pour moi : savoir montrer ce qui fonctionne, mais aussi identifier les points à renforcer et progresser sur les bonnes pratiques professionnelles.

## À propos

**Ayoub EL MAZOUZI**  
Étudiant en Master Data & IA — On recherche d’une alternance.
Intérêt particulier pour PHP, JavaScript, bases de données, développement d’applications métier et usages de l’IA comme outil d’aide au développement, avec relecture critique du code produit.

---

*Le dépôt est présenté comme projet de portfolio. Les données réelles, identifiants et éléments confidentiels ne doivent pas être publiés.*
