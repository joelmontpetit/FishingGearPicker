# 🎣 FishingGearPicker - Documentation Complète du Projet

## Table des matières
1. [Vue d'ensemble](#vue-densemble)
2. [Proposition de valeur](#proposition-de-valeur)
3. [Fonctionnalités actuelles](#fonctionnalités-actuelles)
4. [Structure des pages](#structure-des-pages)
5. [Modèle de données](#modèle-de-données)
6. [Système de monétisation](#système-de-monétisation)
7. [SEO actuel](#seo-actuel)
8. [Fonctionnalités utilisateur](#fonctionnalités-utilisateur)
9. [Stack technique](#stack-technique)
10. [Roadmap et opportunités](#roadmap-et-opportunités)

---

## Vue d'ensemble

### Qu'est-ce que FishingGearPicker ?

**FishingGearPicker** est une plateforme web de recommandation d'équipement de pêche, inspirée du concept de PCPartPicker. Le site propose des configurations complètes ("builds") d'équipement de pêche, organisées par technique de pêche, espèce ciblée et niveau de budget.

### Mission

Aider les pêcheurs de tous niveaux à trouver l'équipement idéal pour leur style de pêche, en proposant des configurations complètes et cohérentes, validées par des experts.

### Public cible

| Segment | Description | Besoins |
|---------|-------------|---------|
| **Débutants** | Nouveaux pêcheurs sans expérience | Configurations complètes, conseils, budget accessible |
| **Intermédiaires** | Pêcheurs occasionnels voulant s'améliorer | Upgrades ciblés, nouvelles techniques |
| **Experts** | Pêcheurs passionnés/compétiteurs | Équipement premium, spécialisations pointues |

---

## Proposition de valeur

### Problème résolu

1. **Complexité du choix** : Des centaines de produits sur le marché, difficile de savoir quoi acheter
2. **Compatibilité** : Tous les équipements ne fonctionnent pas bien ensemble
3. **Dispersion de l'information** : Informations éparpillées sur forums, YouTube, etc.
4. **Budget** : Difficile d'estimer le coût total d'un setup complet

### Solution FishingGearPicker

| Avantage | Description |
|----------|-------------|
| **Configurations complètes** | Tous les éléments nécessaires en un seul endroit |
| **Compatibilité garantie** | Chaque build est cohérent et fonctionnel |
| **Choix par niveau** | Options Budget, Mid-Range, Premium pour chaque rôle |
| **Prix transparent** | Total calculé automatiquement |
| **Liens d'achat directs** | Redirection vers les meilleurs détaillants |

---

## Fonctionnalités actuelles

### 🏠 Fonctionnalités publiques

| Fonctionnalité | Description | Statut |
|----------------|-------------|--------|
| Navigation par espèce | Parcourir les builds par espèce de poisson ciblée | ✅ Actif |
| Navigation par technique | Parcourir les builds par technique de pêche | ✅ Actif |
| Détail des builds | Vue complète d'une configuration avec tous les produits | ✅ Actif |
| Carrousel de produits | Plusieurs options par rôle (canne, moulinet, etc.) | ✅ Actif |
| Filtrage par tier de prix | Budget / Mid-Range / Premium | ✅ Actif |
| Détail des produits | Page individuelle pour chaque produit | ✅ Actif |
| Liens affiliés | Redirection vers Amazon, Bass Pro Shops, etc. | ✅ Actif |
| Design responsive | Mobile-first, adapté à tous les écrans | ✅ Actif |

### 👤 Fonctionnalités utilisateur (authentifié)

| Fonctionnalité | Description | Statut |
|----------------|-------------|--------|
| Inscription/Connexion | Email + mot de passe | ✅ Actif |
| Authentification sociale | Google, Facebook | ✅ Actif |
| Profil utilisateur | Gestion du compte | ✅ Actif |
| Sauvegarder un build | Créer sa propre configuration | ✅ Actif |
| Mes builds | Liste des builds sauvegardés | ✅ Actif |
| Partage de build | Lien public pour partager | ✅ Actif |

### 🔧 Administration (Filament)

| Fonctionnalité | Description | Statut |
|----------------|-------------|--------|
| Gestion des techniques | CRUD complet | ✅ Actif |
| Gestion des espèces | CRUD complet | ✅ Actif |
| Gestion des produits | CRUD avec spécifications | ✅ Actif |
| Gestion des builds | Configuration des options multiples | ✅ Actif |
| Gestion des liens affiliés | Par produit et par magasin | ✅ Actif |
| Gestion SEO | Meta tags personnalisés par page | ✅ Actif |

---

## Structure des pages

### Pages publiques

```
/                           → Page d'accueil
├── Featured builds (6 max)
├── Techniques populaires
└── Espèces populaires

/species                    → Liste des espèces
├── Largemouth Bass
├── Smallmouth Bass
├── Walleye
└── ...

/species/{slug}             → Détail d'une espèce
├── Description de l'espèce
└── Builds recommandés pour cette espèce

/techniques                 → Liste des techniques
├── Carolina Rig
├── Drop Shot
├── Texas Rig
├── Ned Rig
└── ...

/techniques/{slug}          → Détail d'une technique
├── Description de la technique
└── Builds utilisant cette technique

/builds/{slug}              → Détail d'un build
├── Header (technique, espèce, budget tier)
├── Description
├── Liste des produits par rôle
│   ├── Carrousel d'options (Budget/Mid/Premium)
│   ├── Bouton "Add to Build"
│   └── Liens affiliés
├── Sidebar "Your Build" (panier)
└── Modal de sauvegarde

/products/{slug}            → Détail d'un produit
├── Informations produit
├── Spécifications
├── Liens d'achat
└── Builds utilisant ce produit
```

### Pages utilisateur (authentifié)

```
/dashboard                  → Tableau de bord
/profile                    → Édition du profil
/profile/builds             → Mes builds sauvegardés
/profile/builds/{slug}      → Détail d'un build sauvegardé
```

### Pages d'authentification

```
/login                      → Connexion
/register                   → Inscription
/forgot-password            → Mot de passe oublié
/auth/google/redirect       → OAuth Google
/auth/facebook/redirect     → OAuth Facebook
```

### Administration

```
/admin                      → Tableau de bord Filament
/admin/techniques           → Gestion des techniques
/admin/species              → Gestion des espèces
/admin/products             → Gestion des produits
/admin/builds               → Gestion des builds
/admin/stores               → Gestion des magasins
/admin/affiliate-links      → Gestion des liens affiliés
/admin/seo-metas            → Gestion SEO
/admin/users                → Gestion des utilisateurs
```

---

## Modèle de données

### Entités principales

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│  Technique  │     │   Species   │     │   Build     │
├─────────────┤     ├─────────────┤     ├─────────────┤
│ name        │     │ name        │     │ name        │
│ slug        │     │ slug        │     │ slug        │
│ description │     │ description │     │ description │
│ is_active   │     │ scientific  │     │ budget_tier │
│             │     │ habitat     │     │ total_price │
│             │     │             │     │ is_featured │
└──────┬──────┘     └──────┬──────┘     │ views_count │
       │                   │            └──────┬──────┘
       │                   │                   │
       └───────────────────┼───────────────────┘
                           │
                    ┌──────┴──────┐
                    │   Build     │
                    │ (belongs to │
                    │  both)      │
                    └──────┬──────┘
                           │
              ┌────────────┴────────────┐
              │                         │
    ┌─────────┴─────────┐    ┌─────────┴─────────┐
    │ BuildProductOption│    │     Product       │
    ├───────────────────┤    ├───────────────────┤
    │ role              │    │ name              │
    │ sort_order        │    │ slug              │
    │ is_recommended    │    │ brand             │
    │ price_tier        │    │ model             │
    │ notes             │    │ price             │
    └─────────┬─────────┘    │ specifications    │
              │              └─────────┬─────────┘
              │                        │
              └────────────────────────┤
                                       │
                            ┌──────────┴──────────┐
                            │   AffiliateLink     │
                            ├─────────────────────┤
                            │ affiliate_url       │
                            │ price               │
                            │ is_active           │
                            └──────────┬──────────┘
                                       │
                            ┌──────────┴──────────┐
                            │      Store          │
                            ├─────────────────────┤
                            │ name (Amazon, etc.) │
                            │ website_url         │
                            │ logo_url            │
                            └─────────────────────┘
```

### Builds utilisateur

```
┌─────────────────┐     ┌─────────────────────────┐
│      User       │     │     UserSavedBuild      │
├─────────────────┤     ├─────────────────────────┤
│ name            │────→│ name                    │
│ email           │     │ slug                    │
│ avatar          │     │ notes                   │
│                 │     │ is_public               │
│                 │     │ total_price             │
└─────────────────┘     └───────────┬─────────────┘
                                    │
                        ┌───────────┴─────────────┐
                        │ UserSavedBuildProduct   │
                        ├─────────────────────────┤
                        │ product_id              │
                        │ role                    │
                        │ quantity                │
                        │ notes                   │
                        └─────────────────────────┘
```

### Rôles des produits dans un build

| Rôle | Description | Exemples |
|------|-------------|----------|
| `rod` | Canne à pêche | Spinning rod, Casting rod |
| `reel` | Moulinet | Spinning reel, Baitcasting reel |
| `line` | Ligne principale | Braided line, Fluorocarbon |
| `leader` | Bas de ligne | Fluorocarbon leader |
| `lure` | Leurre | Soft plastics, Crankbaits |
| `hook` | Hameçon | EWG hooks, Offset hooks |
| `weight` | Plomb/Poids | Tungsten weights, Lead sinkers |
| `accessory` | Accessoires | Swivels, Snaps, Pliers |

---

## Système de monétisation

### Modèle économique : Affiliation

Le site génère des revenus via les liens d'affiliation vers les détaillants partenaires.

### Magasins intégrés

| Magasin | Programme | Commission typique |
|---------|-----------|-------------------|
| Amazon | Amazon Associates | 1-10% selon catégorie |
| Bass Pro Shops | Affiliate Program | 3-5% |
| Cabela's | Affiliate Program | 3-5% |
| Tackle Warehouse | Affiliate Program | 5-8% |

### Flux de monétisation

```
Utilisateur visite build
        ↓
Parcourt les options produits
        ↓
Clique sur "Buy at Amazon" (lien affilié)
        ↓
Redirigé vers Amazon avec tracking
        ↓
Achat effectué → Commission versée
```

### Optimisation potentielle

- Tracking des clics par produit/magasin
- A/B testing des placements de liens
- Comparaison de prix en temps réel
- Notifications de baisse de prix

---

## SEO actuel

### Fonctionnalités SEO implémentées

| Fonctionnalité | Statut | Description |
|----------------|--------|-------------|
| Slugs automatiques | ✅ | URLs lisibles pour toutes les entités |
| Meta Title | ✅ | Personnalisable par page |
| Meta Description | ✅ | Personnalisable par page |
| Meta Keywords | ✅ | Personnalisable par page |
| Open Graph | ✅ | Partage social optimisé |
| Twitter Cards | ✅ | Aperçu Twitter optimisé |
| Breadcrumbs | ✅ | Navigation hiérarchique |
| HTML sémantique | ✅ | Structure accessible |
| Mobile-first | ✅ | Design responsive |
| URLs propres | ✅ | /techniques/carolina-rig |

### Gestion SEO via admin

Chaque page peut avoir ses propres meta tags via le panneau d'administration :
- Pages statiques (home, index)
- Pages dynamiques (builds, techniques, espèces, produits)

### SEO à implémenter

| Fonctionnalité | Priorité | Impact |
|----------------|----------|--------|
| Sitemap XML | 🔴 Haute | Indexation |
| Schema.org (JSON-LD) | 🔴 Haute | Rich snippets |
| Canonical URLs | 🟡 Moyenne | Duplicate content |
| Lazy loading images | 🟡 Moyenne | Core Web Vitals |
| Image alt optimisés | 🟡 Moyenne | Image SEO |
| Blog/Articles | 🔴 Haute | Trafic organique |
| FAQ Schema | 🟡 Moyenne | Rich snippets |

---

## Fonctionnalités utilisateur

### Parcours utilisateur type

```
1. DÉCOUVERTE
   └── Arrive sur la home page
       └── Voit les builds featured et techniques

2. EXPLORATION
   └── Clique sur une technique (ex: Carolina Rig)
       └── Découvre les builds pour cette technique
           └── Filtre par espèce ou budget

3. SÉLECTION
   └── Ouvre un build qui l'intéresse
       └── Parcourt les options produits (carrousel)
           └── Compare Budget vs Mid vs Premium

4. PERSONNALISATION
   └── Clique "Add to Build" sur ses choix
       └── Voit le total se mettre à jour
           └── Ajuste sa sélection

5. SAUVEGARDE (si connecté)
   └── Clique "Save Build"
       └── Nomme sa configuration
           └── Retrouve dans "My Builds"

6. ACHAT
   └── Clique sur les liens affiliés
       └── Redirigé vers Amazon/Bass Pro/etc.
           └── Effectue son achat
```

### Fonctionnalités de personnalisation

| Fonctionnalité | Description |
|----------------|-------------|
| Carrousel produits | Swipe/flèches pour voir les alternatives |
| Filtrage par tier | Voir seulement Budget, Mid, ou Premium |
| Panier "Your Build" | Sidebar avec les produits sélectionnés |
| Total dynamique | Prix mis à jour en temps réel |
| Sauvegarde locale | Persistance via localStorage |
| Sauvegarde cloud | Compte utilisateur requis |

---

## Stack technique

### Backend

| Technologie | Version | Usage |
|-------------|---------|-------|
| PHP | 8.2+ | Langage serveur |
| Laravel | 11.x | Framework PHP |
| Filament | 4.x | Admin panel |
| SQLite | 3.x | Base de données (dev) |
| Eloquent ORM | - | Accès données |

### Frontend

| Technologie | Version | Usage |
|-------------|---------|-------|
| Blade | - | Templates |
| Tailwind CSS | 3.x | Styles |
| Alpine.js | 3.x | Interactivité |
| Vite | 5.x | Build tool |

### Design

| Aspect | Choix |
|--------|-------|
| Style | Monochrome (noir/blanc/gris) |
| Typographie | Inter (Google Fonts) |
| Responsive | Mobile-first |
| Composants | Cards, Badges, Buttons |

---

## Roadmap et opportunités

### Phase 1 : Pré-lancement (Actuel) ✅

- [x] Core features fonctionnelles
- [x] Admin panel opérationnel
- [x] SEO de base
- [x] Authentification
- [x] Builds sauvegardables

### Phase 2 : Lancement MVP

| Tâche | Priorité | Effort |
|-------|----------|--------|
| Sitemap XML | 🔴 Critique | 2h |
| Schema.org | 🔴 Critique | 4h |
| Contenu initial (10+ builds) | 🔴 Critique | 8h |
| Textes SEO optimisés | 🔴 Critique | 6h |
| Google Search Console | 🔴 Critique | 1h |
| Google Analytics | 🔴 Critique | 1h |

### Phase 3 : Croissance

| Fonctionnalité | Impact | Effort |
|----------------|--------|--------|
| Blog/Articles | Trafic SEO | Élevé |
| Comparateur de produits | Conversion | Moyen |
| Reviews/Ratings | UGC + SEO | Moyen |
| Newsletter | Rétention | Faible |
| Notifications prix | Engagement | Moyen |

### Phase 4 : Monétisation avancée

| Fonctionnalité | Impact | Effort |
|----------------|--------|--------|
| Tracking clics affiliés | Analytics | Moyen |
| Comparaison prix temps réel | Conversion | Élevé |
| Partenariats marques | Revenus | Variable |
| Contenu sponsorisé | Revenus | Faible |

### Phase 5 : Expansion

| Fonctionnalité | Impact | Effort |
|----------------|--------|--------|
| API publique | Écosystème | Élevé |
| App mobile | Reach | Très élevé |
| Communauté/Forum | Engagement | Élevé |
| Marketplace | Revenus | Très élevé |

---

## Données de test actuelles

### Techniques disponibles

1. **Carolina Rig** - Technique de pêche au fond
2. **Drop Shot** - Finesse technique
3. **Texas Rig** - Technique polyvalente
4. **Ned Rig** - Finesse extreme

### Espèces disponibles

1. **Largemouth Bass** - Micropterus salmoides
2. **Smallmouth Bass** - Micropterus dolomieu
3. **Walleye** - Sander vitreus

### Builds exemple

1. **Carolina Rig for Largemouth Bass - Beginner** ($196.69)
   - Ugly Stik GX2 Rod
   - PENN Battle III Reel
   - PowerPro Braided Line
   - Seaguar Fluorocarbon Leader
   - Tungsten Carolina Weight
   - Gamakatsu EWG Hook
   - Zoom Super Fluke
   - SPRO Power Swivels

2. **Ned Rig for Walleye - Finesse** (Prix variable)
   - Options multiples par rôle
   - Tiers Budget/Mid/Premium

### Magasins partenaires

1. Amazon
2. Bass Pro Shops
3. Cabela's
4. Tackle Warehouse

---

## Points forts du projet

| Force | Description |
|-------|-------------|
| **Concept validé** | PCPartPicker a prouvé le modèle |
| **Niche claire** | Marché pêche = passionnés qui dépensent |
| **SEO-ready** | Architecture optimisée pour le référencement |
| **Monétisation intégrée** | Affiliation prête à l'emploi |
| **Scalable** | Ajout facile de contenu via admin |
| **Mobile-first** | Adapté aux usages modernes |

## Points à améliorer

| Faiblesse | Solution |
|-----------|----------|
| Peu de contenu | Créer 20+ builds avant lancement |
| Pas de blog | Ajouter section articles/guides |
| Pas de communauté | Prévoir reviews/commentaires |
| Pas d'analytics | Intégrer GA4 + tracking affiliés |
| Images placeholder | Ajouter vraies photos produits |

---

## Conclusion

FishingGearPicker est une plateforme fonctionnelle et prête pour un lancement MVP. Les fondations techniques sont solides (Laravel 11, Filament 4, SEO de base). 

**Prochaines étapes recommandées :**

1. **Contenu** : Créer 10-20 builds complets avec de vrais produits
2. **SEO technique** : Sitemap, Schema.org, optimisation des textes
3. **Analytics** : Google Analytics + Search Console
4. **Lancement soft** : Tester avec un petit groupe
5. **Itération** : Améliorer selon les retours

---

*Document généré le 27 décembre 2025*
*Version 1.0*

