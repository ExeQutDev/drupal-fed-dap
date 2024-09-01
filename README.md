## INTRODUCTION

The FED - Digital Analytics Program Government-wide Code module is an
integration module to load and configure the client libraries for integration.

Main Site
https://digital.gov/guides/dap/

Git repo
https://github.com/digital-analytics-program/gov-wide-code

The primary use case for this module is:

- Provide management interface to register client-side javascript libraries
- Configure parameters for integration and registering site.

## REQUIREMENTS

If using local copies of the libraries ensure to register in composer
and install into libraries.

Because this library doesn't provide an official release package we have
to install a support composer library to properly download and package
the assests.

Once installed and registred, Update your project composer.json and add the following packages.

        {
            "type": "package",
            "package": {
                "name": "digital-analytics-program/gov-wide-code-fed",
                "version": "6.9",
                "type": "drupal-library",
                "dist": {
                    "url": "https://github.com/digital-analytics-program/gov-wide-code/archive/refs/heads/master.zip",
                    "type": "zip"
                },
                "extra": {
                    "installer-name": "dap"
                },
                "require": {
                    "composer/installers": "^2"
                }
            }
        }

Next require the packages for auto-install

composer require "digital-analytics-program/gov-wide-code-fed"

If not using composer manually download the assets and place within:
/docroot/libraries/dap/

## INSTALLATION

Install as you would normally install a contributed Drupal module.
See: https://www.drupal.org/node/895232 for further information.

## CONFIGURATION
- Once the library assets are installed go to the configuration page to set
your preferences and provide your key parameters.

/admin/config/services/dap


## MAINTAINERS

Current maintainers for Drupal 10:

- Robert Foley (emptyvoid) - https://www.drupal.org/u/emptyvoid

