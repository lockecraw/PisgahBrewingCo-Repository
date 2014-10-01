=== Google News Just Better ===


Contributors: stefsoton


Donate link: http://www.stefaniamarchisio.com/donations/


Tags: RSS, Atom, feed, XML, syndication, syndicate, syndicating, Google News, Googlenews, news, widget, shortcode


Author URI: http://www.stefaniamarchisio.com


Plugin URI: http://www.stefaniamarchisio.com/google-news-widget-shortcode-plugin/


Requires at least: 2.8


Tested up to: 3.4.1


Stable tag: 1.4





A customizable list of Google News given: language & country code, keyword(s) or topic, cache recreation frequency, number of items to display. It also let you choose if you want to publish an excerpt, date, time and the author. 





== Description ==





Important Note: This plugin still works at this time (wp version 3.4.1) but wont be maintained any longer. Please uninstall it and use [RSS just better](http://wordpress.org/extend/plugins/rss-just-better/) instead which covers the same functionalities and offers a few extra customizations too.





It displays the list of the latest news by Google News given localization (country-language), search word(s) or topic, number of displayable news and whether you want publication date, date, reference to the author displayed/not. The look & feel is customizable too. It works as a widget or shortcode.


Starting from version 0.7 - for Us and Canada (eng), it's also possible to display local news by selecting city, state/province or zipcode [ Courtesy of Greg at transientmonkey.com(transientmonkey.com) ]





== Installation ==





1. From Plugins->Installed of your wordpress administration, select "Add new", search for "google news just better" into the search text-box then click on 'Install' on the right when prompted with this plugin





                                    OR





2. Download this plugin from [wordpress repository](http://wordpress.org/extend/plugins/google-news-just better/), unzip it (a directory with 2 files will be extracted) and upload it to the '/wp-content/plugins/' directory of your wordpress





3. Activate the plugin through the Plugins->Installed menu in your WordPress administration





4. See Usage (in Other Notes) for how to configure it





== Frequently Asked Questions ==





= Why the heck would I need/want it?





= Well, it provides the latest news on any subject you want to choose in real time: can you imagine what boost of traffic can it bring to your blog? Let's pretend you write about volleyball, knitting or lactose-intolerance. You just need to enter the relevant words in the Keyword(s) field or select a topic and wait for google to display the latest news on your subject.





= Hey, I cannot find any configuration page in 'Settings' How does it work?





= As a widget, you drag & drop the widget to any widget-ready area of your theme; open and complete the widget form, and click on 'Save' button. As a shortcode, you add/edit the post/page you want the news to be displayed into - IN HTML MODE! - and enter your shortcode as explained below in Usage "[gnews..."


  





== Screenshots ==





1. Widget Form explained.





== Changelog ==





= 1.4 = 





* Changes: Attempt to fix a problem which makes the download happening continuously.



= 1.3 = 





* Changes: readme.txt file changed solely to inform about the retirement of this plugin in favour of RSS just better which does the same functionalities and more.





= 1.2 = 





* New feature: the user is able to set the cache refresh time both in the widget form and the shortcode





* Change: Copyright set to 2012


* Change: Replaced old email address (mywizardwebs@) with new (stefonthenet@)


* Change: Added the plugin version number in the "Powered from" line at the botton


* Change: Renamed plugin from Google News Widget/Shortcode to Google News Just Better


* Change: Author URI, Plugin URI added to readme.txt file


* Change: formatting topic and keyword(s) (now on the same line)


* Change: "sport" (as default keyword removed from keyword(s) textbox in widget form


* Change: List of Google News location set to 12 Nov 2011 (last time check)


* Change: Topic Science/Technology has been split into Science and Technology (2 topics) by Google itself.


* Change: Improved description of sample shortcode





* Fixed bug: Boolean variables were not properly tested and caused some inconsistent views when used as a shortcode





= 1.1 = 





* New feature: forced feed cache to refresh every 30 minutes instead of the default 12 hours


* New feature: made it (hopefully) compatible with XHTML1.0 by writing all tags and attributed in small letters


* Changed feature: fetch_feed function is called to catch the feed instead of simplexml_load_file. Some users were unable to use this last PHP 5 function on their own webserver. (http://php.net/manual/en/function.simplexml-load-file.php)





* Fixed bug: incorrect links to feed URLs in shortcodes were generated





= 1.0 = 





* New feature: Made titles linkable for shortcodes too


* Change feature: Added a feed small icon linking to its feed URL (instead of linking to the title directly)


* HTML tags are now stripped from the description to make the mouseover experience more meaningful 


* Fixed a bug which prevented the title to be linkable





= 0.9 = 





* Fixed a bug (introduced in 0.8) which showed the widget title twice


* Amended the 0.7 changelog/Upgrade notice as a few changes were forgotten





= 0.8 = (never released. used to test the bug-fix)





* Fixed a bug which prevented non-standard chars to be displayed properly





= 0.7 =





* New feature: added selection of local news (working for Usa and Canada English only)


* New feature: Made the widget title linkable to the feed URL


* Added proper error messages for: empty, non-existing URLs and invalid/misformatted feeds content


* Added defaults for target and list (widget fields)


* Added instruction to hide Warnings from the xmlsimple_load_file function


* Fixed a bug which prevented proper display of description/summary with tags


* Made it fully compatible with RSS standards where link and title might be omitted


* Used the native PHP class simpleXML instead of the Wordpress feed parser (Magpie)





= 0.6 =


* added show/not excerpt and how many chars of it to the widget form/shortcode


* fixed view of certain foreign countires in the widget's "Localization" drop down menu


* updated readme.txt, fixed formatting





= 0.5 =


* added show/not publication time to the widget form/shortcode


* added show/not plugin's author to the widget form/shortcode


* updated readme.txt and fixed links and some formatting





= 0.4 = (never released. used to test the bug-fix)


* fixed a which prevented working in admin for certain wp installations 


* added show/not publication date to the widget form/shortcode





= 0.3 =


* fixed Plugin Home directory in the plugin file header (google-news-widget.php)





= 0.2 =


* added topic, list and target to the widget form/shortcode


* fixed a bug which prevented to show news, if no search-word was defined


* enabled a shortcode version (to add news to posts/pages)


* updated readme.txt file


* updated description in the php file (made consistent with readme.txt)


* introduced donation page





= 0.1 =


* First release of google-news-widget





== Upgrade Notice ==





= 1.2 =





= 1.1 = 





= 1.0 =





= 0.9 =


* Non-standard chars are properly displayed 





= 0.8 =


 * Never released. Used internally for tests.





= 0.7 =


* New feature: added selection of local news (working for Usa and Canada English only)


* New feature: Made the widget title linkable to the feed URL


* Added proper error messages for: empty, non-existing URLs and invalid/misformatted feeds content





= 0.6 =


* if you want to show the excerpt of the news or cannot see your country/language in localization, then upgrade it.





= 0.5 =


* if the previous version (0.2 or 0.3) prevented you from working into the administration page then please upgrade it.





= 0.5 =


* if the previous version (0.2 or 0.3) prevented you from working into the administration page then please upgrade it.





= 0.4 = 


* Never released. Used internally for tests.





= 0.3 =


* just an upgrade due to a wrong link to the pugin homepgae





= 0.2 =


* if you want to avoid to enter a keyword or want to show news by-topic or in a post/page then download it. It also allows some list customizations.





== Other Notes ==





As a widget:





* Drag & Drop your widget in the widget-ready area of your choice;


* Choose a title to be given to your news list (optional);


* Tick off the box if you want your title to be linked to the correspondent feed URL (optional);


* Localize your news (language/country) (mandatory, default: us);


* If you live in the Usa or Canada (eng only), you might want to enter a city, state or zipcode of the news you want to display (optional);


* Select EITHER a topic OR search word(s) (because of Google rules, if you define both, the keyword(s) will be ignored) (optional);


* Tick off the box if you want a publication date, time, excerpt (and how many chars of it) or mention of this plugin author displayed or not (all optionals);


* Select whether you want a dotted list or a numbered/ordered list (mandatory, default: dotted list);


* Select whether you want the linked news to open up in a new page (default) or in the same page (mandatory, default: new page);


* Click on 'Save' (and Close, if you want it).





As a shortcode:





* In Posts/Pages->Add New/Edit of your wp admin page, select HTML in the entry form;


* enter [gnews location="replace-with-the-Google-s-location-code-of-the-country-language-you-want-news-from"]. Here is a list of [Google's localization codes](http://www.stefaniamarchisio.com/2010/02/21/google-news-localization-codes/) is here.


That's the sole mandatory attribute. Optional attributes are:


* link: either true or false to display a link to the 


* local: city, state/province or zipcode (of usa or Canada english news only)


* search: search-words according to google search syntax (see the description above) (default: none);


* topic: any of Google's topic-codes (default: Top Stories). Here is a [list of topic codes](http://www.stefaniamarchisio.com/2010/02/21/google-news-topic-codes/);


* num: number of news to be displayed (default: 3);


* list: either "UL" or "OL" to get unordered or ordered lists;


* target: either "_blank" or "_self" to get links opened in new/the same windows;


* pubdate: either true or false to display the publication date/not;


* pubtime: either true or false to display the publication time/not;


* pubauthor: either true or false to display a link to the author/not;





Please note the following Google quirks:





1. Not all topics are set for all country/language.  If you select a topic for a country where this is not provided (as yet?) then the "Top stories" (the default) will be displayed instead.


2. Google (not me!) allows to search by topic OR by search-word(s). The two "filters" cannot apparently work together (i.e. you cannot search for "hockey" in topic "Sport").


3. Because of the above, if topic AND search-keys are both indicated, then the search-keys are ignored (but no, no error message).


4. The maximum number of displayable articles depends on the number of articles stored into the XML page (RSS feed page) of Google news website (i.e. if you wish to display the latest 15 news and the XML page contains 10 news only, then only 10 will be displayed).


5. The search syntax is that indicated by Google. In other words, in the search results, if:


* all the words need to be present, then enter space-separated words (word1 word2 etc);


* any of the words can be present, then enter words separated by OR (word1 OR word2);


* words need to be excluded, then precede words with a minus or dash key (-word1 -word2);


* the exact phrase needs to be present, then enter the phrase delimited by double quotes ("exact phrase").





== The Future ==


* Better error messaging;


* Less-nerdy attributes values.





== Interaction ==


* Would you like to see a new feature in this plugin? Please write me here: stefonthenet@gmail.com;


* Would you like to see a broken/orphan plugin working again? Write me anyhow, I might (hey, MIGHT not will/shall) find the time to give it a look.