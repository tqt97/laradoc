<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Services\Feature as FeatureService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

class FeatureController extends Controller
{
    public function __construct(
        protected FeatureService $featureService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $features = Feature::orderBy('key')->get();

        return view('admin.features.index', compact('features'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $routes = collect(Route::getRoutes())->map(fn ($route) => $route->getName())->filter()->sort()->values();

        return view('admin.features.create', compact('roles', 'routes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|unique:features,key',
            'enabled' => 'boolean',
            'roles' => 'array',
            'show' => 'boolean',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
            'ui.text' => 'nullable|string',
            'ui.route' => 'nullable|string',
            'ui.route_active' => 'nullable|string',
            'ui.icon' => 'nullable|string',
            'ui.is_special' => 'boolean',
            'ui.special_classes' => 'nullable|string',
        ]);

        Feature::create($validated);
        $this->featureService->clearCache();

        return redirect()->route('admin.features.index')->with('success', 'Feature created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Feature $feature)
    {
        $roles = Role::all();
        $routes = collect(Route::getRoutes())->map(fn ($route) => $route->getName())->filter()->sort()->values();

        return view('admin.features.edit', compact('feature', 'roles', 'routes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Feature $feature)
    {
        $validated = $request->validate([
            'key' => 'required|string|unique:features,key,'.$feature->id,
            'enabled' => 'boolean',
            'roles' => 'array',
            'show' => 'boolean',
            'location' => 'nullable|string',
            'description' => 'nullable|string',
            'ui.text' => 'nullable|string',
            'ui.route' => 'nullable|string',
            'ui.route_active' => 'nullable|string',
            'ui.icon' => 'nullable|string',
            'ui.is_special' => 'boolean',
            'ui.special_classes' => 'nullable|string',
        ]);

        // Handle checkboxes not sent if unchecked
        $validated['enabled'] = $request->has('enabled');
        $validated['show'] = $request->has('show');
        if (isset($validated['ui'])) {
            $validated['ui']['is_special'] = $request->has('ui.is_special');
        }

        $feature->update($validated);
        $this->featureService->clearCache();

        return redirect()->route('admin.features.index')->with('success', 'Feature updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Feature $feature)
    {
        $feature->delete();
        $this->featureService->clearCache();

        return redirect()->route('admin.features.index')->with('success', 'Feature deleted successfully.');
    }
}
