# Configuration de l'authentification sociale

## 🔧 Configuration requise

### 1. Variables d'environnement

Ajoutez ces lignes à votre fichier `.env` :

```env
# Google OAuth
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# Facebook OAuth
FACEBOOK_CLIENT_ID=your_facebook_app_id
FACEBOOK_CLIENT_SECRET=your_facebook_app_secret
FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/facebook/callback
```

---

## 📱 Obtenir les credentials Google

### 1. Créer un projet Google Cloud

1. Allez sur [Google Cloud Console](https://console.cloud.google.com/)
2. Créez un nouveau projet ou sélectionnez un projet existant
3. Dans le menu de navigation, allez dans **APIs & Services** > **Credentials**

### 2. Configurer l'écran de consentement OAuth

1. Cliquez sur **OAuth consent screen**
2. Sélectionnez **External** (pour tester) ou **Internal** (pour votre organisation)
3. Remplissez les informations requises :
   - Nom de l'application : `FishingGearPicker`
   - Email de support utilisateur
   - Logo (optionnel)
4. Ajoutez les scopes nécessaires :
   - `userinfo.email`
   - `userinfo.profile`
5. Sauvegardez

### 3. Créer les credentials OAuth 2.0

1. Retournez dans **Credentials**
2. Cliquez sur **Create Credentials** > **OAuth client ID**
3. Sélectionnez **Web application**
4. Configurez :
   - **Name** : `FishingGearPicker Web Client`
   - **Authorized JavaScript origins** : `http://localhost:8000`
   - **Authorized redirect URIs** : 
     - `http://localhost:8000/auth/google/callback`
     - `https://votre-domaine.com/auth/google/callback` (pour production)
5. Cliquez sur **Create**
6. Copiez votre **Client ID** et **Client Secret**

---

## 📘 Obtenir les credentials Facebook

### 1. Créer une application Facebook

1. Allez sur [Facebook Developers](https://developers.facebook.com/)
2. Cliquez sur **My Apps** > **Create App**
3. Sélectionnez **Consumer** comme type d'application
4. Remplissez les informations :
   - Nom de l'application : `FishingGearPicker`
   - Email de contact

### 2. Configurer Facebook Login

1. Dans le dashboard de votre application, ajoutez le produit **Facebook Login**
2. Sélectionnez **Web** comme plateforme
3. Dans **Facebook Login** > **Settings** :
   - **Valid OAuth Redirect URIs** :
     - `http://localhost:8000/auth/facebook/callback`
     - `https://votre-domaine.com/auth/facebook/callback` (pour production)
4. Sauvegardez les changements

### 3. Récupérer les credentials

1. Allez dans **Settings** > **Basic**
2. Copiez :
   - **App ID** (c'est votre `FACEBOOK_CLIENT_ID`)
   - **App Secret** (cliquez sur "Show" pour voir votre `FACEBOOK_CLIENT_SECRET`)

### 4. Mode développement

- En mode développement, seuls les utilisateurs ajoutés comme **testeurs** ou **développeurs** peuvent se connecter
- Pour rendre l'app publique, vous devrez passer en **Live Mode** et répondre aux exigences de Facebook

---

## 🧪 Tester l'authentification

### 1. Démarrer le serveur

```bash
php artisan serve
```

### 2. Accéder à la page de connexion

Ouvrez votre navigateur et allez sur :
```
http://localhost:8000/login
```

### 3. Tester les connexions

- Cliquez sur **Continuer avec Google** pour tester Google OAuth
- Cliquez sur **Continuer avec Facebook** pour tester Facebook OAuth
- Utilisez le formulaire email/mot de passe pour l'authentification classique

---

## 🔒 Sécurité et bonnes pratiques

### Variables d'environnement

- ⚠️ **JAMAIS** committer les fichiers `.env` avec vos vraies credentials
- Utilisez différents credentials pour développement et production
- Rotez régulièrement vos secrets en production

### URLs de redirection

Pour la **production**, mettez à jour :

1. Dans votre `.env` :
```env
GOOGLE_REDIRECT_URI=https://votre-domaine.com/auth/google/callback
FACEBOOK_REDIRECT_URI=https://votre-domaine.com/auth/facebook/callback
```

2. Dans Google Cloud Console et Facebook Developers :
   - Ajoutez vos URLs de production dans les redirect URIs autorisées
   - Supprimez les URLs localhost en production

### HTTPS requis

En production :
- Google et Facebook **requièrent HTTPS**
- Utilisez un certificat SSL valide
- Configurez votre serveur web (Nginx/Apache) correctement

---

## 🎨 Personnalisation

### Modifier les logos sociaux

Les logos Google et Facebook sont intégrés en SVG dans :
- `resources/views/auth/login.blade.php`
- `resources/views/auth/register.blade.php`

### Modifier le design

Le design utilise le système de design Garmin défini dans `resources/css/app.css` :
- Variables CSS pour les couleurs
- Composants réutilisables (`.btn`, `.card`, etc.)

---

## 🐛 Dépannage

### Erreur "Redirect URI mismatch"

**Problème** : L'URL de callback ne correspond pas

**Solution** :
1. Vérifiez que l'URL dans `.env` correspond EXACTEMENT à celle configurée dans Google/Facebook
2. Incluez le protocole (`http://` ou `https://`)
3. N'oubliez pas le port en développement (`:8000`)

### Erreur "App Not Setup"

**Problème** : Facebook Login n'est pas configuré

**Solution** :
1. Assurez-vous d'avoir ajouté le produit "Facebook Login" à votre app
2. Configurez les Valid OAuth Redirect URIs

### L'utilisateur ne peut pas se connecter avec Facebook

**Problème** : L'app est en mode développement

**Solution** :
1. Ajoutez l'utilisateur comme testeur dans Facebook Developers
2. Ou passez l'app en Live Mode (requiert une revue par Facebook)

---

## ✅ Fonctionnalités implémentées

- ✅ Connexion via Google OAuth
- ✅ Connexion via Facebook OAuth
- ✅ Inscription/connexion par email et mot de passe
- ✅ Liaison automatique des comptes (si même email)
- ✅ Design sobre et professionnel style Garmin
- ✅ Session persistante ("Se souvenir de moi")
- ✅ Gestion des erreurs et messages de succès
- ✅ Avatar récupéré depuis le provider social
- ✅ Email automatiquement vérifié pour les connexions sociales

---

## 📚 Ressources

- [Laravel Socialite Documentation](https://laravel.com/docs/11.x/socialite)
- [Laravel Breeze Documentation](https://laravel.com/docs/11.x/starter-kits#breeze)
- [Google OAuth 2.0 Documentation](https://developers.google.com/identity/protocols/oauth2)
- [Facebook Login Documentation](https://developers.facebook.com/docs/facebook-login)

