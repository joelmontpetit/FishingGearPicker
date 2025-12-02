# 🧪 Phase 2 Testing Guide

## Ready to Test! ✅

All Phase 2 features are now implemented. Here's how to test them:

---

## 🎯 Test Scenarios

### 1. Test Product Carousel (Admin Setup Required)

**Admin Setup:**
1. Go to `http://localhost:8080/admin/builds`
2. Edit an existing build (e.g., "Carolina Rig")
3. Scroll to "Product Options" section
4. Add multiple products for the same role:
   - **Rod:**
     - Budget: St. Croix Bass X (💰)
     - Mid-Range: G. Loomis E6X (💎)
     - Premium: Shimano Expride (⭐)
   - **Reel:**
     - Budget: Daiwa Fuego LT (💰)
     - Mid-Range: Shimano Curado DC (💎)
     - Premium: Daiwa Tatula Elite (⭐)
4. Mark one as "Recommended" per role
5. Save build

**Frontend Test:**
1. Go to `http://localhost:8080/builds/carolina-rig`
2. ✅ **Check:** Product options grouped by role (Rod, Reel, etc.)
3. ✅ **Check:** Price tier tabs visible (💰 Budget, 💎 Mid-Range, ⭐ Premium)
4. ✅ **Click:** Budget tab - should show budget product
5. ✅ **Click:** Mid-Range tab - should show mid-range product
6. ✅ **Click:** Premium tab - should show premium product
7. ✅ **Check:** Smooth transition between tiers
8. ✅ **Check:** Recommended badge on default option
9. ✅ **Check:** All product details visible (name, brand, price, description, affiliate links)

---

### 2. Test Save Build Feature

**Prerequisites:**
- Must be logged in
- Build must have product options (from Test 1)

**Steps:**
1. Go to `http://localhost:8080/builds/carolina-rig`
2. ✅ **Check:** "Save This Build" button visible in header
3. ✅ **Click:** "Save This Build" button
4. ✅ **Check:** Modal opens with form
5. ✅ **Enter:** Build name (e.g., "My Carolina Setup")
6. ✅ **Enter:** Description (optional)
7. ✅ **Toggle:** Public/Private checkbox
8. ✅ **Check:** Selected products summary visible
9. ✅ **Check:** Total price calculated correctly
10. ✅ **Click:** "Save Build" button
11. ✅ **Check:** Success message appears
12. ✅ **Check:** Redirects to saved build page (`/profile/builds/{slug}`)

**Error Cases:**
- ✅ **Test:** Leave name empty - should show validation error
- ✅ **Test:** Not logged in - should show "Login to Save Build" button

---

### 3. Test My Builds Page

**Steps:**
1. Go to `http://localhost:8080/profile/builds`
2. ✅ **Check:** All saved builds listed
3. ✅ **Check:** Each card shows:
   - Technique and species badges
   - Public/Private badge
   - Build name (clickable)
   - Description (truncated)
   - Total price
   - Product count
4. ✅ **Click:** "View Build" button
5. ✅ **Check:** Redirects to build detail page
6. ✅ **Click:** Delete button (confirm dialog)
7. ✅ **Check:** Build deleted and redirected back to list

**Empty State:**
- ✅ **Test:** Delete all builds
- ✅ **Check:** Empty state shown with "Browse Techniques" CTA

---

### 4. Test Saved Build Detail Page

**Steps:**
1. Go to `http://localhost:8080/profile/builds/{your-build-slug}`
2. ✅ **Check:** Build name and description visible
3. ✅ **Check:** Technique and species badges
4. ✅ **Check:** Public/Private badge
5. ✅ **Check:** Total price displayed prominently
6. ✅ **Check:** All selected products listed with:
   - Product image
   - Role badge
   - Product name (clickable to product page)
   - Brand and model
   - Price
   - Description
   - Affiliate links
7. ✅ **Check:** "View Original Build" button works
8. ✅ **Check:** "Delete Build" button works (with confirmation)

**Authorization Tests:**
- ✅ **Test:** Access your own private build - should work
- ✅ **Test:** Access someone else's private build - should show 403 error
- ✅ **Test:** Access someone else's public build - should work
- ✅ **Test:** Delete button only visible for your own builds

---

### 5. Test Share Build Feature

**Prerequisites:**
- Build must be PUBLIC

**Steps:**
1. Go to your saved build detail page
2. ✅ **Check:** "Share Build" button visible (only for public builds)
3. ✅ **Click:** "Share Build" button
4. ✅ **Check:** Modal opens with build URL
5. ✅ **Click:** Copy button
6. ✅ **Check:** "Link copied to clipboard!" message appears
7. ✅ **Paste:** URL in new browser tab
8. ✅ **Check:** Build page loads correctly

**Private Build Test:**
- ✅ **Test:** Make build private
- ✅ **Check:** Share button is hidden

**Social Sharing Test:**
- ✅ **Paste:** URL in Facebook/Twitter link preview
- ✅ **Check:** OG tags display correctly (title, description)

---

### 6. Test Navigation

**Desktop:**
1. ✅ **Click:** User dropdown (top right)
2. ✅ **Check:** "My Builds" link visible
3. ✅ **Click:** "My Builds"
4. ✅ **Check:** Redirects to `/profile/builds`

**Mobile:**
1. ✅ **Click:** Burger menu
2. ✅ **Check:** "My Builds" link visible
3. ✅ **Click:** "My Builds"
4. ✅ **Check:** Redirects to `/profile/builds`

---

## 🐛 Known Issues / Limitations

1. **Mobile Swipe:** Carousel doesn't support swipe gestures yet (tabs work fine)
2. **Edit Build:** Update functionality exists but no UI for editing saved builds yet
3. **Multiple Quantities:** Can't add multiple quantities of same product (future enhancement)

---

## 🎨 Design Checklist

- ✅ Monochrome design maintained (no colors except for status indicators)
- ✅ Garmin-inspired styling
- ✅ Mobile responsive
- ✅ Consistent spacing and typography
- ✅ Hover states on buttons and links
- ✅ Smooth transitions and animations
- ✅ Clean, professional appearance

---

## 🔧 Technical Verification

### Database
```bash
# Check tables exist
php artisan tinker
>>> Schema::hasTable('build_product_options')  // should return true
>>> Schema::hasTable('user_saved_builds')      // should return true
>>> Schema::hasTable('user_saved_build_products')  // should return true
```

### Routes
```bash
php artisan route:list --name=profile.builds
# Should show 5 routes:
# - profile.builds (GET)
# - profile.builds.store (POST)
# - profile.builds.show (GET)
# - profile.builds.update (PUT)
# - profile.builds.destroy (DELETE)
```

### Models
```bash
php artisan tinker
>>> $build = \App\Models\Build::first()
>>> $build->productOptions  // should return collection
>>> $user = \App\Models\User::first()
>>> $user->savedBuilds  // should return collection
```

---

## ✅ Success Checklist

Before marking Phase 2 as complete:

- [ ] Admin can add product options in Filament
- [ ] Frontend carousel displays options correctly
- [ ] Price tier tabs work on desktop
- [ ] Mobile responsive (tabs work, swipe optional)
- [ ] Save build modal opens and works
- [ ] Build saves correctly to database
- [ ] My Builds page lists all builds
- [ ] Can view saved build detail
- [ ] Can delete saved build
- [ ] Share button works for public builds
- [ ] Copy link works
- [ ] OG tags work for social sharing
- [ ] Authorization works (public/private)
- [ ] Navigation links work (desktop + mobile)
- [ ] Design is consistent across all pages

---

## 📝 Report Issues

If you find any issues during testing:

1. Note the URL where issue occurred
2. Describe what you did
3. Describe expected behavior
4. Describe actual behavior
5. Include any error messages (check browser console with F12)
6. Include screenshot if possible

Let me know and I'll fix it immediately! 💪

---

**Happy Testing!** 🎣


