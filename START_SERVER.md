# 🚀 Guide de Démarrage du Serveur

## ⚠️ Problème de Port Détecté

Si vous voyez des erreurs "Failed to listen on 127.0.0.1:8000", cela signifie que les ports sont déjà utilisés ou bloqués.

## ✅ Solutions de Démarrage

### Solution 1 : Port Personnalisé (Recommandé)

```bash
php artisan serve --port=8080
```

Puis visitez : **http://localhost:8080**

### Solution 2 : Serveur PHP Direct

```bash
php -S localhost:8080 -t public
```

Puis visitez : **http://localhost:8080**

### Solution 3 : Avec Host Spécifique

```bash
php artisan serve --host=127.0.0.1 --port=9000
```

Puis visitez : **http://127.0.0.1:9000**

### Solution 4 : Laragon, XAMPP ou WAMP

Si vous utilisez Laragon, XAMPP ou WAMP :

1. Placez le projet dans le dossier `www` ou `htdocs`
2. Accédez via : **http://localhost/fshinggearpicker/public**

**Important pour Apache :**
Créez un fichier `.htaccess` dans le dossier `public` :

```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## 🔧 Diagnostic des Problèmes

### Vérifier les Ports Utilisés

**Windows PowerShell:**
```powershell
Get-NetTCPConnection -LocalPort 8000 | Select-Object State, OwningProcess
```

**Windows CMD:**
```cmd
netstat -ano | findstr :8000
```

### Libérer un Port (Windows)

Si un processus bloque le port 8000 :

```powershell
# Trouver le processus
Get-Process -Id (Get-NetTCPConnection -LocalPort 8000).OwningProcess

# Arrêter le processus (remplacez PID par l'ID du processus)
Stop-Process -Id PID -Force
```

### Vérifier si le Serveur Fonctionne

**PowerShell:**
```powershell
Invoke-WebRequest -Uri "http://localhost:8080" -UseBasicParsing
```

**Navigateur:**
Ouvrez simplement : http://localhost:8080

## 📱 Accès depuis d'Autres Appareils (Réseau Local)

Pour tester sur mobile/tablette sur le même réseau WiFi :

```bash
php artisan serve --host=0.0.0.0 --port=8080
```

Puis trouvez votre IP locale :
```powershell
ipconfig | findstr IPv4
```

Accédez depuis votre mobile : **http://VOTRE-IP:8080**

## 🎯 Démarrage Complet de l'Application

### Étape 1 : Démarrer Vite (Assets Frontend)

**Terminal 1:**
```bash
npm run dev
```

Vous devriez voir :
```
VITE v5.x.x  ready in xxx ms

➜  Local:   http://localhost:5173/
➜  Network: use --host to expose
```

### Étape 2 : Démarrer Laravel

**Terminal 2:**
```bash
php artisan serve --port=8080
```

Ou :
```bash
php -S localhost:8080 -t public
```

### Étape 3 : Ouvrir l'Application

Visitez : **http://localhost:8080**

## 🌐 URLs de l'Application

Une fois le serveur démarré :

| Page | URL |
|------|-----|
| **Accueil** | http://localhost:8080 |
| **Techniques** | http://localhost:8080/techniques |
| **Carolina Rig** | http://localhost:8080/techniques/carolina-rig |
| **Build Exemple** | http://localhost:8080/builds/carolina-rig-largemouth-bass-beginner |
| **Admin Panel** | http://localhost:8080/admin |

## 🔥 Pare-feu Windows

Si le serveur démarre mais vous ne pouvez pas y accéder :

1. Ouvrez **Pare-feu Windows Defender**
2. Cliquez sur **Paramètres avancés**
3. **Règles de trafic entrant** → **Nouvelle règle**
4. Type : **Port**
5. Port local spécifique : **8080**
6. Autoriser la connexion
7. Nommez la règle : "Laravel Dev Server"

## 🐛 Dépannage

### Erreur : "Failed to listen on 127.0.0.1:xxxx"

**Cause :** Le port est déjà utilisé ou bloqué

**Solution :** Utilisez un port différent ou libérez le port

### Erreur : "No such file or directory"

**Cause :** Mauvais répertoire de travail

**Solution :**
```bash
cd C:\laravel\fshinggearpicker
php artisan serve --port=8080
```

### Erreur : "Connection refused"

**Cause :** Le serveur n'est pas démarré ou pare-feu

**Solution :**
1. Vérifiez que le serveur est démarré
2. Vérifiez le pare-feu Windows
3. Essayez `127.0.0.1` au lieu de `localhost`

### Page Blanche ou Erreur 500

**Cause :** Problème de permissions ou de cache

**Solution :**
```bash
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

Puis redémarrez le serveur.

## 🎨 Mode Production (Compilation Assets)

Pour compiler les assets pour la production :

```bash
npm run build
```

Ensuite démarrez le serveur normalement.

## ✅ Checklist de Démarrage

- [ ] Terminal 1 : `npm run dev` (Vite running)
- [ ] Terminal 2 : `php artisan serve --port=8080` (Laravel running)
- [ ] Navigateur : Ouvrir http://localhost:8080
- [ ] Vérifier que la page d'accueil s'affiche
- [ ] Tester la navigation vers les techniques
- [ ] Vérifier un build détaillé

## 📞 Support

Si vous rencontrez toujours des problèmes :

1. Vérifiez les logs : `storage/logs/laravel.log`
2. Activez le debug : `.env` → `APP_DEBUG=true`
3. Vérifiez PHP : `php --version` (doit être 8.2+)
4. Vérifiez Composer : `composer --version`

---

**🎣 Bonne pêche et bon développement !**

