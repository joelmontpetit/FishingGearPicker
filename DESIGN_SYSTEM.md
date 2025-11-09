# 🎨 Design System - FishingGearPicker

## Inspiration
Design professionnel, sobre et minimaliste inspiré de Garmin.

---

## 📐 Architecture

Toutes les variables de design sont centralisées dans `resources/css/app.css` pour faciliter les modifications.

---

## 🎨 Palette de Couleurs

### Primary (Bleu/Teal)
```css
--color-primary: #00ADB5        /* Couleur principale */
--color-primary-dark: #008B94   /* Hover states */
--color-primary-light: #33BFCA  /* Backgrounds légers */
```

### Neutral (Gris)
```css
--color-neutral-50: #FAFAFA     /* Backgrounds très légers */
--color-neutral-100: #F5F5F5    /* Backgrounds légers */
--color-neutral-200: #E5E5E5    /* Borders */
--color-neutral-300: #D4D4D4
--color-neutral-400: #A3A3A3
--color-neutral-500: #737373
--color-neutral-600: #525252    /* Texte secondaire */
--color-neutral-700: #404040    /* Texte */
--color-neutral-800: #262626    /* Texte principal */
--color-neutral-900: #171717    /* Titres */
```

### Accent Colors
```css
--color-accent-blue: #0066CC
--color-accent-green: #00B67A
--color-accent-orange: #FF6B35
--color-accent-red: #E63946
```

### Semantic Colors
```css
--color-success: #00B67A
--color-warning: #FFB800
--color-error: #E63946
--color-info: #0066CC
```

---

## 📝 Typographie

### Font Family
```css
--font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', system-ui, sans-serif
```

### Font Sizes
```css
--text-xs: 0.75rem      /* 12px */
--text-sm: 0.875rem     /* 14px */
--text-base: 1rem       /* 16px */
--text-lg: 1.125rem     /* 18px */
--text-xl: 1.25rem      /* 20px */
--text-2xl: 1.5rem      /* 24px */
--text-3xl: 1.875rem    /* 30px */
--text-4xl: 2.25rem     /* 36px */
--text-5xl: 3rem        /* 48px */
```

### Font Weights
```css
--font-normal: 400
--font-medium: 500
--font-semibold: 600
--font-bold: 700
```

### Line Heights
```css
--leading-tight: 1.25
--leading-normal: 1.5
--leading-relaxed: 1.75
```

---

## 📏 Spacing

```css
--spacing-xs: 0.5rem    /* 8px */
--spacing-sm: 0.75rem   /* 12px */
--spacing-md: 1rem      /* 16px */
--spacing-lg: 1.5rem    /* 24px */
--spacing-xl: 2rem      /* 32px */
--spacing-2xl: 3rem     /* 48px */
--spacing-3xl: 4rem     /* 64px */
```

---

## 🔲 Borders & Radius

```css
--border-radius-sm: 0.25rem  /* 4px */
--border-radius-md: 0.5rem   /* 8px */
--border-radius-lg: 0.75rem  /* 12px */
--border-radius-xl: 1rem     /* 16px */

--border-width: 1px
--border-color: var(--color-neutral-200)
```

---

## 🌑 Shadows

```css
--shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05)
--shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)
--shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)
--shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)
```

---

## ⚡ Transitions

```css
--transition-fast: 150ms ease-in-out
--transition-base: 200ms ease-in-out
--transition-slow: 300ms ease-in-out
```

---

## 📦 Components

### `.container-custom`
Container centré avec padding responsive.

### `.card`
Card avec border, shadow et hover effect.
```html
<div class="card">
    <div class="card-content">
        <!-- Contenu -->
    </div>
</div>
```

### `.btn`
Boutons avec différents styles.
```html
<a href="#" class="btn btn-primary">Primary Button</a>
<a href="#" class="btn btn-secondary">Secondary Button</a>
<a href="#" class="btn btn-outline">Outline Button</a>
```

### `.badge`
Petit badge pour catégories/tags.
```html
<span class="badge badge-primary">Featured</span>
<span class="badge badge-neutral">Category</span>
<span class="badge badge-success">Success</span>
```

### `.section`
Section avec padding vertical.
```html
<div class="section">
    <div class="container-custom">
        <h2 class="section-title">Section Title</h2>
        <p class="section-subtitle">Subtitle text</p>
        <!-- Contenu -->
    </div>
</div>
```

### `.hero`
Section hero avec gradient background.
```html
<div class="hero">
    <div class="container-custom">
        <h1 class="hero-title">Hero Title</h1>
        <p class="hero-subtitle">Subtitle</p>
    </div>
</div>
```

### `.grid-cards`
Grille responsive pour cards (1 col mobile, 2 tablet, 3 desktop).
```html
<div class="grid-cards">
    <div class="card">...</div>
    <div class="card">...</div>
    <div class="card">...</div>
</div>
```

---

## 🛠️ Utilities

### Text
```html
<p class="text-muted">Texte secondaire</p>
<p class="text-accent">Texte avec couleur primary</p>
<p class="line-clamp-2">Texte tronqué à 2 lignes</p>
<p class="line-clamp-3">Texte tronqué à 3 lignes</p>
```

---

## 🎯 Comment Modifier les Couleurs

Pour changer la palette de couleurs du site entier :

1. Ouvrir `resources/css/app.css`
2. Modifier les variables dans `:root`
3. Compiler les assets : `npm run build`

### Exemple : Changer la couleur principale

```css
:root {
    /* De bleu/teal */
    --color-primary: #00ADB5;
    --color-primary-dark: #008B94;
    
    /* À vert */
    --color-primary: #00B67A;
    --color-primary-dark: #009960;
}
```

---

## 📱 Responsive

Le design est mobile-first. Les breakpoints sont :

- Mobile : < 768px
- Tablet : ≥ 768px
- Desktop : ≥ 1024px

---

## ✅ Checklist de Cohérence

Lors de l'ajout de nouvelles pages :

- [ ] Utiliser `.container-custom` pour le conteneur principal
- [ ] Utiliser les classes `.card` pour les cards
- [ ] Utiliser les variables CSS au lieu de valeurs hardcodées
- [ ] Utiliser `.btn` pour les boutons
- [ ] Utiliser `.badge` pour les tags
- [ ] Utiliser `.section` pour les sections
- [ ] Utiliser `.grid-cards` pour les grilles de cards
- [ ] Tester le responsive (mobile, tablet, desktop)

---

## 🚀 Développement

### Compiler les assets
```bash
npm run build
```

### Mode développement (watch)
```bash
npm run dev
```

---

## 📚 Références

- Police : Inter (Google Fonts)
- Inspiration : Garmin.com
- Framework CSS : Tailwind CSS 3.x (avec custom variables)

---

**Dernière mise à jour** : Novembre 2025

