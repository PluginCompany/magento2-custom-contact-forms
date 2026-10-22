# Changelog: Custom Contact Forms for Magento 2

All releases of this extension, newest first. The released versions are commits on `main`, each tagged with its version number (e.g. [`100.17.12`](https://github.com/PluginCompany/magento2-custom-contact-forms/releases/tag/100.17.12)); Composer installs these tags.

Versions marked *(no tag)* were published in the changelog but have no release tag in this repository.

## 100.17.12 — 2022-09-06

- Fixed template filtering issue which occurred when field is pre-filled with product attributes but form is displayed on non-product page

## 100.17.11 — 2022-08-29

- Fix for pre-filling form with product attributes not working in Magento 2.4.3 and 2.4.4. Now both ``{{var product.sku}}`` and ``{{var product.getSku()}}`` notation work properly.

## 100.17.10 — 2022-08-28

- Fixed PHP 8.1 issues related to BCC field string functions in Notification Mailer model
- Fix for Google ReCaptcha element not displaying on front-end
- Fixed PHP 8.1 variable filtering ``{{var ...}}`` bug on front-end form page
- Fixed PHP 8.1 variable filtering bug in e-mail notification functionality

## 100.17.9 — 2022-07-02

- Fix for composer installation issue: Added PHP 8.x support to license manager module. Updated license manager dependency version constraint in composer.json.

## 100.17.8 — 2022-07-01

- Fixed several PHP 8.1 compatibility issues. Verified Magento 2.4.4 compatibility.
- Improved CSS minification enabled detection in admin area

## 100.17.7 — 2021-05-01

- Removed broken CSS reference to glyphicons icon font, which caused admin to randomly log out in some specific setups (encountered on Magento v2.3.6)
- Fix for "Date Only" element not automatically hiding

## 100.17.6 — 2021-04-30

- Fix for "Unable to list current working directory" error when trying to view a form submission in the admin area.

## 100.17.5 — 2021-04-08

- Fix for static file deployment failure when using compact strategy (bin/magento setup:static-content:deploy -s compact)

## 100.17.4 — 2020-12-11

- Re-enabled HTML support for paragraph text, labels and other elements
- Added automatic HTML validation / reformatting functionality for form fields that support HTML
- Fixed issue which caused CSS to not load correctly in Magento developer mode in some cases

## 100.17.3 — 2020-11-25

- Fixed "date only" datepicker element list styling
- Fixed issue regarding "date only" datepicker future dates and disabled days functionality
- Fixed issue which caused form field labels and values to not be saved correctly in some cases when special characters like '"<> are used

## 100.17.2 — 2020-11-16

- Fixed front-end rendering bug introduced in v100.17.1 affecting Magento versions <2.4.0
- Fixed Admin Notification Conditonal Recipients "Partial Match" issue

## 100.17.1 — 2020-10-29

- Fixed pre-filling form with customer variables issue when using Magento 2.4 with FPC disabled
- Fixed pre-filling form with product variables issue when using Magento 2.4. (FPC and no FPC)

## 100.17.0 — 2020-10-20

- Added possibility to select a custom e-mail template for customer and admin notification
- Added plain text e-mail notification template

## 100.16.3 — 2020-10-14

- Fixed issue which caused accented characters to be displayed incorrectly in pop-up form widget button text

## 100.16.2 — 2020-10-08

- Fixed issue causing form field with same labels to be overwritten in submissing overview table

## 100.16.1 — 2020-08-11

- Validated Magento 2.4.x and PHP 7.4 compatibility

## 100.16.0 — 2020-07-29

- Request variable is now available in both e-mail notifications and for prefilling forms. Ex: Get the customer IP by using ``{{var request.getClientIp()}}``, or user agent by using ``{{var request.getHeader('user-agent')}}``

## 100.15.0 — 2020-06-19

- All submitted field data is now available in the front-end success message. Ex: Use ``{{var customer_name}}`` for customer name, ``{{var reference}}`` for submission reference and ``{{var example}}`` to display the contents of submitted field with id "example".

## 100.14.5 — 2020-05-17

- Fixed issue causing forms not to load on the front-end when CSS deferring is used (for example with mod pagespeed)

## 100.14.4 — 2020-05-12

- Fixed some minor CSS minification issues introduced in v100.14.3
- Fixed CSS styling issues when minification is used in Magento admin panel

## 100.14.3 — 2020-05-08

- Added support for minification of dynamically loaded CSS (RequireCSS)
- Workaround for JSrink and moment.js library incompatibility
- Workaround for problem related to AheadWorks OneStepCheckout extension

## 100.14.2 — 2020-04-14

- Added validation functionality for form field ID in Magento admin area form builder
- Removed q.js from CodeMirror library since it randomly causes minification issues when switching Magento to production mode

## 100.14.1 — 2020-03-13

- Fixed "Class argument is invalid" error, causing the form submissions tab not to load in the admin area. Issue occurred when using Magento 2.3.3 with Temando_Shipping module disabled.

## 100.14.0 — 2019-11-29

- Added option to disable specific days of week in date picker element
- Added option to specify a minimal date in datepicker: all dates, today and later or tomorrow and later
- Added aditional form builder element tabs and improved form element categories

## 100.13.2 — 2019-11-28

- Upgraded License Manager package. Fixes issue regarding Magento Page Builder icons missing in admin area.

## 100.13.1 — 2019-11-20

- Added default option support for translated select fields (by prepending a value with '\*')
- All requests except POST requests to form submit URL are now redirected to home page
- Added noindex + nofollow header to form submit URL to prevent indexation by search engines

## 100.13.0 — 2019-11-05

- Improved design of both default admin and customer notification contents
- Admin notification now includes the uploaded files as separate links in the e-mail by default (and also as attachments)
- Customer notification and admin notification now both include submission overview table
- Removed Form Key and Form ID variable from customer notification submission overview
- Removed Form Key from admin notification submission overview
- Removed header and footer shortcodes from default submission contents, these are now added automatically

## 100.12.8 — 2019-11-03

- Fixed Magento 2.3.3 patched and unpatched e-mail sending issues
- Fixed issue regarding e-mail attachment sending in Magento 2.1.x
- Added Magento 2.3.2 and lower e-mail sending backward compatibility

## 100.12.7 — 2019-10-28

- Fixed Magento 2.3.3 Temando_Shipping XML conflict

## 100.12.6 — 2019-10-27

- Bugfix for Magento 2.3.3 e-mail sending issue

## 100.12.5 — 2019-10-25

- Added required field logic for radio buttons unchecked by custom JS

## 100.12.4 — 2019-10-24

- Fixed "Class argument is invalid" error at "Manage Forms" page when using Magento 2.3.3 with Temando_Shipping module disabled

## 100.12.3 — 2019-10-20

- Perfomance fix in form builder for very large forms when multiple store views are enabled
- Fixed Visual Captcha images not loading in Magento 2.2.x which occurred with some specific server configurations with FPC enabled

## 100.12.2 — 2019-10-11

- Fixed date format issue when a sub-locale is used for a specific language. For example en-gb, en-au etc.

## 100.12.1 — 2019-10-08

- Submission reference field (increment ID) is now available in form submission notification contents and subject by using ``{{var reference}}``
- Added global submission ID variable to notification e-mails, which can be displayed by using ``{{var submission_id}}``
- Removed white bar above form submission fields table in admin area form submission page
- Increased form submission overview table column width in notification e-mail

## 100.11.0 — 2019-10-06

- Added new order select field to form builder, which allows logged in customers to select a previous order
- Added new invoice select field to form builder, which allows logged in customers to select a previous invoice

## 100.10.0 — 2019-09-23

- Added form property which can be used to access the current form UI element in custom JS fields. The UI element can be retrieved in the 'Arbitrary JS' fields by using 'this.form'.

## 100.9.4 — 2019-08-15

- Fixed issue where empty form submission would cause error in form submission overview listing in the Magento admin panel
- Some other minor improvements

## 100.9.3 — 2019-07-31

- Added correct currency conversion to the following form pre-filling variables:
- ``{{var product.getFormattedPrice()}}``
- ``{{var product.getFormattedPriceWithoutContainer()}}``
- ``{{var product.getFormattedPriceNoContainerAndSymbol()}}``

## 100.9.2 — 2019-07-28

- Added new product price form field prefilling method: ``{{var product.getFormattedPriceNoContainerAndSymbol()}}``
- Updated form prefilling documentation regarding product variable

## 100.9.1 — 2019-07-28

- Added new product price form field prefilling method: ``{{var product.getFormattedPriceWithoutContainer()}}``
- Updated form prefilling documentation regarding product variable

## 100.9.0 — 2019-07-24

- Added store variable to form pre-filling functionality. This allows you to use the current store view data to pre-fill form fields. For example: ``{{var store.getCode}}`` to pre-fill a field with the current store code.

## 100.8.8 — 2019-07-13

- Fixed RequireCSS pragma syntax issue

## 100.8.7 — 2019-07-12

- Fixed mass action checkbox dissapearing when selecting all records in form submissions listing on edit form page

## 100.8.6 — 2019-07-12

- Fixed images inserted using wysiwyg editor not appearing in customer / admin notification
- Fixed delete form submission mass action not working on edit form page
- Some other code improvements

## 100.8.5 — 2019-07-10

- Bugfix for ConditionsTranslator error which occurred with some forms created with an older version of the extension

## 100.8.4 — 2019-07-10

- Fix for multiple file upload bug which occurred for some specific server configurations only
- Fixed Luma theme RTL dropdown background positioning

## 100.8.3 — 2019-07-09

- Added support for variables and images in success message
- Required star positioning improvement for regular and RTL layout
- Form submission overview grid layout improvement
- Fixed disabled form widget causing 500 error when included on CMS page
- Fixed 500 error on auto-generated form page when form is disabled
- Fix for createAttachment error Magento 2.2.8 & 2.2.9
- Possible fix for multiple file upload bug

## 100.8.2 — 2019-07-04

- Added invisible ReCaptcha position option in admin area config
- Fixed multiple ReCaptcha's on single page issue
- Fixed some issues regarding invisible ReCaptcha
- Some minor improvements and code cleanup

## 100.8.0 — 2019-07-01

- Added support for invisible ReCaptcha V2
- Added translation support for conditional form field select, checkbox and radio elements
- Several bug fixes regarding conditional form fields system both in front-end and admin area
- Fixed e-mail notifications not sending when BCC field contains spaces

## 100.7.6 — 2019-06-15

- Fixed customer data not being prefilled in Magento versions lower than 2.3.x when page cache is disabled

## 100.7.5 — 2019-06-14

- Fixed JSON response message bug when submitting form caused by KnockoutJS / jQuery even binding incompatibility
- This also fixes form validation and empty form submission issues

## 100.7.4 — 2019-05-20

- Moved customer / admin notification content to iframe element in admin area submission view page. This prevents the e-mail notification styles applying to the admin UI.

## 100.7.3 — 2019-04-15

- Updated license manager dependency version in composer.json

## 100.7.2 — 2019-03-29

- Removed accidentally commited test file

## 100.7.1 — 2019-03-29

- Fixed issue where customer specific data was cached when set as default form value with FPC enabled
- Fixed issue which occurred when having a single form embedded as a standard form and popup form on the same CMS page
- Fixed required fields star positioning issue for default theme

## 100.7.0 — 2019-03-21

- Fixed form builder issue when using ultrawide or 4k monitor
- Added range filter for form submission ids and reference
- Added select element filter for form ID on submissions overview page
- Fixed bug causing all form submissions to be exported when doing export from specific form page in the Magento admin area
- Fixed mass delete all Forms / Form Submissions issue

## 100.6.0 — 2019-03-16

- New option to allow accept all file types in upload field by leaving the allowed file types setting empty
- Fixed Magento 2.3 e-mail attachment bug
- Added workaround for bug in Ebizmarts Mandrill extension
- Fix for Pelago Emogrifier bug which occurred during form submission
- Fix for new Magento Commerce PageBuilder WYSIWYG editor bug in admin area

## 100.5.3 — 2018-12-17

- Magento 2.3 e-mail notification sending compatibility fix
- Fixed issue regarding translating dropdown select elements

## 100.5.2 — 2018-11-20

- Removed en_US.csv translation file from module to prevent overwriting when updating

## 100.5.1 — 2018-11-05

- Fixed entry translator error upon form submissions

## 100.5.0 — 2018-10-04

- Added multi-language translation functionality for all form fields and notification e-mails
- Added help text to all elements
- Changed form submission page title
- Performance optimization
- Improved newsletter subscription help text style
- Fixed checkbox issue with 'not equals' conditional form field

## 100.4.4 — 2018-09-13

- Fixed issue which caused newsletter subscription checkbox to not work properly

## 100.4.3 — 2018-09-02

- Fixed missing sticky header title when scrolling down on form submissions page

## 100.4.2 — 2018-08-22

- DropZone JS file upload strings are now translatable
- Added default translation csv file in i18n directory

## 100.4.1 — 2018-08-20

- Fixed issue related to conditional form fields staying disabled when shown

## 100.4.0 — 2018-08-10

- Added CSV export functionality for form submissions
- Added clone / duplicate form functionality
- Added mass delete option to form submission listing
- Added mass delete action to form grid
- Added help text for some fields in form builder, including ID fields and multi-select option fields
- Removed visual captcha namespace strings from form submissions
- Fixed issue where viewing submissions wasn't possible when parent form is deleted
- Fixed issue where conditional form field default value was lost when disabled / hidden
- Fixed required conditional checkbox list validation issue
- Fixed nested conditional form fields issue
- Fixed issue where form components section wasn't sticking when creating new form
- Fixed issue where form components section would jump down when adding a field at the bottom of a form
- Fixed drag & drop issue in form builder when moving mouse quickly in large forms

## 100.3.1 — 2018-07-21

- License manager module update

## 100.3.0 — 2018-07-16

- Added option to disable including uploaded files as attachments in the admin notification e-mail
- New e-mail variable ``{{var uploaded_file_links}}`` which will display all uploaded files as links

## 100.2.1 — 2018-06-13

- Fixed issue where form would break if date range elements were used as a conditional field

## 100.2.0 — 2018-05-23

- E-mail notification submission overview table now uses form field labels instead of IDs
- Default customer and admin notification e-mail content now includes header and footer shortcode

## 100.1.20 — 2018-04-27

- Fixed issue conditional fields validation issue in multi-page forms
- Fixed issue where empty URL suffix would display 'undefined' in front-end url links section of admin form page
- Fixed next button position in multi-page form with labels above fields

## 100.1.19 — 2018-04-17

- Increased size of contact form html and json database fields
- Removed isScopePrivate from blocks to fix compatibility issue with WeltPixel GA

## 100.1.18 — 2018-03-19

- Fix for form not loading in FF when 'Use default store theme' is selected as form theme

## 100.1.17 — 2018-03-16

- Added support for e-mail template header / footer shortcodes. Thanks Eduard for the patch :)

## 100.1.16 — 2018-03-06

- Fixed nested conditional form field issue. Conditional form fields which are disabled are now automatically reset to their default value.
- Added logging to mailing system

## 100.1.15 — 2018-02-27

- Fixed CodeMirror library conflict with JShrink minifier

## 100.1.14 — 2018-02-23

- Moved Javascript initialization to x-init script. This fixes a bug where single quotes weren't allowed in arbitrary form JS.

## 100.1.13 — 2018-02-21

- Fixed issue where viewing and deleting form submissions in Magento 2.2 wasn't working (now fixed properly)

## 100.1.12 — 2018-02-20

- Fixed issue where viewing and deleting form submissions in Magento 2.2 wasn't working
- Fixed required upload field issue
- Fixed issue where single allowed extension upload field didn't work properly

## 100.1.11 — 2018-02-19

- Upload field now shows nicely formatted error if server file upload size limit is reached
- Changed upload field success checkmark color to green and error cross color to red

## 100.1.10 — 2018-02-19

- Uploaded files are now attached to the admin notification e-mail

## 100.1.9 — 2018-02-07

- Fix for product variables not working when cache is enabled

## 100.1.8 — 2018-02-07

- Fix for customer variables not working when cache is enabled

## 100.1.7 — 2018-01-31

- Added validation error message to inline checkbox element

## 100.1.6 — 2017-10-31

- Fixed compatibility issue with official SendGrid extension

## 100.1.5 — 2017-10-30

- Reply-to e-mail bug fix for admin notification
- JS / CSS minification code improvement

## 100.1.4 — 2017-10-17

- Magento 2.2 conditional admin recipient bugfix

## 100.1.3 — 2017-10-11

- Porto theme bad JS design workaround

## 100.1.2 — 2017-10-11

- Magento EQP refactoring
- Fixed issue regarding special UTF-8 characters in form submission

## 100.1.0 — 2017-09-25

- Magento 2.2 compatibility fixes

## 100.0.9 — 2017-09-16 *(no tag)*

- Fixed JS bundling issue
- Fixed JS minification issue
- Fixed CSS minification issue

## 100.0.8 — 2017-09-11

- Added submission overview variable to customer notification
- Fixed form submission bug when only customer notification is enabled

## 100.0.7 — 2017-09-05

- Fixed undraggable fields form builder issue

## 100.0.6 — 2017-09-02

- Fixed FireFox form builder issue

## 100.0.5 — 2017-08-31

- Small bug fixes

## 100.0.4 — 2017-08-31

- Small bug fixes
- Modified composer file

## 100.0.3 — 2017-08-24

- Fixed code compiler issues

## 100.0.2 — 2017-08-23

- Bugfix regarding conditional form fields in admin area

## 100.0.1 — 2017-08-20

- Improved ACL permissions description
- Bugfix regarding required select input with empty element

## 100.0.0 — 2017-07-01

- First release of Magento 2 Custom Contact Forms extension by Plugin Company
