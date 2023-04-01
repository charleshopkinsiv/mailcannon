# Mail Cannon
![UML Class Diagram](https://raw.githubusercontent.com/charleshopkinsiv/mailcannon/main/public/img/cannon.jpg)

A simple project for email marketing. The goal is an open sourced fully functioning email marketing suite.


### Requirements

OS: Ubuntu

Software: Postfix, PHP 7.4, MySQL, Composer

PHP Libraries: 

### Installation

```
$ git clone git@github.com:charleshopkinsiv/mailcannon.git
$ cd mailcannon
$ composer install
$ sudo php install.php
$ mailcannon

Welcome to MailCannon
    - Make a selection below
    1. - Send Message to Address
    2. - Send Message to Address List
    3. - Message Manager
    4. - Address Manager
    5. - Address List Manager
    6. - Send Log

    - Message Manager
    1. - Create
    2. - List All
    3. - Update
    4. - Delete
    5. - List Templates

    - Address Manager
    1. - Create
    2. - List All
    3. - Update
    4. - Delete

    - Address_list Manager
    1. - Create
    2. - List All
    3. - Update
    4. - Delete
    5. - Add Address To List
    6. - List Addresses For List
    7. - Remove Address From List
```


### Features


![UML Class Diagram](https://raw.githubusercontent.com/charleshopkinsiv/mailcannon/main/public/img/cannon.jpg)

*Release 1.0 Cannon* - Current
* Send a message to an email address
* Send a message to an addresss list
* Address, Message, Message List
* Hardcoded message content
* CLI control



![UML Class Diagram](https://raw.githubusercontent.com/charleshopkinsiv/mailcannon/main/public/img/galleon.jpg)

*Version 1.1 Galleon*

* Sending daemon
* Scheduled sends
* List message sequence's
* Address tags
* Addresses import / export
* List import / export (csv, text)
* Multithreaded sending
* Web GUI
* Analyze Sends
* Basic Stats



![UML Class Diagram](https://raw.githubusercontent.com/charleshopkinsiv/mailcannon/main/public/img/fleet.jpg)

*Version 1.2 Treasure Fleet* **Private**

* Enhanced tracking and optimization
* Automated command server deployment and config
* Postfix relay server automated deployment and config to command server
* Abstract deployment class, Uses API's to purchase cloud resources
* 10+ deployment source child classes
* Ability to deploy a large amount of sending servers at many locations


![UML Class Diagram](https://raw.githubusercontent.com/charleshopkinsiv/mailcannon/main/public/img/kraken.jpg)

*Version 1.3 Kraken* **Private**

* I.P. reputation tracking
* Machine Learning optimized I.P. management



![UML Class Diagram](https://raw.githubusercontent.com/charleshopkinsiv/mailcannon/main/public/img/uml.jpg)
