<div {{ $attributes }} x-data="{
    showSidebar: false,
    activeHeading: null,
    init() {
        const headingElements = document.querySelectorAll(
            'article h2, article h3',
        )

        // Create an Intersection Observer
        const observer = new IntersectionObserver(
            (entries) => {
                const visibleHeadings = entries.filter(
                    (entry) => entry.isIntersecting,
                )
                if (visibleHeadings.length > 0) {
                    // Find the visible heading with the lowest top value
                    const topHeading = visibleHeadings.reduce(
                        (prev, current) =>
                        prev.boundingClientRect.top <
                        current.boundingClientRect.top ?
                        prev :
                        current,
                    )

                    const link = topHeading.target.querySelector('a')
                    if (link) {
                        this.activeHeading = link.id
                    }
                }
            }, { rootMargin: '0px 0px -75% 0px', threshold: 1 },
        )

        // Observe each heading
        headingElements.forEach((heading) => {
            observer.observe(heading)
        })
    },

    scrollToHeading(headingId) {
        const heading = document.getElementById(headingId)
        if (heading) {
            const headerOffset = 80
            const elementPosition = heading.getBoundingClientRect().top
            const offsetPosition = elementPosition + window.pageYOffset - headerOffset

            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            })
        }
    },
}">
    {{ $slot }}
</div>
