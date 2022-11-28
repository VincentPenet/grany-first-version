/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// start the Stimulus application
import './bootstrap';

// Importing Compiled CSS Bootstrap
import 'bootstrap/dist/css/bootstrap.min.css';

//  import plugins individually
import 'bootstrap/js/dist/dropdown';
import 'bootstrap/js/dist/util';

// Importing font awesome
import '@fortawesome/fontawesome-free/js/all';

const imagesContext = require.context('../public/images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);

const logosContext = require.context('../public/logos', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
logosContext.keys().forEach(logosContext);