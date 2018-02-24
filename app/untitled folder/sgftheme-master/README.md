Space Games Federation Theme

This theme is a modified version of the Keynote Theme with custom modifications and a NodeJS development environment using gulp for SASS, JS minification and browser sync.

After copying this theme into a local development environment (assuming you have nodejs installed on your machine), npm install this theme.

Modify Line 1 in gulpfile.js to the path to your local machine.
from the command prompt (pathed to the theme directory) type gulp, which which will launch the gulp process so that
1. SASS will compile from the app/sass/ directories. See style.scss for structure
2. JS will be compiled and minified
3. Will connect all browser via browsersync and refresh the browsers on save, and alert you to syntax errors.

If using MAMP/XAMPP, it is recommended to set the path to the file to be available over the LAN so that additional devices can connect for testing purposes.

Make sure to also set the wp-config file to use
define('WP_HOME','your local url:port');
define('WP_SITEURL','hyour local url:port');
