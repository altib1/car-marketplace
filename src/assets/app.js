// assets/app.js
/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';

// Import modules
import { initializeFormHandlers } from './js/modules/form-handlers';
import { initializeBackToTop } from './js/modules/back-to-top';
import { initializePhoneToggle } from './js/modules/phone-toggle';
import { initializeFileUpload } from './js/modules/file-upload';
import { initializeChatModal } from './js/modules/chat-modal';
import { initializeImageSlider } from './js/modules/image-slider';
import { initializeConversation } from './js/modules/conversation';
import { initializeCars } from './js/modules/cars';
import { initializeLocation } from './js/modules/location';
import { initializeShop } from './js/modules/shop';
import { initializePublications } from './js/modules/publications';

// Initialize all modules when DOM is ready
initializeFormHandlers();
initializeBackToTop();
initializePhoneToggle();
initializeFileUpload();
initializeChatModal();
initializeImageSlider();
initializeConversation();
initializeCars();
initializeLocation();
initializeShop();
initializePublications();