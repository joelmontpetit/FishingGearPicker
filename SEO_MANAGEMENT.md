# 🔍 Système de Gestion SEO - FishingGearPicker

## Vue d'ensemble

Le système de gestion SEO vous permet de **personnaliser les meta tags** (titre, description, Open Graph, Twitter Card) pour toutes les pages du site via l'interface Filament.

---

## 📍 Accéder à la gestion SEO

1. Connectez-vous à l'admin Filament : `http://localhost:8080/admin`
2. Cherchez **"SEO Management"** dans le menu de navigation
3. Cliquez pour accéder à la liste des SEO Metas

---

## 🎯 Types de pages gérables

Le système permet de gérer le SEO pour :

### Pages statiques
- **Home Page** (`home`)
- **Techniques Index** (`techniques-index`)
- **Species Index** (`species-index`)

### Pages dynamiques (par entité)
- **Technique Detail** - SEO spécifique pour chaque technique
- **Species Detail** - SEO spécifique pour chaque espèce
- **Build Detail** - SEO spécifique pour chaque build
- **Product Detail** - SEO spécifique pour chaque produit
- **Product Type** - SEO spécifique pour chaque type de produit

---

## ✏️ Créer un nouveau SEO Meta

### Pour une page statique (Home, Index)

1. Cliquez sur **"Create"**
2. Sélectionnez le **Page Type** (ex: `Home Page`)
3. Le **Slug** sera automatiquement généré
4. Remplissez les champs :

#### **Meta Tags** (obligatoires pour le référencement)
- **Meta Title** (50-60 caractères recommandés)
  - Exemple : `FishingGearPicker - Complete Fishing Gear Recommendations`
- **Meta Description** (150-160 caractères recommandés)
  - Exemple : `Find the perfect fishing gear setup for your technique and target species...`
- **Meta Keywords** (séparés par des virgules)
  - Exemple : `fishing gear, bass fishing, carolina rig`

#### **Open Graph / Social Media** (pour Facebook, LinkedIn, etc.)
- **OG Title** (laissez vide pour utiliser le Meta Title)
- **OG Description** (laissez vide pour utiliser la Meta Description)
- **OG Image URL** (URL complète de l'image pour le partage social)
- **Twitter Card Type** (`summary` ou `summary_large_image`)

5. Activez le toggle **"Active"**
6. Cliquez sur **"Create"**

---

### Pour une page dynamique (Build, Technique, Species)

1. Cliquez sur **"Create"**
2. Sélectionnez le **Page Type** (ex: `Build Detail`)
3. Dans **"Select Entity"**, choisissez l'entité spécifique
   - Par exemple : `Carolina Rig Setup for Largemouth Bass`
4. Remplissez les Meta Tags et Open Graph comme ci-dessus
5. Cliquez sur **"Create"**

---

## 📊 Champs disponibles

| Champ | Description | Optionnel |
|-------|-------------|-----------|
| **Page Type** | Type de page (home, technique, build, etc.) | ❌ Obligatoire |
| **Slug** | Identifiant unique (auto pour pages statiques) | ✅ Auto |
| **Entity ID** | Sélection de l'entité spécifique | ✅ Si dynamique |
| **Meta Title** | Titre SEO (visible dans Google) | ✅ |
| **Meta Description** | Description SEO | ✅ |
| **Meta Keywords** | Mots-clés (séparés par virgules) | ✅ |
| **OG Title** | Titre pour partage social | ✅ |
| **OG Description** | Description pour partage social | ✅ |
| **OG Image** | Image pour partage social (URL) | ✅ |
| **Twitter Card** | Type de carte Twitter | ✅ (défaut: `summary_large_image`) |
| **Active** | Activer/désactiver ce SEO | ❌ Obligatoire |

---

## 🔄 Fonctionnement automatique

### Valeurs par défaut intelligentes

Si vous ne créez pas de SEO Meta personnalisé, le système génère automatiquement des valeurs par défaut basées sur :
- Le nom de l'entité (Technique, Species, Build, Product)
- Sa description
- Son type
- Ses relations (ex: technique + species pour un build)

**Exemple pour un Build sans SEO personnalisé :**
```
Title: "Carolina Rig Setup for Largemouth Bass - Beginner | FishingGearPicker"
Description: "A beginner-friendly Carolina Rig setup perfect for..."
```

### Injection automatique dans toutes les pages

Le système injecte automatiquement les SEO metas dans le `<head>` de toutes les pages frontend :
- `home`
- `techniques.index` et `techniques.show`
- `species.index` et `species.show`
- `builds.show`
- `products.show`

---

## 🎯 Bonnes pratiques SEO

### Meta Title
- **Longueur optimale** : 50-60 caractères
- **Format recommandé** : `Titre Principal | FishingGearPicker`
- Incluez le mot-clé principal au début
- Soyez descriptif et attractif

**Exemples :**
```
✅ Carolina Rig Fishing - Complete Gear Guide | FishingGearPicker
✅ Ned Rig Setup for Walleye - Finesse Build | FishingGearPicker
❌ FishingGearPicker - Page (trop vague)
```

### Meta Description
- **Longueur optimale** : 150-160 caractères
- Incluez un appel à l'action
- Résumez le contenu de la page
- Incluez les mots-clés importants naturellement

**Exemples :**
```
✅ Discover the best fishing gear for Walleye. Finesse setups including Ned Rig, jigging rods, and specialized equipment for low-light conditions.
❌ Page about fishing. (trop court et vague)
```

### Meta Keywords
- 5-10 mots-clés pertinents maximum
- Séparez-les par des virgules
- Incluez des variations et synonymes
- Privilégiez les mots-clés de longue traîne

**Exemples :**
```
✅ carolina rig, carolina rig setup, bass fishing, fishing gear, carolina rig rod
❌ fishing, fish, gear (trop génériques)
```

### Open Graph Image
- **Dimensions recommandées** : 1200x630 pixels
- Format : JPG ou PNG
- Poids : < 1 MB
- URL complète (ex: `https://votresite.com/images/carolina-rig.jpg`)

---

## 🔍 Tableau de bord SEO

Dans la liste des SEO Metas, vous verrez :

| Colonne | Description |
|---------|-------------|
| **Page Type** | Type de page (badge coloré) |
| **Slug/Entity** | Slug pour pages statiques, nom de l'entité pour dynamiques |
| **Meta Title** | Titre SEO (tronqué à 50 caractères) |
| **Active** | Statut actif/inactif (icône) |
| **Updated** | Date de dernière modification |

### Filtres disponibles
- **Page Type** : Filtrer par type de page
- **Active** : Filtrer par statut actif/inactif

---

## 🚀 Vérifier les meta tags

### Dans le navigateur
1. Visitez une page du site (ex: `http://localhost:8080`)
2. Faites un clic droit → **"Afficher le code source de la page"**
3. Cherchez les balises dans le `<head>` :

```html
<title>FishingGearPicker - Complete Fishing Gear Recommendations</title>
<meta name="description" content="Find the perfect fishing gear setup...">
<meta property="og:title" content="FishingGearPicker">
<meta property="og:description" content="Complete fishing gear recommendations">
```

### Avec des outils SEO
- **Google Search Console** - Vérifier l'indexation
- **Meta Tags Debugger** - https://metatags.io/
- **Facebook Debugger** - https://developers.facebook.com/tools/debug/
- **Twitter Card Validator** - https://cards-dev.twitter.com/validator

---

## 📝 Exemples de SEO Metas créés

Lors du seeding initial, les SEO Metas suivants ont été créés :

### Pages statiques
1. **Home Page**
   - Title: `FishingGearPicker - Complete Fishing Gear Recommendations`
   - Keywords: `fishing gear, fishing equipment, bass fishing, carolina rig`

2. **Techniques Index**
   - Title: `All Fishing Techniques - Complete Gear Guides`

3. **Species Index**
   - Title: `All Fish Species - Targeted Gear Recommendations`

### Pages dynamiques
4. **Carolina Rig Technique**
   - Title: `Carolina Rig Fishing - Complete Gear Guide & Builds`
   - Keywords: `carolina rig, carolina rig setup, bass fishing`

5. **Ned Rig Technique**
   - Title: `Ned Rig Fishing - Finesse Technique Guide & Gear`

6. **Largemouth Bass Species**
   - Title: `Largemouth Bass Fishing Gear - Complete Builds & Equipment`

7. **Walleye Species**
   - Title: `Walleye Fishing Gear - Complete Builds & Equipment`

8. **Carolina Rig Build**
   - Title: `Carolina Rig Setup for Largemouth Bass - Beginner Build`

9. **Ned Rig Build**
   - Title: `Ned Rig Setup for Walleye - Finesse Build`

---

## 🔧 Éditer un SEO Meta existant

1. Dans la liste des SEO Metas, cliquez sur l'icône **Edit** (crayon)
2. Modifiez les champs souhaités
3. Cliquez sur **"Save"**
4. Les changements sont **immédiatement appliqués** sur le site

---

## ❌ Désactiver un SEO Meta

Si vous voulez temporairement désactiver un SEO personnalisé :

1. Éditez le SEO Meta
2. Désactivez le toggle **"Active"**
3. Sauvegardez

→ Le système utilisera alors les **valeurs par défaut automatiques**

---

## 🗑️ Supprimer un SEO Meta

1. Cliquez sur l'icône **Delete** (poubelle)
2. Confirmez la suppression
3. Les valeurs par défaut seront utilisées à la place

---

## ⚠️ Notes importantes

1. **Un seul SEO Meta par entité** : Vous ne pouvez pas créer plusieurs SEO Metas pour la même page/entité
2. **Unicité** : La combinaison `page_type` + `slug` ou `page_type` + `entity_id` est unique
3. **Priorité** : SEO personnalisé > Valeurs par défaut automatiques
4. **Cache** : Les changements sont immédiats, pas de cache à vider

---

## 📚 Structure de la base de données

Table : `seo_metas`

```
id                 (bigint)
page_type          (string)   - Type de page
entity_id          (bigint)   - ID de l'entité (nullable)
slug               (string)   - Slug pour pages statiques (nullable)
meta_title         (string)   - Titre SEO
meta_description   (text)     - Description SEO
meta_keywords      (text)     - Mots-clés
og_title           (string)   - Titre Open Graph
og_description     (text)     - Description Open Graph
og_image           (string)   - Image URL
twitter_card       (string)   - Type de carte Twitter
is_active          (boolean)  - Statut actif
created_at         (timestamp)
updated_at         (timestamp)
```

---

## 🎓 Ressources supplémentaires

- [Google SEO Starter Guide](https://developers.google.com/search/docs/beginner/seo-starter-guide)
- [Open Graph Protocol](https://ogp.me/)
- [Twitter Cards Documentation](https://developer.twitter.com/en/docs/twitter-for-websites/cards/overview/abouts-cards)

---

**Votre système SEO est maintenant prêt ! 🎣**

Pour toute question, consultez ce guide ou créez une issue sur le projet.

