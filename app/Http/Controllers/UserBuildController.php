<?php

namespace App\Http\Controllers;

use App\Models\Build;
use App\Models\UserSavedBuild;
use App\Models\UserSavedBuildProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserBuildController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display user's saved builds
     */
    public function index()
    {
        $savedBuilds = auth()->user()->savedBuilds()
            ->with(['originalBuild.technique', 'originalBuild.species', 'products'])
            ->latest()
            ->paginate(12);

        return view('profile.builds', compact('savedBuilds'));
    }

    /**
     * Save a build with user's selected products
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'original_build_id' => 'required|exists:builds,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.role' => 'required|string',
            'products.*.quantity' => 'nullable|integer|min:1',
            'products.*.notes' => 'nullable|string',
        ]);

        // Calculate total price
        $totalPrice = 0;
        foreach ($validated['products'] as $productData) {
            $product = \App\Models\Product::find($productData['product_id']);
            $quantity = $productData['quantity'] ?? 1;
            $totalPrice += ($product->price ?? 0) * $quantity;
        }

        // Create saved build
        $savedBuild = auth()->user()->savedBuilds()->create([
            'original_build_id' => $validated['original_build_id'],
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'total_price' => $totalPrice,
            'is_public' => $validated['is_public'] ?? false,
        ]);

        // Attach products
        foreach ($validated['products'] as $productData) {
            $savedBuild->products()->attach($productData['product_id'], [
                'role' => $productData['role'],
                'quantity' => $productData['quantity'] ?? 1,
                'notes' => $productData['notes'] ?? null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Build saved successfully!',
            'saved_build' => $savedBuild,
            'redirect_url' => route('profile.builds.show', $savedBuild->slug)
        ]);
    }

    /**
     * Display a saved build
     */
    public function show(UserSavedBuild $savedBuild)
    {
        // Check authorization
        if (!$savedBuild->is_public && $savedBuild->user_id !== auth()->id()) {
            abort(403, 'This build is private.');
        }

        $savedBuild->load(['originalBuild.technique', 'originalBuild.species', 'products.affiliateLinks.store', 'user']);

        return view('profile.builds-show', compact('savedBuild'));
    }

    /**
     * Update a saved build
     */
    public function update(Request $request, UserSavedBuild $savedBuild)
    {
        // Check authorization
        if ($savedBuild->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.role' => 'required|string',
            'products.*.quantity' => 'nullable|integer|min:1',
            'products.*.notes' => 'nullable|string',
        ]);

        // Calculate total price
        $totalPrice = 0;
        foreach ($validated['products'] as $productData) {
            $product = \App\Models\Product::find($productData['product_id']);
            $quantity = $productData['quantity'] ?? 1;
            $totalPrice += ($product->price ?? 0) * $quantity;
        }

        // Update saved build
        $savedBuild->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'description' => $validated['description'] ?? null,
            'total_price' => $totalPrice,
            'is_public' => $validated['is_public'] ?? false,
        ]);

        // Sync products
        $savedBuild->products()->detach();
        foreach ($validated['products'] as $productData) {
            $savedBuild->products()->attach($productData['product_id'], [
                'role' => $productData['role'],
                'quantity' => $productData['quantity'] ?? 1,
                'notes' => $productData['notes'] ?? null,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Build updated successfully!',
            'saved_build' => $savedBuild,
        ]);
    }

    /**
     * Delete a saved build
     */
    public function destroy(UserSavedBuild $savedBuild)
    {
        // Check authorization
        if ($savedBuild->user_id !== auth()->id()) {
            abort(403);
        }

        $savedBuild->delete();

        return redirect()->route('profile.builds')->with('success', 'Build deleted successfully!');
    }
}
