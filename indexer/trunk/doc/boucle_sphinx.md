
Boucle (SPHINX)
===============

Description de la boucle SPIP (SPHINX) qui crée un itérateur spécifique pour intérroger des données d'un serveur sphinx.

Tags utilisés dans ce document :

* `@defaut x` : Le critère n'est pas obligatoire, sa valeur par défaut en absence est 'x'
* `@unique` : Le critère ne peut être utilisé qu'une fois (la 2è utilisation écrase la première description)
* `@multiple` : Le critère peut être présent plusieurs fois; dans ce cas, les éléments sont cumulatifs.
* `@syntaxe` : Syntaxe du critère



INDEX
-----

* @syntaxe `{index nom[,nom[,nom[...]]]}`
* @defaut SPHINX_DEFAULT_INDEX.
* @unique

**Exemples**

```
{index *}
{index #ENV{source,spip}}
{index #ENV{source,''}}    // '' prend l'index par défaut
{index spip,visites}       // interroge 2 index (sur le même serveur sphinx)
```


SELECT
------

* @syntaxe `{select champ[,champ[,champ[...]]]}`
* @defaut *
* @multiple

Note: Certains critères modifient également la partie SELECT de la requête.
C'est le cas de : `{snippet ...}`, `{recherche ...}`

**Exemples**

```
{select *}
{select YEAR(date) AS annee}
{select MONTH(date) AS mois}

Les 3 peuvent aussi s'écrire :
{select *, YEAR(date) AS annee, MONTH(date) AS mois}
```



RECHERCHE
---------

* @syntaxe `{recherche phrase[,phrase[,phrase[...]]]}`
* @unique

Si plusieurs phrases sont passées, elles seront concaténées par un espace.

Note: le critère `{recherche ...}` modifie également la partie SELECT de la requête
en ajoutant le calcul du score de recherche dans le champ `score`.

**Exemples**

```
{recherche #ENV*{recherche}}
{recherche #ENV*{recherche},#ENV*{phrase}}
```



PAR
---

* @syntaxe `{[!]par champ[,champ[,champ[...]]]}`
* @multiple

Critère de SPIP surchargé.

**Exemples**

```
{!par date}
{par properties.objet, properties.id_objet}
{!par properties.objet, properties.id_objet}
```

Voir aussi, plus bas, la section "tri sélectif"


INVERSE
-------

* @syntaxe `{inverse[ sens]}`
* @multiple

Critère de SPIP surchargé

**Exemples**

```
{par date}{inverse}
```




SNIPPET
-------

* @syntaxe `{snippet champ[,phrase[,limit[,as]]]}`
* @defaut `{snippet content,'',200,snippet}`
* @multiple

Permet d'obtenir des extraits de contenu proche d'un ou des mots de la phrase transmise.

Les mots, qui seront mis en gras par le snippet, sont extraits de la phrase
en ne prenant que les caractères pertinents. Les mots ou chiffres trop courts sont
ignorés.

En absence de critère, dès que des phrases sont disponibles
(critère recherche, filtres tags/auteurs…), un snippet est créé automatiquement
avec les valeurs par défaut et les mots extraits de ces phrases.


**Exemples**

```
{snippet content}                               // calculera automatiquement les mots
{snippet content,#ENV*{recherche}}
{snippet content,#ENV*{recherche},200}
{snippet content,#ENV*{recherche},200,snippet}
{snippet content,'',200,snippet}                // calculera automatiquement les mots
```



FACET
-----

* @syntaxe `{facet alias,query}`
* @multiple

Ajoute une sous requête de facette selon la syntaxe de sphinx.

**Exemples**

```
{facet auteurs, properties.authors ORDER BY COUNT(*) DESC}
{facet tags, properties.tags ORDER BY COUNT(*) DESC}
{facet annee, YEAR(date) ORDER BY date DESC}
{facet favs, LENGTH(properties.share) AS favs ORDER BY FACET() DESC}
```




TRI SÉLECTIF
----------------


### Exemple de tri sur un score calculé

```
{select WEIGHT()*(1+LENGTH(properties.share)) AS score2}
{!par score2}
```


### Exemple de tri sur un « time segment »

Formule reprise de [Doing time segments, geodistance searches, and overrides in SphinxQL](http://sphinxsearch.com/blog/2010/06/27/doing-time-segments-geodistance-searches-and-overrides-in-sphinxql/)

```
#SET{
	tseg,
	"* ,INTERVAL(date, NOW()-90*86400, NOW()-30*86400, NOW()-7*86400, NOW()-86400, NOW()-3600) AS tseg"
}
<BOUCLE_recherche_sphinx(SPHINX)
	{index #ENV{source,spip}}
	{recherche #ENV*{recherche}}
	{select #GET{tseg}}
	{!par tseg}
	{!par score}
	{facet auteurs, properties.authors ORDER BY COUNT(*) DESC}
	{facet tags, properties.tags ORDER BY COUNT(*) DESC}
	{facet date, YEAR(date) ORDER BY date DESC}
>
```



FILTRER
-------

- @syntaxe `{filter #TRUC, expression select si contenu, expression select si '-'}`

Dans Sphinx on ne peut pas appliquer de critères calculés dans le WHERE directement.
Il faut créer un calcul dans la partie SELECT, avec un AS, puis utiliser le résultat
de ce calcul dans la partie WHERE.

Pour simplifier, le critère `{filter ...}` s’occupe de gérer cela, avec quelques limitations. Notamment on suppose ici que la sélection retourne un booléen (1 ou 0). Chaque filtre crée le where associé (filtre = 1).

- Le premier paramètre est la donnée, souvent issue de l’environnement du squelette,
qui servira à restreindre notre sélection. On ne peut passer qu’une donnée extérieure.
 Le filtre ne s’appliquera que si la donnée existe et a du contenu. Exemple `#ENV{auteur}`
- Le dexième paramètre est une expression de SELECT, sans le AS. Les mots `@valeur` ou `@valeurs` seront remplacés par une valeur ou une liste de valeurs, provenant du premier paramètre. Exemple : `IN(properties.authors, @valeurs)`
- Le troisième paramètre optionnel est une expression SELECT qui s’applique si on demande à trouver des documents SANS quelque chose, en passant `-` à la variable.
 Exemple : `LENGTH(properties.authors) = 0`, sera utilisé si `#ENV{auteur}` vaut `-`


**Remplacements automatiques** 

Les clés `@valeur` et `@valeurs` sont remplacées par la donnée attendue quotée, ou les données attendues quotées et séparées par des virgules.

Si `#ENV{tags}` vaut `array('toto','tata')`, alors `@valeurs` aura `"'toto', 'tata'"`


**Exemples**

```
{filter #ENV{auteur}, 'IN(properties.authors, @valeurs)', 'LENGTH(properties.authors) = 0'}
{filter #ENV{tag}, 'IN(properties.tag, @valeurs)', 'LENGTH(properties.tags) = 0'}
{filter #ENV{annee}, 'YEAR(date) = @valeur' }
{filter #ENV{favs}, @valeur <= LENGTH(properties.share)}
```

FILTRES IN, ALL, ANY et ALL_IN
------------------------------

Sphinx propose différentes fonctions pour sélectionner des éléments contenus dans des tableaux json. Il propose IN, ALL, ANY. Ces fonctions peuvent être utilisées dans les sélections pour le critère `filter`.

### IN

- @syntaxe `IN(champ, valeur1[, valeur2])` 

Permet de trouver les documents ayant le texte 'valeur1' dans le tableau 'champ'. 
Si plusieurs valeurs sont passées, il retourne VRAI si l’une des valeurs est présentes. C'est donc un OR qui est fait.

**Exemple** 

Retourner les résulats qui ont au moins 1 des identifiants de mots contenus dans le tableau `#ENV{tag}` s’il existe

```
{filter #ENV{tag}, 'IN(properties.mots.ids, @valeurs)', 'LENGTH(properties.mots.ids) = 0'}
```
  
### ALL_IN (spécifique)

Cette fonction est ajoutée par ce plugin (ne fait pas partie de l’API Sphinx).

- @syntaxe `ALL_IN(champ, valeur1[, valeur2])`

Permet de trouver les documents ayant le texte 'valeur1' dans le tableau 'champ'. 
Si plusieurs valeurs sont passées, il retourne VRAI si toutes les valeurs sont présentes. C'est donc un AND qui est fait.

En interne on remplace `ALL_IN(champ, v1, v2, v3)` par `IN(champ, v1) & IN(champ, v2) & IN(champ, v3)`. De même avec `ALL_IN(champ, @valeurs)` sur chaque valeur.

**Exemple**

Retourner les résulats qui ont tous les identifiants de mots contenus dans le tableau `#ENV{tag}` s’il existe

```
{filter #ENV{tag}, 'ALL_IN(properties.mots.ids, @valeurs)', 'LENGTH(properties.mots.ids) = 0'}
```


### ANY

- @syntaxe `ANY(cond FOR item IN champ)` 

Retourne vrai si au moins un des éléments du tableau champ valide la condition cond.

**Exemple à vérifier**
  
Retourne vrai si un des identifiants de mots est entre 10 et 20.

```
ANY(id>10 AND id<20 FOR id IN properties.mots.ids)
```


### ALL

- @syntaxe `ALL(cond FOR item IN champ)` 

Retourne vrai si tous les éléments du tableau champ valident la condition cond.

**Exemple à vérifier** 

Retourne vrai si tous les identifiants de mots sont entre 10 et 20.

```
ALL(id>10 AND id<20 FOR id IN properties.mots.ids)
```



FILTRES SPÉCIFIQUES
-------------------

Des filtres spécifiques à des cas courants de comparaisons sont pré-programmés, ce qui évite de devoir connaître et écrire soi-même le code Sphinx des tests.


### Filtre pour un champ n'ayant qu'une valeur (mono-valué)

* @syntaxe `{filtermono test, champ, valeur(s)[, comparaison]}`

Le test en premier permet de passer n’importe quelle valeur (avec filtre ou pas) qui permettra de dire si on va ajouter le filtre ou pas. Le cas courant est de mettre la valeur d’un paramètre de l’URL, et s’il est présent et rempli, on ajoute le filtre.

La comparaison est optionnelle, et vaut "=" par défaut.

Le champ de valeur peut être une liste de plusieurs valeurs,
et dans ce cas le test sera un "OU" sur chacune des comparaisons !

**Exemples**

```
// Les documents publiés par défaut, sinon ceux du statut demandé
{filtermono #ENV{statut,publie}, properties.statut, #ENV{statut,publie}}
// Les documents de 2014 ou 2013
{filtermono #ENV{annee}, year(date), #LISTE{2014,2013}}
// Les documents ayant au moins #ENV{favs} partages
{filtermono #ENV{favs}, length(properties.share), #ENV{favs}, '>='}
```



### Filtre pour un champ JSON ayant plusieurs valeurs (multi-valué)

* @syntaxe `{filtermultijson test, champ, valeur(s)}`

Mêmes principes que pour le critère précédent sauf que le critère cherche si les valeurs font partie du tableau "champ" (qui doit donc être une liste de plusieurs valeurs).

Si on donne plusieurs valeurs, le critère fera un "ET" entre les tests. Si l’une de ces valeurs est elle-même un tableau, le critère fera un "OU" (avec la commande Sphinx IN).

- Si les valeurs sont `#LISTE{mot1, mot2, mot3}` : ça cherchera les documents qui ont mot1 ET mot2 ET mot3.
- Si les valeurs sont `#LISTE{mot1, #LISTE{mot2, mot3}}` : ça cherchera les documents qui ont mot1 ET (mot2 OU mot3).

**Exemples**

```
// Un auteur précis parmi ceux du document
{filtermultijson #ENV{auteur}, properties.authors, #ENV{auteur}}
// Les documents ayant tous les tags demandés, par ex si tags[]=truc&tags[]=bidule
{filtermultijson #ENV{tags}, properties.tags, #ENV{tags}}
```



### Filtre de distance

* @syntaxe `{filterdistance test, point1, point2, distance[, comparaison[, nom du champ]]}`

Ce critère sélectionne uniquement les réponses qui font que la distance entre le point 1 et le point 2 correspond à la comparaison demandée avec la distance passée en paramètre.

La comparaison est optionnelle est vaut "<=" par défaut.
Le nom de la distance calculée est optionnelle et vaudra par défaut "distance_0" pour la première distance demandée, puis "distance_1", etc.

Ce paramètre permet de maîtriser le nom afin de pouvoir plus facilement
demander un tri par le nom voulu, et récupérer la valeur avec une balise.

**Exemple**

```
// Tous les documents qui sont à moins de 5km de Bordeaux, avec comme nom #DISTANCE
#SET{bordeaux, #ARRAY{lat, 44.83717, lon, -0.57403}}
#SET{point_document, #ARRAY{lat, properties.geo.lat, lon, properties.geo.lon}}
{filterdistance , testok, #GET{bordeaux}, #GET{point_document}, 5000, '<=', distance}
```



OPTIONS
-------

Options pour les requêtes à Sphinx

@syntaxe `{option nom, valeur}`

** Exemple **

```
{option field_weights, "(title=10, content=5)"}
```


AFFICHAGE
---------


On peut afficher les messages de SPhinx avec la balise `#SPHINX_MESSAGE`.

Pour les suggestions, la balise `#SPHINX_SUGGESTIONS` est un tableau de liens de recherches en modifiant un des mots.

Exemple:
`[SUGGESTIONS : (#SPHINX_SUGGESTIONS|print)]`

Ne pas oublier de l'appliquer en cas d'échec de la boucle comme de succès (dans `</B>` et `<//B>`).

