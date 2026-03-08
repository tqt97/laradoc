import './bootstrap';

import Alpine from 'alpinejs'
import focus from '@alpinejs/focus'
import zoomable from '@benbjurstrom/alpinejs-zoomable'
import 'lite-youtube-embed'

window.Alpine = Alpine

Alpine.plugin(focus)
Alpine.plugin(zoomable)

Alpine.start()
