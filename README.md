# 🎣 FishingGearPicker

A comprehensive fishing gear recommendation platform inspired by PCPartPicker. Users can browse curated fishing equipment setups organized by technique, target species, and budget level.

## 🚀 Features

### Core Functionality
- **Technique-Based Builds**: Browse complete gear setups organized by fishing techniques (Carolina Rig, Drop Shot, Texas Rig, etc.)
- **Species Targeting**: Find equipment recommendations for specific fish species (Bass, Pike, Walleye, Trout, etc.)
- **Budget Tiers**: Builds categorized as Beginner, Intermediate, or Advanced
- **Affiliate Integration**: Multiple affiliate links per product from various retailers (Amazon, Bass Pro Shops, Cabela's, etc.)
- **Product Management**: Comprehensive product database with specifications, pricing, and relationships
- **SEO Optimized**: Built-in SEO features with meta tags, slugs, and OpenGraph support

### Admin Panel (Filament)
- Full CRUD operations for all entities
- Manage Techniques, Species, Products, Builds, and Affiliate Links
- User-friendly interface for content management
- Access at `/admin`

### Frontend Features
- **Home Page**: Featured builds and popular techniques
- **Techniques Page**: Browse all fishing techniques
- **Build Detail Page**: Complete gear list with affiliate links and product specifications
- **Product Detail Page**: Individual product information with purchase options
- **Mobile-First Design**: Responsive Tailwind CSS layout
- **Clean UI**: Modern, outdoors-tech aesthetic

## 🛠️ Tech Stack

- **Backend**: Laravel 11
- **Admin Panel**: Filament 4.x
- **Database**: SQLite (easily switchable to PostgreSQL/MySQL)
- **Frontend**: Blade Templates + TailwindCSS
- **Dynamic Components**: Livewire + Alpine.js (via Filament)

## 📦 Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM

### Setup Steps

1. **Install Dependencies**
```bash
composer install
npm install
```

2. **Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Database Setup**
The project is pre-configured with SQLite. The database file is already created at `database/database.sqlite`.

To use PostgreSQL or MySQL instead, update your `.env`:
```env
DB_CONNECTION=pgsql  # or mysql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=fishinggear
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

4. **Run Migrations & Seed Data**
```bash
php artisan migrate:fresh --seed
```

This will create:
- 3 Fishing Techniques (Carolina Rig, Drop Shot, Texas Rig)
- 2 Species (Largemouth Bass, Smallmouth Bass)
- 7 Product Types (Rod, Reel, Line, Hook, Lure, Weight, Accessory)
- 8 Products (Complete Carolina Rig setup)
- 4 Stores (Amazon, Bass Pro Shops, Cabela's, Tackle Warehouse)
- 1 Featured Build (Carolina Rig for Largemouth Bass - Beginner)
- Admin user: `admin@fishinggear.com` / `password`

5. **Build Frontend Assets**
```bash
npm run dev
```

For production:
```bash
npm run build
```

6. **Start Development Server**
```bash
php artisan serve
```

Visit: `http://localhost:8000`

## 🗂️ Project Structure

### Database Schema

#### Core Models
- **Technique**: Fishing techniques (Carolina Rig, Drop Shot, etc.)
- **Species**: Target fish species (Bass, Pike, etc.)
- **ProductType**: Categories (Rod, Reel, Line, etc.)
- **Product**: Individual fishing products
- **Store**: Retail stores for affiliate links
- **AffiliateLink**: Product-Store relationships with URLs
- **Build**: Complete gear setups
- **BuildProduct**: Pivot table linking builds to products with roles

### Key Relationships
```
Technique (1) ──→ (M) Builds
Species (1) ──→ (M) Builds
Build (M) ──→ (M) Products (via BuildProduct)
Product (1) ──→ (M) AffiliateLinks
Product (M) ──→ (1) ProductType
AffiliateLink (M) ──→ (1) Store
```

### Routes

#### Frontend Routes
- `GET /` - Home page
- `GET /techniques` - Techniques listing
- `GET /techniques/{slug}` - Technique detail with builds
- `GET /builds/{slug}` - Build detail page
- `GET /products/{slug}` - Product detail page

#### Admin Routes
- `GET /admin` - Filament admin panel
- `GET /admin/login` - Admin login

## 📝 Example Seed Data

The seeder creates a complete Carolina Rig build for Largemouth Bass including:

1. **Ugly Stik GX2 Medium Heavy 7ft Spinning Rod** - $49.99
2. **PENN Battle III 3000 Spinning Reel** - $79.95
3. **PowerPro Spectra Braided Line 15lb** - $24.99
4. **Seaguar Red Label Fluorocarbon 12lb** - $19.99
5. **Bullet Weights Tungsten Carolina Weight 3/4oz** - $6.99
6. **Gamakatsu EWG Offset Worm Hook 4/0** - $5.49
7. **Zoom Super Fluke - Watermelon Seed** - $4.99
8. **SPRO Power Swivels Size 6** - $4.29

**Total Build Price**: $196.69

Each product includes:
- Detailed specifications
- Role in the build (Primary Rod, Main Line, etc.)
- Notes explaining why it's chosen
- Affiliate links to Amazon and Bass Pro Shops

## 🎨 Frontend Pages

### Home Page (`/`)
- Hero section with CTA
- Featured builds grid (6 most viewed)
- Popular techniques section
- Call-to-action footer

### Techniques Page (`/techniques`)
- Grid of all active techniques
- Build count per technique
- Links to technique detail pages

### Technique Detail (`/techniques/{slug}`)
- Technique description
- Paginated builds for that technique
- Filter by species and budget tier

### Build Detail (`/builds/{slug}`)
- Complete gear list with images
- Product specifications
- Affiliate purchase links
- Role explanations for each product
- View counter
- SEO meta tags

### Product Detail (`/products/{slug}`)
- Product information and specs
- Multiple affiliate purchase options
- Related builds using this product

## 🔧 Admin Panel Features

Access the admin panel at `/admin` with:
- **Email**: `admin@fishinggear.com`
- **Password**: `password`

### Manage:
- ✅ Techniques (with slugs, descriptions, SEO)
- ✅ Species (with scientific names, habitat info)
- ✅ Product Types
- ✅ Products (with specs, pricing, images)
- ✅ Stores
- ✅ Affiliate Links (per product/store)
- ✅ Builds (technique + species + budget tier)
- ✅ Build-Product relationships (with roles and notes)

## 🎯 SEO Features

### Implemented:
- ✅ Automatic slug generation for all entities
- ✅ Meta tags support (title, description, keywords)
- ✅ OpenGraph tags for social sharing
- ✅ Twitter Card support
- ✅ Breadcrumb navigation
- ✅ Semantic HTML structure
- ✅ Mobile-responsive design

### To Implement (Phase 2):
- [ ] XML Sitemap generation
- [ ] Robots.txt configuration
- [ ] Schema.org structured data
- [ ] Canonical URLs
- [ ] Image optimization and lazy loading

## 🚀 Next Steps & Roadmap

### Phase 2 Features
1. **Interactive Builder**
   - Step-by-step gear selection wizard
   - Budget calculator
   - Compatibility checker

2. **User Features**
   - User accounts and authentication
   - Save favorite builds
   - Create custom builds
   - Reviews and ratings

3. **Enhanced Search**
   - Full-text search across products
   - Advanced filtering (price range, brand, etc.)
   - Comparison tool

4. **Analytics & Tracking**
   - Affiliate link click tracking
   - Build view analytics
   - Popular products dashboard

5. **Content Expansion**
   - Blog/articles section
   - Video tutorials
   - Seasonal recommendations
   - Location-based suggestions

6. **API Development**
   - RESTful API for mobile apps
   - API documentation
   - Rate limiting

## 🔐 Security Notes

- Change default admin credentials in production
- Update `.env` with secure `APP_KEY`
- Configure proper database credentials
- Set up HTTPS in production
- Review and update CORS settings if building an API

## 📄 License

This project is open-source and available under the MIT License.

## 🤝 Contributing

Contributions are welcome! Please follow Laravel best practices and maintain code quality.

## 📧 Support

For issues or questions, please open a GitHub issue.

---

**Built with ❤️ for the fishing community**

🎣 Tight lines and happy fishing! 🎣
