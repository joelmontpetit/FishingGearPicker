# 🚀 Quick Start Guide - FishingGearPicker

## Get Up and Running in 5 Minutes

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Build Frontend Assets
```bash
npm run dev
```
Leave this running in a terminal.

### 3. Start the Server (New Terminal)
```bash
php artisan serve
```

### 4. Access the Application

**Frontend**: http://localhost:8000
- Browse featured builds
- View techniques
- Explore the Carolina Rig build for Bass

**Admin Panel**: http://localhost:8000/admin
- **Email**: `admin@fishinggear.com`
- **Password**: `password`

## ✅ What's Already Set Up

The database is already migrated and seeded with:

### Sample Data Included:
- ✅ 3 Fishing Techniques
- ✅ 2 Fish Species  
- ✅ 8 Products (complete Carolina Rig setup)
- ✅ 4 Retail Stores
- ✅ 16 Affiliate Links
- ✅ 1 Featured Build ($196.69 total)

### Pages You Can Visit:
1. **Home** - `/` - Featured builds and techniques
2. **Techniques** - `/techniques` - All fishing techniques
3. **Carolina Rig** - `/techniques/carolina-rig` - Technique detail
4. **Sample Build** - `/builds/carolina-rig-largemouth-bass-beginner` - Full gear list
5. **Admin** - `/admin` - Content management

## 🎯 Try These Actions

### In the Admin Panel:
1. **Add a New Technique**
   - Go to Techniques
   - Click "New Technique"
   - Fill in name, description
   - Slug auto-generates

2. **Create a Product**
   - Go to Products
   - Add specifications as key-value pairs
   - Link to product type

3. **Build a New Setup**
   - Go to Builds
   - Select technique and species
   - Choose budget tier
   - Add products with roles

### On the Frontend:
1. Browse the featured Carolina Rig build
2. Click affiliate links (they're placeholder URLs)
3. View product specifications
4. Check out the responsive mobile design

## 🔧 Common Commands

```bash
# Reset database and reseed
php artisan migrate:fresh --seed

# Clear all caches
php artisan optimize:clear

# Build for production
npm run build

# Run tests (when you add them)
php artisan test
```

## 📱 Mobile Testing

The site is fully responsive. Test on:
- Desktop: Works great at 1920x1080
- Tablet: Optimized for iPad
- Mobile: Perfect on iPhone/Android

## 🎨 Customization

### Change Colors
Edit `tailwind.config.js` to customize the color scheme.

### Update Branding
- Logo: Update in `resources/views/layouts/app.blade.php`
- Favicon: Add to `public/` directory
- Images: Store in `public/images/`

### Add More Data
Use the admin panel or create seeders in `database/seeders/`.

## 🐛 Troubleshooting

**Issue**: "Class not found" errors
```bash
composer dump-autoload
php artisan optimize:clear
```

**Issue**: Styles not loading
```bash
npm run dev
# or
npm run build
```

**Issue**: Database errors
```bash
php artisan migrate:fresh --seed
```

**Issue**: Filament resources not showing
The Filament resources have been temporarily removed due to type compatibility issues with Filament 4.x. You can manage data through:
1. Database directly
2. Tinker: `php artisan tinker`
3. Custom admin controllers (to be added)

## 📚 Next Steps

1. **Customize the home page** - Edit `resources/views/home.blade.php`
2. **Add more builds** - Use the admin panel
3. **Update affiliate links** - Add real URLs in the database
4. **Add images** - Upload product and build images
5. **Configure email** - Set up SMTP in `.env` for notifications

## 🎣 Sample Build Included

**Carolina Rig for Largemouth Bass - Beginner**

Complete 8-product setup:
- Ugly Stik GX2 Rod ($49.99)
- PENN Battle III Reel ($79.95)
- PowerPro Braided Line ($24.99)
- Seaguar Fluorocarbon Leader ($19.99)
- Tungsten Weight ($6.99)
- Gamakatsu Hooks ($5.49)
- Zoom Soft Plastic ($4.99)
- SPRO Swivels ($4.29)

**Total: $196.69**

View it at: http://localhost:8000/builds/carolina-rig-largemouth-bass-beginner

---

**Happy Fishing! 🎣**

Need help? Check the main README.md for detailed documentation.

