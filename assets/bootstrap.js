// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);

import { Application } from '@hotwired/stimulus';
import { Chart } from 'chart.js/auto';

// Initialize Stimulus application
const application = Application.start();

// Register Chart.js
window.Chart = Chart;
