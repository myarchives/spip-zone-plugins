Plugin Albums : todo
====================

Liste de choses à faire, notes et idées diverses, sans version particulière ciblée.

## Liste des albums liés

- Bouton pour transvaser les documents d'un album vers le portfolio.
- Bouton pour transvaser les documents du portfolio dans un nouvel album.
(portfolio = illustrations + portfolio + documents)

## Liste des albums
Quand on fait une recherche dans l'espace privé, la liste des albums n'a pas une apparence identique aux autres listes : les listes "standard" sont en un seul bloc, tandis que la liste des albums est constituée de plusieurs blocs, avec le nombre de résultats et les critères de tri en dehors.
Ça jure un peu dans ce beau tableau. Essayer, si possible, de rendre la liste un peu plus standard.

## Fichiers surchargés du plugin Médias
Plusieurs fichiers sont surchargés pour régler des problèmes javascripts, ou ajouter des éléments.
Des fois il n'y a pas le choix, mais voir s'il y a moyen de s'en passer.

- `prive/objets/editer/colonne_documents.html` :
ajout des albums et d'un mini menu pour basculer entre les documents et les albums.
- `formulaires/inc-upload_document.html` :
modifications afin de pouvoir afficher plusieurs fois le formulaire sur une même page.
- `prive/objets/contenu/portfolio_document.html` :
pour afficher les documents des albums, utiliser notre squelette maison.

## Déplacements des documents entre album par cliquer-glisser

- Lorsqu'on valide le formulaire, la liste entière des albums est rechargée. Il faudrait recharger uniquement les albums impactés.
- Enregistrer la position des documents : ajouter une colonne `position` dans la table `spip_albums_liens` et s'en servir pour trier les docs d'un album (marcimat).

## Albumothèque
Ajouter des filtres selon les statuts ? 

## Squelette pour choisir un album
Trouver un moyen pour avoir un aperçu plus détaillé des documents

## Compatibilité avec le plugin «insérer modèles»
Formulaire pour insérer les balises `<album>` : inutile de réinventer la roue, se reposer entièrement sur plugin insérer modèles.
Mais pour ça, il va falloir intervenir sur celui-ci légèrement : dans la 1ère étape, il faudrait qu'il puisse lister les variantes d'un seul type de modèle, par exemple en ajoutant un paramètre au formulaire. Ajouter également la prise en charge du paramètre de saisie `config=plugin/option`.
Eventuellement, en faire une dépendance obligatoire ?
