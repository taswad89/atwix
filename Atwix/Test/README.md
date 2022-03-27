# Mage2 Module Atwix Test

    ``atwix/module-test``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
Slider and banner

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Atwix`
 - Enable the module by running `php bin/magento module:enable Atwix_Test`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - Make the module available in a composer repository for example:
    - private repository `repo.magento.com`
    - public repository `packagist.org`
    - public github repository as vcs
 - Add the composer repository to the configuration by running `composer config repositories.repo.magento.com composer https://repo.magento.com/`
 - Install the module composer by running `composer require atwix/module-test`
 - enable the module by running `php bin/magento module:enable Atwix_Test`
 - apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`


## Configuration




## Specifications

 - Observer
	- controller_action_predispatch_customer_account_createpost > Atwix\Test\Observer\Controller\ActionPredispatchCustomerAccountCreatepost

 - Observer
	- customer_register_success > Atwix\Test\Observer\Customer\RegisterSuccess


## Attributes



