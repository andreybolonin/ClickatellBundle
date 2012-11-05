Getting Started With ClickatellBundle
==================================

[Clickatell](http://www.clickatell.com/)

## Prerequisites

This version of the bundle requires Symfony 2.1+. If you are using Symfony
2.0.x, please use the 1.2.x releases of the bundle.

### Translations

If you wish to use default texts provided in this bundle, you have to make
sure you have translator enabled in your config.

``` yaml
# app/config/config.yml

framework:
    translator: ~
```

For more information about translations, check [Symfony documentation](http://symfony.com/doc/current/book/translation.html).

## Installation

Installation is a quick (I promise!) 7 step process:

1. Download ArcherClickatellBundle using composer
2. Enable the Bundle
3. Create your Message class
4. Configure the ArcherClickatellBundle
5. Update your database schema

### Step 1: Download ArcherClickatellBundle using composer

Add ArcherClickatellBundle in your composer.json:

```js
{
    "require": {
        "archer/clickatell-bundle": "*"
    }
}
```

Now tell composer to download the bundle by running the command:

``` bash
$ php composer.phar update archer/clickatell-bundle
```

Composer will install the bundle to your project's `vendor/archer` directory.

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Archer\ClickatellBundle\ArcherClickatellBundle(),
    );
}
```

### Step 3: Create your User class

The goal of this bundle is to persist some `Message` class to a database (MySql,
MongoDB, CouchDB, etc).

The bundle provides base classes which are already mapped for most fields
to make it easier to create your entity. Here is how you use it:

1. Extend the base `Message` class (the class to use depends of your storage)
2. Map the `id` field. It must be protected as it is inherited from the parent class.

**Warning:**

> When you extend from the mapped superclass provided by the bundle, don't
> redefine the mapping for the other fields as it is provided by the bundle.

In the following sections, you'll see examples of how your `Message` class should
look, depending on how you're storing your users (Doctrine ORM, MongoDB ODM,
or CouchDB ODM).

Your `Message` class can live inside any bundle in your application. For example,
if you work at "Acme" company, then you might create a bundle called `AcmeMessageBundle`
and place your `Message` class in it.

**Note:**

> The doc uses a bundle named `AcmeMessageBundle`. If you want to use the same
> name, you need to register it in your kernel. But you can of course place
> your user class in the bundle you want.

**Warning:**

> If you override the __construct() method in your User class, be sure
> to call parent::__construct(), as the base User class depends on
> this to initialize some fields.

**a) Doctrine ORM User class**

If you're persisting your message via the Doctrine ORM, then your `message` class
should live in the `Entity` namespace of your bundle and look like this to
start:

``` php
<?php
// src/Acme/MessageBundle/Entity/User.php

namespace Acme\MessageBundle\Entity;

use Archer\ClickatellBundle\Entity\Message as BaseMessage;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="clickatell_message")
 */
class User extends BaseMessage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
}
```

**b) MongoDB Message class**
**c) CouchDB Message class**
**d) Propel Message class**

### Step 4: Configure the ArcherClickatell

Add the following configuration to your `config.yml` file according to which type
of datastore you are using.

``` yaml
# app/config/config.yml
fos_user:
    user:                 ~ # your username for clickatell
    password:             ~ # your password for clickatell
    api_id:               ~ # your id for clickatell
    message_class:  Acme\MessageBundle\Entity\Message
```


``` xml
# app/config/config.xml
<!-- app/config/config.xml -->

<!-- other valid 'db-driver' values are 'mongodb' and 'couchdb' -->
<fos_user:config
    user="username"
    password="password"
    api-id="api_id"
    message-class="Acme\MessageBundle\Entity\Message"
/>
```

### Step 5: Update your database schema

Now that the bundle is configured, the last thing you need to do is update your
database schema because you have added a new entity, the `Message` class which you
created in Step 4.

For ORM run the following command.

``` bash
$ php app/console doctrine:schema:update --force
```

### Usage Steps

``` php
//send  Sms
$form = $this->get('clickatell.send_message.form');
$form->bind($this->getRequest());
if ($form->isValid()) {
    $message = $form->getData();
    $clickatell = $this->get('clickatell.http');
    $response = $clickatell->sendMessage($message->getToPhone(), $message->getText());
}
```
