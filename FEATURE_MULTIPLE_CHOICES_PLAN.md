# 🎣 Feature: Multiple Product Choices per Build

## 📋 Requirements Summary

### 1. Multiple Product Options per Role
**Current:** 1 rod, 1 reel, 1 lure per build  
**New:** Multiple alternatives for EACH role

### 2. User Build Saving ⭐ NEW
**Feature:** Users can save their custom build configurations
- Save selected products from each category
- Name their build (e.g., "My Bass Rig")
- View saved builds in profile
- Share build via link
- Edit/delete saved builds

**Example Build:**
```
Rod Options:
  - Option A: St. Croix Bass X ($150) - Budget
  - Option B: G. Loomis E6X ($300) - Mid-range  
  - Option C: Shimano Expride ($400) - Premium

Reel Options:
  - Option A: Daiwa Fuego ($80) - Budget
  - Option B: Shimano Curado ($200) - Mid-range

Soft Plastic Options:
  - Yamamoto Senko 5" (Green Pumpkin)
  - Zoom Baby Brush Hog (Watermelon)
  - Strike King Rage Bug (Black/Blue)
  + Add more...

Hook Options:
  - Gamakatsu EWG 3/0
  - Owner Offset Worm 4/0
  + Add more...
```

### 2. UI/UX Requirements

#### Desktop
- ✅ Left/Right arrows to cycle through options
- ✅ Product cards with image, name, price
- ✅ Clear indicator of current option (1 of 3)
- ✅ "+ Add Option" button for admin

#### Mobile
- ✅ Swipe left/right to cycle options
- ✅ Touch-friendly cards
- ✅ Dots indicator for multiple options

#### Admin (Filament)
- ✅ Add multiple products per role
- ✅ Set price tier (budget/mid/premium)
- ✅ Set as "recommended" option
- ✅ Reorder options (drag & drop)

### 3. Budget Tiers
- **Budget:** $0-150
- **Mid-range:** $150-300
- **Premium:** $300+

---

## 🗄️ Database Changes

### New Table: `build_product_options`

```sql
CREATE TABLE build_product_options (
    id BIGINT PRIMARY KEY,
    build_id BIGINT,              -- Which build
    role VARCHAR(50),              -- 'rod', 'reel', 'line', 'lure', etc.
    product_id BIGINT,             -- Which product
    sort_order INT DEFAULT 0,      -- Display order
    is_recommended BOOLEAN,        -- Mark as recommended
    price_tier ENUM,               -- 'budget', 'mid', 'premium'
    notes TEXT,                    -- Optional notes
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (build_id) REFERENCES builds(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
```

### New Table: `user_saved_builds` ⭐

```sql
CREATE TABLE user_saved_builds (
    id BIGINT PRIMARY KEY,
    user_id BIGINT NOT NULL,       -- Who saved it
    build_id BIGINT NOT NULL,      -- Base build template
    name VARCHAR(255),              -- User's custom name
    slug VARCHAR(255) UNIQUE,       -- For sharing (user-bass-rig-2024)
    notes TEXT,                     -- User's notes
    is_public BOOLEAN DEFAULT 0,    -- Share publicly?
    total_price DECIMAL(10,2),      -- Calculated total
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (build_id) REFERENCES builds(id)
);
```

### New Table: `user_saved_build_products` ⭐

```sql
CREATE TABLE user_saved_build_products (
    id BIGINT PRIMARY KEY,
    user_saved_build_id BIGINT,    -- Which saved build
    product_id BIGINT,              -- Selected product
    role VARCHAR(50),               -- 'rod', 'reel', etc.
    quantity INT DEFAULT 1,         -- How many
    notes TEXT,                     -- User notes for this product
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (user_saved_build_id) REFERENCES user_saved_builds(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
```

### Modified: `build_product` (current pivot)
Keep for backward compatibility, but migrate to new system.

---

## 🎨 Frontend Design

### Product Option Card

```
┌─────────────────────────────┐
│  [<]  ROD OPTIONS    [>]    │ ← Arrows
├─────────────────────────────┤
│                             │
│      [Product Image]        │
│                             │
│   St. Croix Bass X 7'       │
│   Medium Heavy              │
│                             │
│   $149.99                   │
│   ⭐ Budget Option          │
│                             │
│   [View Details]            │
│                             │
└─────────────────────────────┘
        ● ○ ○                  ← Dots indicator
```

### Multiple Lures Section

```
┌─────────────────────────────┐
│  SOFT PLASTICS              │
│  [+ Add Lure]               │
├─────────────────────────────┤
│                             │
│  ✓ Yamamoto Senko 5"        │
│    Green Pumpkin            │
│    $8.99                    │
│    [×]                      │ ← Remove
│                             │
│  ✓ Zoom Brush Hog           │
│    Watermelon Red           │
│    $4.99                    │
│    [×]                      │
│                             │
└─────────────────────────────┘
```

---

## 📱 Implementation Plan

### Phase 1: Database & Models ✅
1. Create migration for `build_product_options`
2. Create `BuildProductOption` model
3. Update relationships in `Build` model
4. Seed example data

### Phase 2: Admin Interface (Filament)
1. Update `BuildResource` form
2. Add Repeater for multiple products per role
3. Add price tier selector
4. Add sort order field
5. Add "recommended" toggle

### Phase 3: Frontend - Product Carousel
1. Create ProductCarousel Blade component
2. Add Alpine.js for carousel logic
3. Add swipe detection (mobile)
4. Add arrow navigation (desktop)
5. Style with Garmin design

### Phase 4: Frontend - Multiple Lures
1. Create MultipleProductSelector component
2. Add "Add Lure" button
3. Display selected lures list
4. Add remove functionality

### Phase 5: User Saved Builds ⭐
1. Create migrations for user saved builds
2. Create `UserSavedBuild` model with relationships
3. Add "Save Build" button on build page (auth required)
4. Create save build modal/form
5. User profile: "My Saved Builds" section
6. View/Edit/Delete saved builds
7. Share functionality (public link)

### Phase 6: Testing & Polish
1. Test on mobile (swipe)
2. Test on desktop (arrows)
3. Test budget filtering
4. Test save/load builds
5. Add smooth transitions

---

## 🎯 Key Features

### 1. Product Carousel Component

**Props:**
- `role` (string): 'rod', 'reel', 'lure', etc.
- `products` (array): List of product options
- `currentIndex` (int): Active product

**Methods:**
- `nextProduct()`: Show next option
- `prevProduct()`: Show previous option
- `selectProduct(index)`: Jump to specific option

### 2. Budget Filter

**User selects budget:**
- Show only products in range
- Highlight "best value"
- Show upgrade options

### 3. Build Total Calculator

**Dynamic pricing:**
- Calculate based on selected options
- Show price range (min-max)
- Update on selection change

---

## 💾 Data Structure Example

```json
{
  "build_id": 1,
  "products": {
    "rod": [
      {
        "id": 1,
        "name": "St. Croix Bass X",
        "price": 149.99,
        "tier": "budget",
        "recommended": true,
        "sort_order": 1
      },
      {
        "id": 2,
        "name": "G. Loomis E6X",
        "price": 299.99,
        "tier": "mid",
        "recommended": false,
        "sort_order": 2
      }
    ],
    "lures": [
      {
        "id": 10,
        "name": "Yamamoto Senko",
        "color": "Green Pumpkin",
        "price": 8.99,
        "quantity": 1
      },
      {
        "id": 11,
        "name": "Zoom Brush Hog",
        "color": "Watermelon",
        "price": 4.99,
        "quantity": 2
      }
    ]
  }
}
```

---

## 🎨 UI/UX Flow

### User Journey

1. **View Build Page**
   - See default/recommended products
   - Notice "3 options available" badge

2. **Browse Options**
   - Click arrow or swipe
   - See different rod options
   - Compare prices

3. **Select Product**
   - Click "Select" or product card
   - Price updates in build total
   - Continue shopping

4. **Add Extra Lures**
   - Click "+ Add Lure"
   - See lure options carousel
   - Add to build
   - Repeat for more lures

5. **View Cart/Build Total**
   - See all selected products
   - Total price calculated
   - Ready to purchase via affiliate links

---

## 🔄 Compatibility

### Backward Compatibility
- Existing builds still work
- Migrate old `build_product` data
- Keep single-product builds functional

### Migration Strategy
1. Keep current pivot table
2. Add new options table
3. Migrate data gradually
4. Eventually deprecate old system

---

## 📊 Success Metrics

### User Engagement
- % of users exploring options
- Average options viewed per build
- Conversion rate improvement

### Business Value
- More affiliate link clicks
- Higher average order value
- Better user satisfaction

---

## 💾 User Saved Builds Feature

### User Flow

#### 1. Build Configuration
```
User on Build Page:
1. Browse product options (arrows/swipe)
2. Select preferred rod (Option B - G. Loomis)
3. Select preferred reel (Option A - Daiwa)
4. Add multiple lures (Senko + Brush Hog)
5. See total price update: $387.98
```

#### 2. Save Build
```
┌─────────────────────────────────┐
│  Your Custom Build              │
│  Total: $387.98                 │
│                                 │
│  [💾 Save This Build]           │ ← Button
└─────────────────────────────────┘

↓ Click Save

┌─────────────────────────────────┐
│  Save Your Build                │
├─────────────────────────────────┤
│  Build Name:                    │
│  [My Awesome Bass Rig____]      │
│                                 │
│  Notes (optional):              │
│  [This is my go-to setup for__] │
│  [spring bass fishing_________] │
│                                 │
│  ☐ Make public (share with     │
│     community)                  │
│                                 │
│  [Cancel]  [Save Build]         │
└─────────────────────────────────┘
```

#### 3. View Saved Builds
```
User Profile → My Builds Tab

┌─────────────────────────────────┐
│  My Saved Builds (3)            │
│  [+ New Build]                  │
├─────────────────────────────────┤
│                                 │
│  🎣 My Awesome Bass Rig         │
│  Total: $387.98 • 4 items       │
│  Created: Dec 1, 2025           │
│  [View] [Edit] [Delete] [Share] │
│                                 │
├─────────────────────────────────┤
│                                 │
│  🎣 Budget Walleye Setup        │
│  Total: $245.50 • 5 items       │
│  Created: Nov 28, 2025          │
│  [View] [Edit] [Delete] [Share] │
│                                 │
└─────────────────────────────────┘
```

#### 4. Share Build
```
Share Modal:
┌─────────────────────────────────┐
│  Share Your Build               │
├─────────────────────────────────┤
│  Public Link:                   │
│  https://fishinggear.com/       │
│  builds/my-awesome-bass-rig     │
│  [Copy Link]                    │
│                                 │
│  Anyone with this link can      │
│  view your build configuration. │
│                                 │
│  [Close]                        │
└─────────────────────────────────┘
```

### Backend Structure

#### Models

**UserSavedBuild Model:**
```php
class UserSavedBuild extends Model
{
    protected $fillable = [
        'user_id',
        'build_id',
        'name',
        'slug',
        'notes',
        'is_public',
        'total_price',
    ];
    
    // Relationships
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function build() {
        return $this->belongsTo(Build::class);
    }
    
    public function products() {
        return $this->hasMany(UserSavedBuildProduct::class);
    }
    
    // Methods
    public function calculateTotal() {
        return $this->products()
            ->join('products', 'products.id', '=', 'product_id')
            ->sum('products.price * quantity');
    }
}
```

#### Routes

```php
// User saved builds
Route::middleware('auth')->group(function () {
    Route::get('/profile/builds', [UserBuildController::class, 'index'])
        ->name('profile.builds');
    
    Route::post('/builds/{build}/save', [UserBuildController::class, 'store'])
        ->name('builds.save');
    
    Route::get('/my-builds/{savedBuild}', [UserBuildController::class, 'show'])
        ->name('my-builds.show');
    
    Route::put('/my-builds/{savedBuild}', [UserBuildController::class, 'update'])
        ->name('my-builds.update');
    
    Route::delete('/my-builds/{savedBuild}', [UserBuildController::class, 'destroy'])
        ->name('my-builds.destroy');
});

// Public shared builds
Route::get('/shared-builds/{slug}', [SharedBuildController::class, 'show'])
    ->name('shared-builds.show');
```

### Frontend Components

#### Save Build Button
```blade
@auth
<div class="save-build-section">
    <button 
        @click="showSaveModal = true"
        class="btn btn-lg"
        style="width: 100%; margin-top: var(--spacing-lg);">
        💾 Save This Build
    </button>
</div>
@else
<div class="save-build-section">
    <a href="{{ route('login') }}" class="btn btn-lg" style="width: 100%;">
        Login to Save Build
    </a>
</div>
@endauth
```

#### Save Modal Component
```blade
<div 
    x-show="showSaveModal"
    x-cloak
    class="modal-overlay">
    <div class="modal-content">
        <form method="POST" action="{{ route('builds.save', $build) }}">
            @csrf
            <!-- Form fields -->
        </form>
    </div>
</div>
```

### Features

#### 1. Auto-Save Progress (Optional)
- Save selections to localStorage
- Restore on page reload
- Prevent lost work

#### 2. Compare Builds
- Compare 2-3 saved builds side-by-side
- See price differences
- See product differences

#### 3. Build Templates
- Admin creates featured builds
- Users can clone and customize
- "Start from template" feature

#### 4. Social Sharing
- Generate OG image of build
- Share on social media
- Show total price and key items

### Security

#### Access Control
```php
// Policy: UserSavedBuildPolicy
public function update(User $user, UserSavedBuild $savedBuild)
{
    return $user->id === $savedBuild->user_id;
}

public function delete(User $user, UserSavedBuild $savedBuild)
{
    return $user->id === $savedBuild->user_id;
}

public function view(User $user, UserSavedBuild $savedBuild)
{
    return $savedBuild->is_public || 
           $user->id === $savedBuild->user_id;
}
```

### Analytics

#### Track
- Saves per build
- Most saved builds
- Average build price
- Popular product combinations
- Conversion rate (save → purchase)

---

## 🚀 Next Steps

1. **Review & Approve Plan**
2. **Create Migration**
3. **Update Models**
4. **Build Filament Interface**
5. **Create Frontend Components**
6. **Test Extensively**
7. **Deploy**

---

## 📝 Notes

### Technical Considerations
- Alpine.js for carousel logic
- Touch events for mobile swipe
- Lazy load product images
- Cache product options

### Design Considerations
- Maintain Garmin monochrome style
- Smooth animations (300ms)
- Clear visual hierarchy
- Accessibility (keyboard nav)

### Performance
- Limit to 5 options per role
- Paginate if more needed
- Optimize images
- Cache queries

---

**Status:** 📋 Planning  
**Branch:** `feature/multiple-product-choices`  
**Backup:** `backup_2025-12-01_17h29m55s.sqlite`  
**Estimated Time:** 4-6 hours  
**Complexity:** High 🔴

