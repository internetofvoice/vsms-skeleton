# Voice Skill Management System (Skeleton)

> A framework aiming at the rapid development of custom skills for voice assistant systems.

### Introduction
VSMS is a skill development framework for voice assistants such as Amazon Voice Service. The intention is to speed up 
skill development by incorporating boilerplate code into a framework. VSMS is preconfigured to run multiple skills as 
well as serving HTML content.  

It is written in PHP and comes with Slim application framework, Twig template engine, Analog logger und PHPUnit tests 
(see "Libraries" section), but you are totally free to choose dependencies and a project structure as you see fit. 

### Requirements
* PHP (at least 5.5.0)
* SSL-enabled Webserver 
* [composer](https://getcomposer.org/download/)
* [Amazon Developer Account](https://developer.amazon.com/)
* Amazon Alexa Client
    - [Android App](https://play.google.com/store/apps/details?id=com.amazon.dee.app) 
    - [iOS App](https://itunes.apple.com/de/app/amazon-echo/id944011620)
    - [Web based](https://alexa.amazon.com/spa/)
* Alexa-enabled device
    - Hardware device like Echo, Echo dot or similar products
    - Software service like [Reverb](https://reverb.ai/) or [Echosim](https://echosim.io/)

### Installation
```
$ composer new-project internetofvoice/vsms-skeleton my-skills 
```

### Outline
#### Libraries
* Amazon-Alexa-PHP: https://github.com/internetofvoice/amazon-alexa-php
* VSMS-Core: https://github.com/internetofvoice/vsms-core
* Slim: https://www.slimframework.com
* Analog: https://github.com/jbroadway/analog
* Twig: https://twig.symfony.com
* PHPUnit: https://phpunit.de

#### Directory structure
```
+ app                   Application files
| + config              Configuration (settings, dependency injection, routing)
| + src                 Application sources
| | + Controller        Controllers 
| | + Service           Services
| | + Template          HTML templates
| + test                Application tests
| | + Controller        Controller tests
| | + Fixtures          Test fixtures
| | + Service           Service Tests
| + var                 Variable data
| | + log               Log files
| | + rendered          Template cache
| + vendor              Vendor libraries (backend)
+ asset                 Media files
| + css                 CSS
| + img                 Images
| + js                  JavaScript
| + vendor              Vendor libraries (frontend)
```
#### Controller
This is where your Controllers, both skill and HTML controllers, reside. Controller methods are called based on 
intent invocations (skill controllers) and routing configuration (HTML controllers). Have a look at the provided 
examples for a kick start.  

#### Service
Services provide backend functionality, like interactions with third party APIs that your skill can query data from.

#### Template
The HTML templates help you to produce HTML output which might be needed for Amazon's account linking feature, 
displaying your privacy policy page or some neat marketing web pages.

### Tests
Testing is preconfigured to work with PHPUnit. Example tests are included, so you can throw in your own tests quickly.

### Connecting a skill with Amazon
@TODO

### Submitting a skill for certification
@TODO

### What's next?
VSMS aims to interact with multiple voice assistant systems, so it's not only nailed down to Amazon Voice Service. 
With more services popping up, VSMS will be extended to support those too. The idea is to have a single environment 
to handle all your voice assistant development needs without writing duplicate code.

You are welcome to contribute to this project, and so are your pull requests.

Found a bug or have a feature request? Please open a new issue and let us know.
