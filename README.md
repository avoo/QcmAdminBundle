QcmAdminBundle
==============

[![Latest Stable Version](https://poser.pugx.org/avoo/qcm-admin-bundle/v/stable)](https://packagist.org/packages/avoo/qcm-admin-bundle)
[![License](https://poser.pugx.org/avoo/qcm-admin-bundle/license)](https://packagist.org/packages/avoo/qcm-admin-bundle)
[![Build Status](https://scrutinizer-ci.com/g/avoo/QcmAdminBundle/badges/build.png?b=master)](https://scrutinizer-ci.com/g/avoo/QcmAdminBundle/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/avoo/QcmAdminBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/avoo/QcmAdminBundle/?branch=master)

The admin bundle is based on [`QcmCoreBundle`](https://github.com/avoo/QcmCoreBundle)

Installation
------------

Require [`avoo/qcm-admin-bundle`](https://packagist.org/packages/avoo/qcm-admin-bundle)
into your `composer.json` file:

``` json
{
    "require": {
        "avoo/qcm-admin-bundle": "dev-master"
    }
}
```

Register the bundle in `app/AppKernel.php`:

``` php
// app/AppKernel.php
public function registerBundles()
{
    return array(
        // ...
        new Bazinga\Bundle\JsTranslationBundle\BazingaJsTranslationBundle(),
        new Qcm\Bundle\CoreBundle\QcmCoreBundle(),
        new Qcm\Bundle\AdminBundle\QcmAdminBundle(),
    );
}
```

In `app/config/config.yml`

``` yml
imports:
    - { resource: @QcmCoreBundle/Resources/config/core.yml }
    - { resource: @QcmAdminBundle/Resources/config/core.yml }
```

In `app/config/routing.yml`

``` yml
qcm_core:
    prefix:   /
    resource: "@QcmCoreBundle/Resources/config/routing.yml"

qcm_admin:
    resource: "@QcmAdminBundle/Resources/config/routing.yml"
    prefix:   /admin
```    

Documentation:

See [`QcmCoreBundle`](https://github.com/avoo/QcmCoreBundle)

Credits
-------

* Jérémy Jégou <jejeavo@gmail.com>

License
-------

This bundle is released under the MIT license. See the complete license in the bundle:

[License](https://github.com/avoo/QcmCoreBundle/blob/master/LICENSE)
