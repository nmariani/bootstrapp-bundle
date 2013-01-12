README
======

What is BootstrappBundle?
-----------------

BootstrappBundle is the best way to :

* grab the latest [Twitter Bootstrap assets](http://twitter.github.com/bootstrap/)
* start building [Symfony2](http://www.symfony.com) app with a nice UI by using the given twig templates

Requirements
------------

Symfony2.1 on PHP 5.3.3 required.

Documentation
-------------

The bulk of the documentation is stored in the `Resources/doc/index.md` file in this bundle.

Installation
------------

BootstrappBundle is not yet available via packagist.
But installing this bundle in your existing Symfony2 application is still simple as adding a few lines in your composer.json.

    {
        "require": {
            "nmariani/bootstrapp-bundle": "dev-master"
        },
        "repositories": [
            {
                "type": "package",
                "package": {
                    "name": "nmariani/bootstrapp-bundle",
                    "version": "dev-master",
                    "source": {
                        "url": "https://github.com/nmariani/bootstrapp-bundle.git",
                        "type": "git",
                        "reference": "master"
                    },
                    "dist": {
                        "url": "https://github.com/nmariani/bootstrapp-bundle/zipball/master",
                        "type": "zip"
                    }
                }
            }
        ]
    }


Then, use composer to install BootstrappBundle and its dependencies :

    php composer.phar install

Features
-----------------

* Twitter bootstrap assets (less, js, img)
* Twig templates for use with symfony2 Form component
  * render a form either via the form builder or the template engine
  * implement various bootstrap2 features
  * javascripts, stylesheets, and twig blocks for dynamic collections
* A generic Navbar class to generate easily a customized Navbar from within your code (ex : depending on the user)

Contribute
----------
If you want to contribute your code please be sure that your PR's are valid to Symfony2.1 Coding Standards.
You can automatically fix your code for that
with [PHP-CS-Fixer](http://cs.sensiolabs.org) tool.

License
-------

This bundle is under the MIT license. See the complete license in the bundle:

    [LICENCE](LICENCE).
