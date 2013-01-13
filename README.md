BootstrappBundle
================

**WARNING : THIS BUNDLE IS STILL IN EARLY STAGE OF DEVELOPMENT. YOU CAN USE IT AS IS BUT I ENCOURAGE YOU TO WAIT UNTIL IT IS FINALIZED!**

What is BootstrappBundle?
-------------------------

BootstrappBundle is the best way to start building a [Symfony2](http://www.symfony.com) app with a nice UI including :

* latest [Twitter Bootstrap assets](http://twitter.github.com/bootstrap/)
* additional icons : [Entypo](http://github.com/danielbruce/entypo), [Font Awesome](http://github.com/FortAwesome/Font-Awesome)
* [TwitterCldr](http://github.com/twitter/twitter-cldr-js) for Unicode's Common Locale Data Repository (CLDR) use in Javascript
* date, time and datetime pickers integration with CLDR Date and time formatting
    * [jdewit Timepicker for Twitter Bootstrap](http://github.com/jdewit/bootstrap-timepicker)
    * [eternicode fork of Stefan Petre's Datepicker for Bootstrap](http://github.com/eternicode/bootstrap-datepicker)
    * [vitalets fork of Stefan Petre's Datepicker for Bootstrap](http://github.com/vitalets/bootstrap-datepicker)
    * [acidb Mobiscroll](http://github.com/acidb/mobiscroll)
    * [jQuery UI](http://github.com/jquery/jquery-ui) with [jQuery UI Bootstrap](http://github.com/addyosmani/jquery-ui-bootstrap)
    * [amsul pickadate.js ](http://github.com/amsul/pickadate.js)
* text editors
    * [dybskiy redactor-js ](http://github.com/dybskiy/redactor-js)

Requirements
------------

Symfony2.1 on PHP 5.3.3 required.

Documentation
-------------

The bulk of the documentation is stored in the `Resources/doc/index.md` file in this bundle.

Installation
------------

BootstrappBundle is available via packagist.
Installing this bundle is simple as adding the few lines below.

Add dependency in you composer.json file to grab Bootstrapp as a vendor.

    {
        "require": {
            "nmariani/bootstrapp-bundle": "dev-master"
        }
    }

Then, use composer to install BootstrappBundle and its dependencies :

    php composer.phar install

Import Bootstrapp internal routing in your routing.yml file.

    bootstrapp:
      resource: "@BootstrappBundle/Resources/config/routing.yml"

Demo
----

You can import Bootstrapp demo routes in your routing_dev.yml

    bootstrapp:
      resource: "@BootstrappBundle/Resources/config/routing_dev.yml"
      prefix:   /{_locale}/bootstrapp

Then you can visit /bootstrapp/demo url to access demo page.

Contribute
----------
If you want to contribute your code please be sure that your PR's are valid to Symfony2.1 Coding Standards.
You can automatically fix your code for that
with [PHP-CS-Fixer](http://cs.sensiolabs.org) tool.

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    [LICENCE](LICENCE).
