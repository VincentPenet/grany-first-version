/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import './styles/header.css';
import './styles/footer.css';
import './styles/bodyHomePage.css';
import './styles/bodyHomeCatalogue.css';

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

// Back to top auto display
//Get the button
let mybutton = document.getElementById("btn-back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function () {
    scrollFunction();
};

function scrollFunction() {
    if (
    document.body.scrollTop > 20 ||
    document.documentElement.scrollTop > 20
    ) {
    mybutton.style.display = "block";
    } else {
    mybutton.style.display = "none";
    }
}
// When the user clicks on the button, scroll to the top of the document
mybutton.addEventListener("click", backToTop);

function backToTop() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}