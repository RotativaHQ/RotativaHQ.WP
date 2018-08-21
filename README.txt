=== Rotativa.HQ PDF Generator ===
Contributors: rotativahq, ratkosolaja
Donate link: https://rotativahq.com/
Tags: html, pdf, cloud
Requires at least: 4.7
Tested up to: 4.9.8
Stable tag: 1.2.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Convert HTML to PDF in the cloud in a extremely easy and fast way.

== Description ==

Rotativa WP plugin enables you to convert HTML to PDF in the cloud in a extremely easy and fast way.
Main features:
1. Easy to Use - Convert HTML or URL to PDF with a click of a button.
2. Works Everywhere - Create PDF from five endpoints in four continents: Europe, US East, US West, Southeast Asia, Australia East.
3. Made for Cloud - Our systems are based on Microsft Azure. Optimized for Azure Web Apps (Websites).
4. Always On - Our infrastructure complies with Azure SLA requirements to achieve at least 99.95% availability.
5. Best Performance - A dedicated communication protocol and smart leverage on the best Azure resources yield top performance in creating PDF files. Most PDFs are served in under 1 second.
6. Secure - Every aspect is secured by 2048 bit SSL encryption. Users download PDF files directly from one of 4 different Azure Storage data centers in a secure and private way.
7. Developer Friendly - There is no need to use absolute URL in web page components (img, css, font). Creating PDF files on local machine is transparent.

== Installation ==

They are two ways we can go about this: Using the **WordPress Plugin Search** or **Using the WordPress Admin Plugin Upload**.

Using the WordPress Plugin Search:
1. Go to WordPress admin area.
2. Click on Plugins > Add New.
3. In the Search box, type in **Rotativa** and hit enter.
4. Next to the Rotativa click on the **Install Now** button.
5. Click on **Activate Plugin**.

Using the WordPress Admin Plugin Upload:
1. Download the plugin here from our plugin page.
2. Go to WordPress admin area.
3. Click on Plugins > Add New > Upload Plugin.
4. Click on Choose File and select **rotativa.zip**
5. Click on Install Now button.
6. Click on Activate Plugin.

== Frequently Asked Questions ==
1. Do you have a shortcode for frontend usage?

   Yes, we do. It's **[rotativa-generate-pdf]**
2. Does your shortcode accept any attributes?

   In fact, it does - it accepts **ID** and **label**. Example:
   [rotativa-generate-pdf id="300" label="Generate PDF"]

== Screenshots ==
1. Post/Page or any Custom Post Type screen where Rotativa is enabled.
2. Modal opened when clicking on the "Generate a PDF" button where you can customize the output PDF.
3. Success alert and button that upon click event prompts you to save the PDF to your local machine.
4. Settings screen for Rotativa plugin where you can configure Rotativa in numerous ways as well as choose your Endpoint Location.

== Changelog ==

= 1.2.3 =
* Fixed various bugs.

= 1.2.2 =
* Fixed a bug where sweetalert2 wasn't loading on frontend.

= 1.2.1 =
* Fixed a bug where shortcode wouldn't accept the ID attribute.

= 1.2.0 =
* Added ability to change the styling of the frontend button (border, margin, padding, background color and text color).
* Removed the "Southeast Asia - Singapore" API Endpoint Location.
* Added new shortcode attribute (label) so you can change the label of the button.
* Updated template for translations.

= 1.1.1 =
* Fixed a bug in admin area where html would be escaped and not render the anchor tag.

= 1.1.0 =
* Introducing a **new feature** - now you can place a shortcode in your template with which your users can generate a pdf of that page themselves. You can use this shortcode: **[rotativa-generate-pdf]**
* Updated sweetalert2.
* Updated codebase with a prefix "rotativa".

= 1.0.0 =
* Initial release.
