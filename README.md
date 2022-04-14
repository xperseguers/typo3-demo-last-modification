# TYPO3 Sample "Last Modification"

The purpose of this repository is to provide a complete sample website showing how
to properly show a "last modified on" line in the footer of the design.

This is a typical use case, but unfortunately it is not that easy to achieve:

- TYPO3 takes properly care of updating the "last modified" date of a page whenever
  a content element is updated on that page;
- you will usually put some plugin on a page (like the list of recent news) and
  do not change that page anymore for many years to come, in that case, you are
  certainly not interested in knowing that the page structure has been changed
  years ago... You'd like to get the "last modified on" as when the most recent
  news or business record listed on that page has been last updated;
- it is expected to work both for pages with some "cached plugin" (easy) as well
  as pages that contain uncached plugins (trickier).

## Installation

* Prepare a website and a blank database (expected to be `typo3_lastmodified`)
* Import MySQL dump `website.sql`

Adapt database settings in `public/typo3conf/LocalConfiguration.php` if needed.

You can authenticate in TYPO3 with `admin`/`password`.

### Development server

While it's advised to use a more sophisticated web server such as
Apache 2 or Nginx, you can instantly run the project by using PHPs` built-in
[web server](https://secure.php.net/manual/en/features.commandline.webserver.php).

* `TYPO3_CONTEXT=Development php -S localhost:8000 -t public`
* open your browser at "http://localhost:8000"

Please be aware that the built-in web server is single threaded and only meant
to be used for development.

## What to look for

Have a look at custom extension "last_modified" (`public/typo3conf/ext/last_modified`)
to see how showing the last modification date has been tackled with with various
use cases.

## License

GPL-2.0 or later
