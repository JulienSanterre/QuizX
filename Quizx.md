# PASSWORDS :

Name | Password |
--- | --- |
admin | 123456 |
moderator | 123456 |
user | 123456 |

# ROLES :

## Admin :
    - A les droits de tous les utilisateurs de rang inférieur
    - Peu également modifié le rôle de n'importe quel utilisateur (modérateur compris) (mais ne peus pas modifier ni le mail ni le pseudo "cette option pourrais être utile en cas d'abus d'un utilisateur, voir une option de bloquage total d'utilisateur")
    - Peu ajouter, modifier ou supprimer des tags

## Moderator :
    - A les droits de tous les utilisateurs de rang inférieur
    - Peu accèder à n'importe quel contenu, le modifier, supprimer ou le bloquer (questions & réponses)
    - il peut accèdé à la liste des utilisateurs mais ne peus éditer uniquement le siens

## User :
    - A les droits de tous les utilisateurs de rang inférieur
    - Peu accèder uniquement au contenu dont il est l'auteur, il peut éditer ou supprimer un contenu **qui n'est pas bloqué**
    - Il peu également créer des questions et des réponses (même sur ses propres questions)
    - Il peut accèder uniquement à son profil
    - Il peut sélèctionner une question comme étant la meilleurs réponse et "ouvrir" ou "fermer" une question

## Visiteur (sans rôle) : 
    - Il ne peut acceder uniquement à la page d'acceuil, de login et d'enregistrement (tout les autres liens le redirigent vers le login)
    - il peut également consulté les questions et les réponses de la page d'acceuil.

# EFFET EN CASCADE :

## BDD : 
    - La suppression entraîne également la supression de toutes les réponses qui lui sont associées
    - La suppression d'un tag entraîne affecte la valeur null dans les questions avec le tag associés

## Acceuil :
    - Une question sans tag ne sera pas référencé dans la page d'acceuil (mais sera accessible dans la liste des questions)

## User :
    - La validation de la meilleur réponse entraîne la fermeture de la question. (aucune reponse ne peu plus être ajouté), l 'utilsateur peus néanmoins réactiver la question depuis l onglet ces questions (ou en cliquant sur le liens de redirection vers sa question)
    - La séléction de la meilleur réponses, entraîne la réinitialisation d'une autre meilleurs réponse séléctionnée (en cas de réouverture de status de question, la meilleur réponse reste séléctionnée afin d évité d avoir plusieurs meilleurs réponses)

# BUG CONNU :

## TAG Nav :
    - Le second naviguateur (celui des tags se basant sur les ancres) pour le 1er tag, le titre du tag s affiche en dessous du menu principale (surement dût a ca position fixed). 
    