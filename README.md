# Voice Skill Management System (Skeleton)

> A framework for developing custom skills for voice assistant systems.

### Introduction
VSMS is a skill development framework for voice assistants like Amazon Voice Service. It aims to speed up skill 
development by incorporating boilerplate code into a framework. VSMS is able to run multiple skills from one 
installation as well as serving HTML content. 

It is entirely written in PHP based on Slim application framework and loosely follows a
[Model-View-Controller](https://en.wikipedia.org/wiki/Model%E2%80%93view%E2%80%93controller) pattern. 
The framework uses the Twig template engine, Analog logger und PHPUnit (see Libraries) but feel free to choose 
libraries and a project structure that best fits your needs. 

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

### Overview
#### Libraries
* Amazon-Alexa-PHP (https://github.com/anschluss80/amazon-alexa-php)
* VSMS-Core (github)
* Slim (https://www.slimframework.com)
* Analog (https://github.com/jbroadway/analog)
* Twig (https://twig.symfony.com/)
* PHPUnit for tests (https://phpunit.de/)

#### Directory structure
```
+ app                   Application files
| + config              Configuration (settings, dependecny injection, routing)
| + src                 Application source
| | + Controller        Controllers for skill handling and HTML pages 
| | + Service           Services
| | + Template          Twig templates
| + test                Application tests
| | + Controller        Controller tests
| | + Fixtures          Test fixtures
| + var                 Variable data
| | + log               Log files
| | + rendered          View renderer cache
| + vendor              Vendor libraries
+ asset                 Media files
| + css                 CSS
| + img                 Images
| + js                  JavaScript
| + lib                 Vendor libraries
```
#### Controller
This is where your Controllers reside. Controller methods are called based on routing (HTML controllers) or intent 
invocations (skill controllers). Have a look at the provided example controllers for a kick start.  

#### Service (Model)
Services provide backend functionality, like interactions with third party APIs that your skill can query data from.
This is where your models live.

#### Template (View)
The Twig templates help you to produce HTML output - like for Amazon's account linking feature or some neat marketing 
web pages.

### Tests
Testing is preconfigured with PHPUnit, and example tests are setup so you can throw in your own tests quickly.

### Connecting the (example) skill with Amazon
(@TODO)

### Submitting a skill for certification
(@TODO)

### What's next?
VSMS aims to interact with multiple voice assistant systems, so it's not only nailed down to Amazon Voice Service. 
With more services popping up, VSMS will be extended to support these too. The intention is to have a single environment 
to develop an interface to your customer.

You are welcome to contribute to this project, and so are your pull requests.

Found a bug or are in need of a missing feature? Please open a new issue and let us know.
 
