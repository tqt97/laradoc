<?php

namespace App\View\Components\Prezet;

use App\Services\Feature;
use Illuminate\View\Component;
use Illuminate\View\View;

class Header extends Component
{
    /**
     * The navigation items for the header.
     */
    public array $navigationItems = [];

    /**
     * The Feature service.
     */
    protected Feature $featureService;

    /**
     * Create a new component instance.
     */
    public function __construct(Feature $featureService)
    {
        $this->featureService = $featureService;
        $this->navigationItems = $this->buildNavigationItems();
    }

    /**
     * Build the navigation items based on the features configuration.
     */
    private function buildNavigationItems(): array
    {
        $features = $this->featureService->getVisibleForLocation('header-left');
        $items = [];

        foreach ($features as $key => $config) {
            $ui = $config['ui'] ?? [];

            $route = $ui['route'] ?? '#';
            $routeActive = $ui['route_active'] ?? $route;

            $items[] = [
                'key' => $key,
                'href' => route($route),
                'isActive' => request()->routeIs($routeActive) || request()->is($routeActive),
                'text' => $ui['text'] ?? ucfirst($key),
                'icon' => $ui['icon'] ?? null,
                'isSpecial' => $ui['is_special'] ?? false,
                'specialClasses' => $ui['special_classes'] ?? '',
                'spanClasses' => $this->calculateSpanClasses($key, $ui),
            ];
        }

        return $items;
    }

    /**
     * Calculate span classes for the navigation item.
     */
    private function calculateSpanClasses(string $key, array $ui): string
    {
        $isActive = request()->routeIs($ui['route'] ?? '#') || request()->is($ui['route_active'] ?? ($ui['route'] ?? '#'));
        $classes = 'absolute -bottom-1 left-0 h-0.5 transition-all duration-300 ';

        if ($isActive) {
            $classes .= 'w-full ';
        } else {
            $classes .= 'w-0 group-hover/nav:w-full ';
        }

        if ($key === 'portfolio') {
            $classes .= 'bg-pink-500';
        } else {
            $classes .= 'bg-primary-500';
        }

        return $classes;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('components.prezet.header', [
            'navigationItems' => $this->navigationItems,
        ]);
    }
}
