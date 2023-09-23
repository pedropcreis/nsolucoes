import './bootstrap';

import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
window.axios = require('axios');

window.Alpine = Alpine;

Alpine.plugin(focus);

Alpine.start();
