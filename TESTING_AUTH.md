# Guide de test - Authentification hybride

## 🎯 Objectif

Tester l'authentification hybride avec :
- Email + mot de passe
- Google OAuth
- Facebook OAuth

---

## ⚙️ Prérequis

### 1. Configuration des credentials

Ajoutez vos credentials dans le fichier `.env` :

```env
# Google OAuth
GOOGLE_CLIENT_ID=your_google_client_id_here
GOOGLE_CLIENT_SECRET=your_google_client_secret_here
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback

# Facebook OAuth
FACEBOOK_CLIENT_ID=your_facebook_app_id_here
FACEBOOK_CLIENT_SECRET=your_facebook_app_secret_here
FACEBOOK_REDIRECT_URI=http://localhost:8000/auth/facebook/callback
```

📖 Voir `SOCIAL_AUTH_SETUP.md` pour obtenir ces credentials.

### 2. Migrations

Assurez-vous que la base de données est à jour :

```bash
php artisan migrate
```

---

## 🧪 Scénarios de test

### Test 1 : Inscription par email

1. Démarrez le serveur :
   ```bash
   php artisan serve
   ```

2. Ouvrez `http://localhost:8000/login`

3. Cliquez sur **"Créer un compte"**

4. Remplissez le formulaire :
   - Nom : Test User
   - Email : test@example.com
   - Mot de passe : password123
   - Confirmer mot de passe : password123

5. Cliquez sur **"Créer mon compte"**

**Résultat attendu** :
- ✅ Compte créé avec succès
- ✅ Redirection vers `/`
- ✅ Utilisateur connecté

---

### Test 2 : Connexion par email

1. Allez sur `http://localhost:8000/login`

2. Utilisez les credentials :
   - Email : test@example.com
   - Mot de passe : password123

3. Cliquez sur **"Se connecter"**

**Résultat attendu** :
- ✅ Connexion réussie
- ✅ Redirection vers `/`
- ✅ Session active

---

### Test 3 : Connexion avec Google

**⚠️ Requires Google OAuth credentials configured**

1. Allez sur `http://localhost:8000/login`

2. Cliquez sur **"Continuer avec Google"**

3. Sélectionnez un compte Google

4. Autorisez l'application

**Résultat attendu** :
- ✅ Redirection vers Google
- ✅ Authentification Google réussie
- ✅ Retour sur l'application
- ✅ Message de succès : "Connexion réussie avec Google !"
- ✅ Utilisateur créé ou existant mis à jour
- ✅ Colonnes remplies :
  - `provider` = 'google'
  - `provider_id` = ID Google
  - `provider_token` = Token OAuth
  - `avatar` = URL photo Google
  - `email_verified_at` = date actuelle

---

### Test 4 : Connexion avec Facebook

**⚠️ Requires Facebook OAuth credentials configured**

1. Allez sur `http://localhost:8000/login`

2. Cliquez sur **"Continuer avec Facebook"**

3. Connectez-vous avec votre compte Facebook

4. Autorisez l'application

**Résultat attendu** :
- ✅ Redirection vers Facebook
- ✅ Authentification Facebook réussie
- ✅ Retour sur l'application
- ✅ Message de succès : "Connexion réussie avec Facebook !"
- ✅ Utilisateur créé ou existant mis à jour

---

### Test 5 : Liaison automatique des comptes

**Scénario** : Un utilisateur s'inscrit par email, puis se connecte avec Google en utilisant le même email.

1. Créez un compte par email avec `user@example.com`

2. Déconnectez-vous

3. Connectez-vous avec Google en utilisant `user@example.com`

**Résultat attendu** :
- ✅ Pas de doublon d'utilisateur
- ✅ Le compte email existant est mis à jour avec les infos Google :
  - `provider` = 'google'
  - `provider_id` = ID Google
  - `provider_token` = Token
  - `avatar` = Photo Google
- ✅ L'utilisateur est connecté au même compte

---

### Test 6 : Se souvenir de moi

1. Allez sur `http://localhost:8000/login`

2. Cochez **"Se souvenir de moi"**

3. Connectez-vous

4. Fermez le navigateur

5. Rouvrez le navigateur et allez sur `http://localhost:8000`

**Résultat attendu** :
- ✅ L'utilisateur est toujours connecté
- ✅ Session persistante

---

### Test 7 : Mot de passe oublié

1. Allez sur `http://localhost:8000/login`

2. Cliquez sur **"Mot de passe oublié?"**

3. Entrez votre email

4. Cliquez sur **"Envoyer le lien"**

**Résultat attendu** :
- ✅ Email envoyé (vérifiez votre configuration mail)
- ✅ Lien de réinitialisation fonctionnel

---

## 🔍 Vérification en base de données

### Voir les utilisateurs créés

```bash
php artisan tinker
```

```php
// Voir tous les utilisateurs
User::all();

// Voir un utilisateur spécifique avec ses infos sociales
$user = User::where('email', 'test@example.com')->first();
echo "Provider: " . $user->provider . "\n";
echo "Provider ID: " . $user->provider_id . "\n";
echo "Avatar: " . $user->avatar . "\n";
```

### Structure attendue de la table `users`

| Colonne | Type | Description |
|---------|------|-------------|
| id | bigint | ID auto-incrémenté |
| name | string | Nom de l'utilisateur |
| email | string | Email unique |
| provider | string (nullable) | 'google' ou 'facebook' |
| provider_id | string (nullable) | ID du provider social |
| provider_token | string (nullable) | Token OAuth |
| avatar | string (nullable) | URL de la photo de profil |
| password | string (nullable) | Hash du mot de passe (nullable pour social) |
| email_verified_at | timestamp (nullable) | Date de vérification email |

---

## ⚠️ Erreurs courantes

### Erreur 1 : "The provider google is not supported"

**Cause** : Configuration manquante dans `config/services.php`

**Solution** : Vérifiez que vous avez bien ajouté la configuration Google et Facebook

### Erreur 2 : "Redirect URI mismatch"

**Cause** : L'URL de callback ne correspond pas

**Solution** :
1. Vérifiez `.env` : `http://localhost:8000/auth/google/callback`
2. Vérifiez Google Cloud Console : même URL exacte
3. Pas d'espace, pas de slash à la fin

### Erreur 3 : "Client secret not found"

**Cause** : Variables `.env` non chargées

**Solution** :
```bash
php artisan config:clear
php artisan cache:clear
php artisan serve
```

### Erreur 4 : Facebook - "App Not Setup"

**Cause** : Facebook Login pas configuré

**Solution** :
1. Allez dans Facebook Developers
2. Ajoutez le produit "Facebook Login"
3. Configurez les Valid OAuth Redirect URIs

---

## ✅ Checklist finale

Avant de considérer le test réussi, vérifiez :

- [ ] Inscription par email fonctionne
- [ ] Connexion par email fonctionne
- [ ] Connexion Google fonctionne (si credentials configurés)
- [ ] Connexion Facebook fonctionne (si credentials configurés)
- [ ] Liaison automatique des comptes fonctionne
- [ ] "Se souvenir de moi" fonctionne
- [ ] Design sobre Garmin appliqué
- [ ] Boutons sociaux avec logos corrects
- [ ] Messages de succès/erreur affichés
- [ ] Pas d'erreur en console
- [ ] Redirection correcte après login

---

## 📸 Screenshots attendus

### Page de login
- Titre "Connexion"
- 2 boutons sociaux (Google + Facebook) avec logos
- Séparateur "ou"
- Formulaire email/mot de passe
- Checkbox "Se souvenir de moi"
- Lien "Mot de passe oublié?"
- Bouton "Se connecter"
- Lien "Créer un compte"

### Page d'inscription
- Titre "Créer un compte"
- 2 boutons sociaux (Google + Facebook) avec logos
- Séparateur "ou"
- Formulaire : nom, email, mot de passe, confirmation
- Bouton "Créer mon compte"
- Lien "Déjà inscrit?"

---

## 🎨 Design Garmin

Le design doit respecter :
- ✅ Fond gris clair (`--color-neutral-50`)
- ✅ Carte blanche avec ombre subtile
- ✅ Boutons monochromes (noir/blanc/gris)
- ✅ Typographie Inter
- ✅ Espacements cohérents
- ✅ Pas de couleurs vives (sauf logos sociaux)
- ✅ Transitions douces

---

## 📝 Notes

- En développement, Google et Facebook peuvent nécessiter d'ajouter des testeurs
- En production, configurez HTTPS obligatoirement
- Les tokens OAuth ne sont pas persistés côté client (sécurité)
- L'avatar est stocké comme URL, pas téléchargé localement




