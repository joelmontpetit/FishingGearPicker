# 🎣 FishingGearPicker - Référence Rapide

## 🚀 Démarrage Express

### Démarrer le Serveur
```bash
php artisan serve --port=8080
```

### Ouvrir l'Application
```
http://localhost:8080
```

---

## 🎯 Gestion du Contenu

### Ouvrir Tinker
```bash
php artisan tinker
```

### Créer une Technique
```php
Technique::create(['name' => 'Drop Shot', 'is_active' => true]);
```

### Créer un Produit
```php
Product::create([
    'product_type_id' => 1,
    'name' => 'Shimano Rod',
    'brand' => 'Shimano',
    'price' => 199.99,
    'is_active' => true
]);
```

### Créer un Build
```php
Build::create([
    'technique_id' => 1,
    'species_id' => 1,
    'name' => 'Drop Shot Bass Setup',
    'budget_tier' => 'intermediate',
    'total_price' => 299.99,
    'is_active' => true
]);
```

### Voir Tout
```php
// Builds
Build::with(['technique', 'species', 'products'])->get();

// Techniques
Technique::all();

// Produits
Product::all();

// Build spécifique
Build::with('products')->find(1);
```

---

## 📋 URLs de l'Application

| Page | URL |
|------|-----|
| **Accueil** | http://localhost:8080 |
| **Techniques** | http://localhost:8080/techniques |
| **Build Exemple** | http://localhost:8080/builds/carolina-rig-largemouth-bass-beginner |
| **Admin Login** | http://localhost:8080/admin |

---

## 👤 Compte Admin

**Email :** `admin@fishinggear.com`  
**Password :** `password`

---

## 🗂️ Structure des Données

### IDs des Product Types
- `1` = Rods
- `2` = Reels
- `3` = Lines
- `4` = Leaders
- `5` = Weights
- `6` = Hooks
- `7` = Lures
- `8` = Terminal Tackle

### Budget Tiers
- `beginner` = Débutant
- `intermediate` = Intermédiaire
- `advanced` = Avancé

---

## 🛠️ Commandes Utiles

### Vider le Cache
```bash
php artisan optimize:clear
```

### Recompiler les Assets
```bash
npm run build
```

### Voir les Routes
```bash
php artisan route:list
```

### Voir l'État
```bash
php artisan about
```

---

## 📚 Fichiers de Documentation

| Fichier | Description |
|---------|-------------|
| **ADMIN_SOLUTION.md** | Solution admin et guide Tinker |
| **FILAMENT_ADMIN_SETUP.md** | Exemples Tinker détaillés |
| **SUCCESS.md** | Confirmation du succès |
| **README.md** | Documentation complète |
| **START_SERVER.md** | Solutions de démarrage |

---

## 🎓 Exemples Tinker Avancés

### Ajouter un Produit à un Build
```php
$build = Build::find(1);
$product = Product::find(5);
$build->products()->attach($product->id, [
    'role' => 'Main lure',
    'quantity' => 2,
    'sort_order' => 5
]);
```

### Créer un Lien Affilié
```php
AffiliateLink::create([
    'product_id' => 1,
    'store_id' => 1,
    'affiliate_url' => 'https://amazon.com/...',
    'price' => 49.99,
    'in_stock' => true,
    'is_active' => true
]);
```

### Modifier un Build
```php
$build = Build::find(1);
$build->is_featured = true;
$build->total_price = 199.99;
$build->save();
```

### Supprimer un Produit d'un Build
```php
$build = Build::find(1);
$build->products()->detach(3); // Retire le produit ID 3
```

---

## 💾 Base de Données

**Type :** SQLite  
**Fichier :** `database/database.sqlite`  
**Outils :** DB Browser, TablePlus, DBeaver

---

## 🎨 Personnalisation Rapide

### Changer le Nom de l'App
**Fichier :** `resources/views/layouts/app.blade.php` (ligne 23)

### Modifier les Couleurs
**Fichier :** `tailwind.config.js`

### Ajouter des Images
Placer dans : `public/images/`

---

## ⚡ Raccourcis

### Développement
```bash
# Terminal 1
npm run dev

# Terminal 2
php artisan serve --port=8080
```

### Production
```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🐛 Problèmes Courants

### "Vite manifest not found"
```bash
npm install
npm run build
```

### Page blanche
```bash
php artisan optimize:clear
```

### Erreur 500
Vérifier : `storage/logs/laravel.log`

---

## 📊 Contenu Actuel

- ✅ **1** Build complet
- ✅ **3** Techniques
- ✅ **2** Espèces
- ✅ **8** Produits
- ✅ **2** Stores
- ✅ **16** Liens affiliés

---

## 🎯 Next Steps

1. ✅ Tester l'app web
2. 🔧 Ajouter du contenu via Tinker
3. 🎨 Personnaliser le design
4. 🔗 Configurer vrais liens affiliés
5. 🚀 Préparer le déploiement

---

**🎣 Application 100% fonctionnelle et prête à l'emploi !**

