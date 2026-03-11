<svg viewBox="0 0 80 80" xmlns="http://www.w3.org/2000/svg" {{ $attributes }}>
    <!-- Modern Geometric T -->
    <rect width="80" height="80" rx="16" fill="#f97316"/>
    <path d="M25 25H55M40 25V55" stroke="white" stroke-width="10" stroke-linecap="round"/>
    <!-- Blinking Cursor -->
    <rect x="50" y="52" width="12" height="4" fill="white">
        <animate attributeName="opacity" values="1;0.2;1" dur="1s" repeatCount="indefinite" />
    </rect>
</svg>
