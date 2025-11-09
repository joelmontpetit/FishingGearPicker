# 🎯 Guide des Boutons - Style Sobre Garmin

## Philosophie

Les boutons suivent le style **sobre, professionnel et minimaliste** de Garmin :
- Pas de couleurs vives
- Noir, blanc et gris uniquement
- Borders nettes et clean
- Transitions subtiles

---

## 🔘 Types de Boutons

### 1. **Bouton Primary** (Action principale)
Style : Fond noir, texte blanc

```html
<a href="#" class="btn btn-primary">Primary Action</a>
```

**Utilisation** :
- Action principale sur une page
- Call-to-action important
- Exemple : "Browse Techniques", "View Details"

---

### 2. **Bouton Outline** (Action secondaire)
Style : Fond transparent, border noir

```html
<a href="#" class="btn btn-outline">Secondary Action</a>
```

**Utilisation** :
- Action secondaire
- "View All", "Learn More"
- Boutons en bas de section

---

### 3. **Bouton Minimal** (Style Garmin)
Style : Border gris léger, très sobre

```html
<a href="#" class="btn btn-minimal">Minimal Button</a>
```

**Utilisation** :
- Actions très discrètes
- Liens d'affiliation
- "Buy at Store"

---

### 4. **Bouton Link** (Texte simple)
Style : Texte avec soulignement

```html
<a href="#" class="btn btn-link">Text Link</a>
```

**Utilisation** :
- Liens dans le texte
- "← Browse Other Species"
- Navigation discrète

---

### 5. **Bouton Secondary** (Fond blanc)
Style : Fond blanc, border gris

```html
<a href="#" class="btn btn-secondary">White Button</a>
```

**Utilisation** :
- Sur fond coloré/foncé
- Alternative au outline

---

## 📐 Tailles

### Standard (par défaut)
```html
<a href="#" class="btn btn-primary">Standard Size</a>
```

### Personnalisé
```html
<a href="#" class="btn btn-primary" style="padding: var(--spacing-sm) var(--spacing-lg); font-size: var(--text-sm);">
    Small Button
</a>

<a href="#" class="btn btn-primary" style="padding: var(--spacing-lg) var(--spacing-2xl); font-size: var(--text-lg);">
    Large Button
</a>
```

---

## 🎨 Exemples d'Utilisation

### Page d'accueil (Hero)
```html
<a href="{{ route('techniques.index') }}" class="btn btn-primary">
    Browse Techniques
</a>
```

### Fin de section
```html
<a href="{{ route('techniques.index') }}" class="btn btn-outline">
    View All Techniques
</a>
```

### Liens d'affiliation
```html
<a href="{{ $link->affiliate_url }}" class="btn btn-minimal">
    Buy at {{ $link->store->name }}
</a>
```

### Navigation discrète
```html
<a href="{{ route('species.index') }}" class="btn btn-link">
    ← Browse Other Species
</a>
```

---

## 🎯 Recommandations Garmin-Style

### ✅ À FAIRE
- Utiliser `.btn-primary` pour 1 seul CTA par page
- Utiliser `.btn-outline` pour actions secondaires
- Utiliser `.btn-minimal` pour liens d'affiliation
- Garder les boutons alignés horizontalement
- Espacer avec `gap: var(--spacing-sm)`

### ❌ À ÉVITER
- Trop de boutons primary sur une page
- Mélanger trop de styles différents
- Utiliser des couleurs vives
- Surcharger de boutons

---

## 💡 Exemples de Layout

### Boutons côte à côte
```html
<div style="display: flex; gap: var(--spacing-sm); flex-wrap: wrap;">
    <a href="#" class="btn btn-primary">Primary</a>
    <a href="#" class="btn btn-outline">Secondary</a>
</div>
```

### Boutons empilés (mobile-friendly)
```html
<div style="display: flex; flex-direction: column; gap: var(--spacing-sm);">
    <a href="#" class="btn btn-primary">Buy at Amazon</a>
    <a href="#" class="btn btn-minimal">Buy at Bass Pro Shops</a>
    <a href="#" class="btn btn-minimal">Buy at Cabela's</a>
</div>
```

### Bouton pleine largeur
```html
<a href="#" class="btn btn-primary" style="width: 100%;">
    Full Width Button
</a>
```

---

## 🔧 Personnalisation

### Changer la couleur des boutons primary
```css
/* Dans resources/css/app.css */
.btn-primary {
    background-color: var(--color-neutral-700); /* Plus gris */
    border-color: var(--color-neutral-700);
}
```

### Ajuster le border radius
```css
/* Dans resources/css/app.css */
.btn {
    border-radius: 0; /* Coins carrés comme Garmin */
}
```

### Supprimer l'effet hover de translation
```css
/* Dans resources/css/app.css */
.btn:hover {
    transform: none; /* Pas de mouvement */
}
```

---

## 📱 Responsive

Les boutons s'adaptent automatiquement sur mobile :
- Sur mobile : pleine largeur si dans un flex-column
- Sur desktop : largeur auto

---

## ✅ Checklist

Quand vous ajoutez un bouton :
- [ ] Utiliser la classe `.btn` de base
- [ ] Ajouter le modificateur approprié (`.btn-primary`, `.btn-outline`, etc.)
- [ ] Vérifier le contraste texte/background
- [ ] Tester sur mobile
- [ ] Vérifier qu'il n'y a pas trop de boutons primary sur la page

---

**Style actuel** : Sobre, professionnel, monochrome (noir/blanc/gris)  
**Inspiration** : Garmin.com  
**Dernière mise à jour** : Novembre 2025

