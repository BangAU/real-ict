# Changelog

All notable changes to this project will be documented in this file.
## [2.9.25] - 02/02/2021
### Dev
	- Integrate Tribe Event to the hicaliber event module/plugin.
	- Added default Map API key when there is no MAP API key supplied on Site Settings.
	- Added function get_all_elements() to get all available elements.
	- Added function is_element_exists() to check if an elements is exist and available.
	- Added Display option for Team Element.
### Tweak
	- Update dump.sql file
### Enhancement
	- Hide all non available Elements on CPT Archive Post Type Selection

## [2.9.24] - 28/01/2021
### Dev
	- Allow the usage of content builder element using default template on home page.
	- Added Select Search filter to CPT Archive location listing element.
	- Added hide-carousel-dots and show-carousel-arrows for carousel elements that have shown dots and hidden arrow by default.
### Fix
	- Fix issue carousel position when there is dots.

## [2.9.23] - 23/01/2021
### Dev
	- Added ability to add "initial number of item" to load of "button_filter" shortcode loadmore and also added ability to add "number of item" to load when the loadmore button is clicked.
### Fix
	- Fixes all the issues on "button_filter" shortcode.
### Tweak
	- Remove front-page.php template to allow using CPT Archive and Page Content Builder page template on homepage.

## [2.9.22] - 22/01/2021
### Dev
	- Added option "all" for Listing type and Price type of on property listing CPT Archive Element.
	- Added Button label settings for Team Listing
	- Added custom column name and featured on testimonial CPT
### Fix
	- Fix issue on carousel dots when there are too many slides.
	- Fix issue on Header transparent sticky header background when scrolled

## [2.9.21] - 20/01/2021
### Dev
	- Added the Site Settings to Admin Bar.
	- Added default style for property single page map custom controls.
	- Added category as option to display on property listing element.
### Fix
	- Fix issue hero video not able to play on apple mobile.
### Tweak
	- Change listing element class name 'blurb' to 'hic-blurb'.
	
## [2.9.20] - 15/01/2021
### Dev
	- Business style general update.
	- Added Customize Top Header Colours to enable background and text colour customization.
### Fix
	- Fix issue on location module not able to list locations when franchisee is disabled.
	- Fix issue on Post Element showing the same date, author and category list for each item.
	- Fix PHP issue on the code to check font family on the site settings.
	- FIx Location Map Issue on Place Search filter and fix the issue on map which not able to display info window.
### Tweak
	- Change Top Header Background and Text Colour to Color Picker field.
	- Update SQL Dump file.

## [2.9.19] - 11/01/2021
### Dev
	- Added 'Text/Description', 'Headline', and 'Suburb' as option in "Content to display" on Page Element and CPT Archive.
	- Added 'Suburb' as option to display as 'title' property listing.
### Fix
	- Remove 'page-banner-hidden' class to fix single property page styling when hero layout is "layout-4".

## [2.9.18] - 08/01/2021
### Dev
	- Remove scrollTop on mobile when clicking isotope button nav.
	- Added Category to property listing and adjustment page element, and cpt archive.
	- Added layout display options like image-above-content, image-overlay-content, etc on property listing page element.
	- Added options to choose the content to display between address, price, meta details and button on both property listign page element and cpt archive.
	- Added Grid layout to CTP Archive of Property Listing front end section classes
### Tweak
	- Update SQL Dump file of the clone copy.

## [2.9.17] - 05/01/2021
### Dev
	- Add scrolled on body class when scrolled is already added before the reload
	- Added `button_filter` shortcode to display custom isotope nav.
### Fix
	- Fix button label error on Project CPT listing.
	- Fix header submenu menu item color styling on hover state.
	- Fix issue on Global Element on Site Settings which shows unselected element from site settings on the global element element list.
### Tweak
	- Change all carousel related class helper name from slider to carousel.
### Enhancement
	- Refactor hicaliber-script.js - eliminating node js error and warnings.

## [2.9.16] - 18/12/2020
### Dev
	- Added vertical carousel class helper
	- Added top header background and text color option.
### Fix
	- Fix issue on location user saving html and script tag which are being filtered.
	- Fix mobile menu drowdown arrow styling adding more width and height to the arrow to make it more easier to click.
	- Fix secondary header theme which is not working.
	- Fix issue on sticky header issue responsive
	- Fix issue on 'max number of post' field not accepting -1 as indication to display all post. This is now change to just blank instead.
	- Fix CTA Layout 2 and 3 which are not working

## [2.9.15] - 08/12/2020
### Fix
	- Fix the code to display woocommerce product prices using the old woo_money_format function of PRODUCT_VIEW object. The function can now return html version of the price format but can only return the old format without html by setting second parameter to false.
### Tweak
	- Change Modal Element layout full-screen-layout to two-column-layout and use the full-width width element to trigger a full screen layout.
### Enhancement
	- Post CPT pagination improvement - remove js pagination
## [2.9.14] - 03/12/2020
### Dev
	- CPT Posts - Added List to Category Filter option. This will display all categories of posts that will filter post by selected category.
	- Added option for scroll reveal animation enqueue script
	- Added Category Filter to Location Map
	- Added `order` attribute to sitemap shortcode
### Enhancement
	- Optimise platform, refactor javascripts & 3rd party js library
## [2.9.13] - 02/12/2020
### Dev
	- Make the Quantity options and functionality works
	- Added wishlist total table and style responsive of wishlist tables
	- Display sub total of each product multiplied by qty and display total
	- Added ability to populate product list for wishlist multiple product enquiry
	- Added animation effects on wishlist update
	- Added options to control multiple product enquiry modal
### Fix
	- Fix issue on Custom Menu Area showing cart and wishlist shortcut after the menu
## [2.9.12] - 30/11/2020
### Dev
	- Added Code Element to Page Content Builder
	- Added header, footer and design option for wishlist listing
	- Added Table layout option on Wishlist listing element, making the design similar to Woo Cart
	- Added Quantity option to Wishlist listing when using table layout.
### Fix
	- Fix issue on Wishlist shortcut not displaying on mobile and tablet.
### Tweak
	- Removed Wishlist Sample Request functionality.
## [2.9.11] - 27/11/2020
### Dev
	- Disable location archive page.
	- Change Location CPT label to Location Details for Location User.
	- Update Location, Location Posts, Location Pages admin view count based on the number of post they can see.
	- Allow Location User to edit their own location CPT.
	- Added options for wishlist listing layout and content options
	- Added Options to organized wishlist shortcut, and wishlist page
### Fix
	- Fix issue on Content Box showing hic-content container eventhough there is no content.
	- Fix issue on Content Box video not showing not able to override video image with the image set on the content box image field.
	- Restructure Wishlist product listing
	- General Fixes and code update on Wishlist 
	- Fixes conflict between Cart and Wishlist shortcut 
	- Fix styling issue for on sale products and related products listing issues
### Tweak
	- Removed has-woo-cart class on header, the styling would be based on the adjacent element as the cart can be place on either header or top header.
	- Reorganized  Product Settings field for Cart and Wishlist
### Enhancement
	- Allow NULL for form selection field on Map Form Element
## [2.9.10] - 03/11/2020
### Dev
	- Added slug option for location, location post, and location page.
	- Removed Search Optiona and Added option to customize header menu area.
	- Added Modal Layout and Design option.
	- Added Second Content Options on Modal Element to display two column modal.
### Fix
	- Recover openning hours fields
	- Fix undefine variable issue on modal element.
	- Fix gallery single page layout.
## [2.9.09] - 28/10/2020
### Dev
	- Added datas, disable_html, separator, and widget parameter on location_contact shortcode to work the same as contact_info shortcode.
	- Added ability to add social media on each location.
	- Added shortcode location_social_media to diplay location social media anywhere on the site.
	- Added location page and allow location menu customization.
	- Added a new layout `two-column-accordion` for accordion element.
	- Added shortcode for Location News listings
### Fix
	- Remove cta and event details on location details and gallery content group which are not not used at all.
	- Fix issue on location page logo link and contact phone and menu which shows the main pages data
	- Remove ability to add parent to Location Post as this is not needed.
	- Fix Image Left Accordion and Image Right Accordion Layout of Accordion Element issue
### Tweak
	- Update Accordion Element Layout classes `content-left` to `content-left-accordion`, `content-right` to `content-right-accordion`, `layout-1` to `image-left-accordion`, `layout-2` to `image-right-accordion`
## [2.9.08] - 26/10/2020
### Dev
	- Added Lightbox for Gallery - Post Type Display
	- Added Map Design Code 2 for location layout 2
	- Added Location URL Rewrite Rules for Location, Locatin Post, and Location Post Archive Pages
	- Allow SVG File Upload
### Fix
	- Global Element Advance Settings issue - Displaying even Global Element is not selected
	- Fix Gallery Category Page Content Builder
    - Fix Gallery count on frontends
	- Fix issue on CPT Archive not able to display shortcode
	- Fix Event Element undefined variable issue
	- Fix issue on Product Element Gallery Option not able to display gallery and fix zoom icon styling issue
## [2.9.07] - 20/10/2020
### Dev
	- Added Back to Top button option on Site Setting Footer as well as in Location Settings Custom Footer.
	- Added Opening Hours to Location Details.
### Fix
	- Fix underfine variable error on post single category page
	- Fix issue on button element having wrong phone value
	- Added default value for title location to fix issue on post title location affecting location post
### Enchancement
	- Remove white spaces on page element/global element container of cpt archive, single location, single location post and single post to make it easier to check if the container is empty.
	- Remove white spaces on post byline template to make it easily to check if the container is empty.
## [2.9.06] - 16/10/2020
### Dev
	- Added gravity form field helper classes for responsive display.
### Fix
	- Fix issue on gravity form radio and checkbox button where the text should be aligned on the left.
	- Fix issue on Video Banner not able to pull background overlay colour value.
### Tweak
	- Change field-left and field-right with the new gravity form field responsive class field-medium-6 but both class will still work.
## [2.9.05] - 15/10/2020
### Dev
	- Added Title Position on Post Single Page when Banner is disabled.
	- Added Element Width on CPT Archive
	- Added Category List Filter
	- Added class exist checking for hicaliber-theme-hero
### Fix
	- Fix element width not being added to element section classes issue on most of the element
	- Fix element width issue on post module elements
	- Fix issue on Header and Footer of Location and Location Post Pages
	- Fix issue on Content Box classes "has-image", "has-video", and "has-gallery"
	- Fix issue on location element grid not pulling all website details label
	- Fix issue on location register_rest_route issue
## [2.9.04] - 12/10/2020
### Dev
	- Added Global Element Options Override for Content Box
### Fix
	- Fix Post element to pull the element width option
	- Fix CTA element to pull the element width option
	- Fix Form element to pull the element width option
	- Refix large-2_4 styling affecting mobile and tablet
	- Fix styling of Map Form Element layout 4 on tablet, where map is overlapping on the form.
	- Fix responsive issue on footer menu and bottom footer
	- Fix responsive issue on header that caused by sticky header
	- Fix styling issue on Form consent field validation message and style validation message color when there is image background
	- Revert back the old location url structure as this still have issue when a location doesn't have category
	- Fix the issue on property and design single listing modal not filling the property name, id, and url field
	- Fix the undefine variable error on location element
### Tweak
	- Update theme sql dump file for theme.hicalibertest.com.au Settings update
## [2.9.03] - 02/10/2020
### Dev
	- Added Location Post Archive Template (No Settings for now)
	- Added new helper class slider-adaptive-height to make a carousel height changes on slide
### Fix
	- Fix JS issue on Location Map when lookUpLocation field is not displayed or is null
	- Fix all element not showing (has-image,has-video,...) classes affecting split layout content boxes
### Tweak
	- Move flex-image-height to base stylesheet to be able to use on any theme.
	- Change disable-carousel-for-large class helper to disable-slider-for-large.
	- Change carousel-center-mode class helper to slider-center-mode.
### Enchancement
	- Allow toggling classes to button shortcode.
	- Allow adding id to location_detail shortcode to specify the location the data will be pull from.
## [2.9.02] - 30/09/2020
### Dev
	- Added new helper class inline-choices to make checkbox or radio choice inlined
	- Added new shortcode attribute 'model' to content_box to specify the content box model
	- Added new shortcode attribute 'type', 'box', 'button_text', and 'result_to_show' to recent_posts shortcode to change post type and allowing the usage of content box structure and allow choosing the row number of the result.
	- Added Location Post Setting for Sidebar and Single Page with Element Builder
### Fix
	- Fix issue on Testimonial Video play icon showing even there is no video.
	- Fix styling of gfield radio to be circle and fix margin
	- Fix issue 5 per row on gallery element when have disable-carousel-large helper.
### Enchancement
	- Update Team Location field to access more than one location.
	- Center Map marker on location single page by default.
## [2.9.01] - 25/09/2020
### Dev
	- Added new user location user with restriction and ability to update/delete assigned location post only
	- Added new class helper whitescale-images to display image icon as white
### Fix
	- Fix location permalink issue causing pages to return 404 error (temporary fix) but reverting the url structure of location post
	- Fix issue with shortcode hic_set_post_title prepend attribute
	- Added css for large-2_4 on the base stylesheet fixing issue on 5 column grid layout
### Enchancement
	- Enhance contact_info shortcode, allowing to organize and display specific/all site contact info on the page and allowing the info in plain with seperator for each.
## [2.9.00] - 23/09/2020
### Dev
	- Added new shortcode Sitemap to display Page or CPT sitemap
	- Added Footer Button on Page Content Element
	- Added new options to choose filter type for Team Element
	- Added dropdown filter type to Team Element
### Fix
	- Fix Link a Location field not showing on team CPT.
	- Fix Google Map JS issue for initMap function callback.
### Tweak
	- Rewrite Location CPT permalink to location/%location_category%/%location_name% and location/%location_name% if no category
	- Rewrite Location Post CPT permalink to location/%location_category%/%location_name%/%post_name% and location/location_post/%post_name% if no selected location
## [2.8.99] - 22/09/2020
### Dev
	- Added the Element Width to Page Content Element
	- Added Category filter for Team Element
	- Added Location field on team cpt and add location filter for Team Element
### Fix
	- Remove realty logo as footer default logo and change to the same logo as header.
	- Fix issue on property listing and design listing carousel conflicting with the theme carousel
	- Fix Location structure removing the second section-body class and grid class
	- Fix Styling of Category filter (isotopenav)
### Enchancement
	- Enhance Isotype script to be generic, allowing multiple isotype navitation element.
## [2.8.98] - 21/09/2020
### Dev
	- Added full-col-for-medium class helper
	- Added xsmall-container class helper
	- Added theme-boxes class helper
	- Added page-element-layout.php that can be use to clone element layout.
### Tweak
	- Change disable-carousel-large class helper to disable-carousel-for-large
	- Change box-equal-height class helper to content-equal-height
	- Change hic-pricing-table class helper to box-equal-height
	- Change horizontal to inline-list class helper
	- Move white-titles, white-boxes, grey-boxes, box-shadow, box-border, image-above-content-for-medium, two-col-for-medium class helper to base stylesheet.
### Fix
	- Fix header menu alignment issue
	- Fix Contact info responsive with one column layout
## [2.8.97] - 17/09/2020
### Dev
	- Added content_box shortcode to display single content box
	- Added new shortcode menu to display any menu anywhere on the page
	- Added new shortcode location_detail to display specific location detail on any location and location post single page
	- Added new Option Element Width Settings for Content Box Element to allow changing width to default, small, medium, large, and full
	- Added Enable Single Page option on Testimonial module
	- Added Custom Slug setting for testimonial CPT
	- Added Single Page Element Builder on Testimonial
### Tweak
	- Change contact-info shortcode to contact_info
	- Change social-media shortcode to social_media
	- Change htw-map shortcode to location_map
	- Change post-title shortcode to post_title and its attribute first-worrd-only to first_word_only
	- Change team-social-media shortcode to team_social_media
	- Change hic_footer_logo shortcode to footer_logo
	- Change select-post shortcode to post_select_field
	- Change hic_posts shortcode to recent_posts and its attribute post_per_page to limit
	- Remove unused and outdated shortcode ht-gallery, ht-gallery-album, ht-testimonials, and set-content-boxes
### Enhancement
	- Remove modal shortcode and enhance button shortcode to display modal button
	- Added prepend attribute to post_title shortcode to add text at the beginning of the title
## [2.8.96] - 15/09/2020
### Update
	- Add Page Element Builder for Location Single Default Template
	- Add has-image on map preview image
## [2.8.95] - 15/09/2020
### Update
	- Fix issue on map preview image
## [2.8.94] - 15/09/2020
### Update
	- Added map preview option on location settings to choose large and small info window
## [2.8.93] - 14/09/2020
### Update
	- Fix issue on location menu which is not overriding
## [2.8.92] - 14/09/2020
### Update
	- Added [location-detail] shortcode to get basic location basic info (currently support to get location title, contact and email) from location and location post pages.
	- Added button shortcode
	- Override contact details of location single page
## [2.8.91] - 14/09/2020
### Update
	- Location module update, ability to override location and location post single page footer and header.
	- Attached single location layout to Single location post
## [2.8.90] - 14/09/2020
### Update
	- New Location Post CPT (can only enable from Location Settings). This Post is linked to a Location. The update is not yet complete.
	- Added Header, Sidebar, Single Page Banner, and Footer Options on Location Settings. This settings will override Site Settings on Location and Location post settings.

## [2.2.7] - 24/02/2020
### Update
	- 2.2.4 - 2.2.69 General Updates
	- Fixed Issue with Editor User Site Settings Fields

## [2.2.4] - 24/02/2020
### Update
	- Styling Updates - Base Theme & Business Theme

## [2.1.96] - 24/02/2020
### Update
	- Styling Updates - Banner responsive / Slick slider issue / and other small issue on mobile

## [2.1.95] - 24/02/2020
### Update
	- Small Updates

## [2.1.94] - 24/02/2020
### Update
	- General updates - Single Post & CPT Archive Post Sidebar Fixes, Page Hidden Banner Fix, Styling Fixes for Base, Busines and Modern
	- Minor Code refactor

## [2.1.92] - 19/02/2020
### Update
	- General updates - Gallery, Header, Minor Styling Fixes

## [2.1.91] - 19/02/2020
### Update
	- General updates - Hero, Stylesheets, Page Element Grid Layout

## [2.1.8] - 19/02/2020
### Added
	- Post Selection Shortcode [select-post type="location" label="Choose Your Training" placeholder="Select Preferred Location"]
### Update
	- Hero Banner Structure Updates 45%

## [2.1.7] - 18/02/2020
### Update
	- Location Map Fixes
### Added
	- Location Fields (Contact person,position,email & avatar)

## [2.1.5] - 17/02/2020
### Update
	- Location Module Fix
	- Hero Banner Form Options Adjustments

## [2.1.3] - 14/02/2020
### Update
	- Merge Accordion and FAQ Element
	- Footer Menu Fixes (Footer Menu 4)

## [2.1.2] - 15/02/2020
### Added
	- Content Box Tabs Layout

## [2.1.0] - 14/02/2020
### Update
	- Footer Styling

## [2.0.9] - 14/02/2020
### Remove
	- footer.scss
### Update
	- Contact Form Element links color with background

## [2.0.8] - 14/02/2020
### Remove
	- TGM Plugin Activation (This theme recommends...)
### Update
	- Contact Form Element - Header section

## [2.0.7] - 14/02/2020
### Remove
	- Google Analytics on Install Plugins

## [2.0.6] - 14/02/2020
### Update
	- Refine Clone Copy

## [2.0.1] - 02/2020
### Born