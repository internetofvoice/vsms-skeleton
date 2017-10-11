# Voice Skill Management System (Skeleton)

> A framework aiming at the rapid development of custom interactions (skills) for voice assistant systems.

## Introduction
VSMS is a development framework for voice assistants such as Amazon Voice Service. The intention is to speed up 
development by incorporating boilerplate code into a framework. VSMS is preconfigured to run multiple skills as 
well as serving HTML content. It can handle internationalisation and supports multiple server environments.

VSMS is written in PHP and comes with Slim application framework, Twig template engine, Analog logger and PHPUnit
(see "Libraries" section for more), but you are of course free to choose dependencies and project structure as 
you see fit. 

## Requirements
* PHP (at least 5.6.0)
* SSL-enabled web server 
* [composer](https://getcomposer.org/)
* [Amazon Developer Account](https://developer.amazon.com/)
* Amazon Alexa Client:
    - [Android App](https://play.google.com/store/apps/details?id=com.amazon.dee.app)
    - [iOS App](https://itunes.apple.com/de/app/amazon-echo/id944011620)
    - [Web based](https://alexa.amazon.com/spa/)
* Alexa-enabled device:
    - Hardware device like Echo, Echo Dot or similar products
    - Software service like [Reverb](https://reverb.ai/) or [Echosim](https://echosim.io/)

## Installation

1. Create a new project (*my-skills* in this example)
2. Change to the `app` directory of *my-skills* 
3. Install dependencies
   
```
$ composer create-project internetofvoice/vsms-skeleton my-skills 
$ cd my-skills/app
$ composer install
```

## Outline
### Libraries
* LibVoice: https://github.com/internetofvoice/libvoice
* VSMS-Core: https://github.com/internetofvoice/vsms-core
* Slim: https://www.slimframework.com
* Analog: https://github.com/jbroadway/analog
* Twig: https://twig.symfony.com
* Twig-View: https://github.com/slimphp/Twig-View
* PHPUnit: https://phpunit.de

### Directory structure
```
+ app                   Application files
| + config              Configuration (settings, dependency injection, routing)
| + src                 Application sources
| | + Controller        Controllers 
| | + Service           Services
| | + Template          HTML templates
| | + Translation       Translation files for multiple language support (i18n) 
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
### Controller
This is where your Controllers, both skill and HTML controllers, reside. Controller methods are called based on 
intent invocations (skill controllers) or routing configuration (HTML controllers). Have a look at the provided 
examples for a kick start.  

### Services
Services provide backend functionality, like interactions with third party APIs that your skill can query data from.

### Templates
Templates help you to produce HTML output which is needed for Amazon's account linking feature, displaying a privacy
policy page or some neat marketing web pages.

### Translation
If you need multiple language support, place your translations here.

### Tests
Unit tests are preconfigured to work with PHPUnit. Examples are included, so you can throw in your own tests quickly.

### Var
Variable data, like log files or rendered template files, go in here.

### Assets 
Place your frontend files (CSS, JavaScript, images, ...) here as this directory is web-accessible – in contrary to 
the `/app` directory, to which direct access is forbidden. You'll find a copy of [Bootstrap](http://getbootstrap.com/)
here, which is used to generate a responsive login page for Amazon's account linking feature.  

## Setup
### Server
- Setup an SSL-enabled web server / virtual host with PHP (5.6.0 or newer)
- A secure tunneling service like https://ngrok.com might be useful to expose your machine to an HTTPS accessible URL
- Install VSMS as described in the "Installation" section above 

### Environments
VSMS supports multiple environments like *dev*, *test*, *stage* and *prod* with the latter being the default. If you
want to use this feature, put an environment variable `APP_ENV` in your web server's virtual host configuration
and in your shell as test requests will not involve the web server.

Apache example:
```apacheconf   
<VirtualHost *:80>
 ServerName  my-skills.example.com
 (...)
 SetEnv      APP_ENV dev
</VirtualHost>
```
.bashrc example:
```bash 
export APP_ENV="dev"
```

When doing so, you may set environment dependent configurations in `/app/config/settings.php`.
If you do not want to use this feature, set your configurations for the default *prod*.

Environments enable you for instance to skip request certificate validation (see `/app/config/settings.php`) 
and thus to send test / fake requests to your app. Please do *not* disable the validation in your production version, 
as it is mandatory - please see 
[Alexa Skills Kit Documentation](https://developer.amazon.com/public/solutions/alexa/alexa-skills-kit/docs/developing-an-alexa-skill-as-a-web-service#verifying-that-the-request-was-sent-by-alexa).


## Example content
VSMS comes with an example skill, a privacy policy page and a login form for account linking. While HTML pages can be 
examined with a browser, skills require a specific constructed request that you can fake with a tool like 
[Postman](https://www.getpostman.com/) (also available as a Chrome extension). Another option is to use the Service
Simulator you will find on https://developer.amazon.com/ when setting up your skill. 

The pre-configured URIs are:
- Skill: http(s)://your-hostname/example/skill
- Privacy policy: http(s)://your-hostname/example/privacy
- Account linking login form: http(s)://your-hostname/example/link

### Sending skill requests using Postman
Please find an example collection for Postman in `/app/test/Fixtures/Example.postman_collection.json`, import it 
to Postman and tweak it to your needs - at least the request url and applicationId need to match your setup. The
provided examples do not work with certificate validation.

### How to obtain example requests that pass validation?
This is a little tricky, but the answer is: from Amazon. You might for instance use a test skill (or setup a new one)
and point the URL to this PHP script:
```php
$body = file_get_contents('php://input');
$headers = json_encode(getallheaders());

file_put_contents('./test.log', "Body:\n$body\nHeader:\n$headers\n", FILE_APPEND);
```
It will write any input and request headers to `test.log`. Now use Amazons Service Simulator to send a request to
your script. As it sends no response, the Simulator will show an error message, but that's fine - the request is
logged to our file. Please be aware that the body part has to remain unchanged, that even applies to whitespaces
and carriage returns. If your favorite editor/IDE is for instance setup to append a final newline, the body content
might have changed when copying / pasting to your test fixtures.

### Running tests
Composer.json is preconfigured with some scripts to invoke PHPUnit tests:
```bash
$ cd /app 
$ composer test 
```
 
## Setup a skill with Amazon
- Login to https://developer.amazon.com
- Go to Alexa > Alexa Skills Kit (ASK) https://developer.amazon.com/edw/home.html#/skills
- Add a new skill 
- Fill in the requested fields
- Copy the application ID and paste it into your skill controller, test fixtures and fake requests 
- Make your skill accessible via HTTPS by uploading it to a server or using a service like ngrok
- Put your skill URL (see `/app/config/routing.php`) into the skill configuration at ASK   
- Test your skill with the Service Simulator provided by Amazon, with an Echo device or the Reverb app

If something goes wrong, check Amazons Service Simulator and the application log.

### Example skill
In case you want to use the example skill for a kick start, you need to setup the interaction model. It
comes in two languages, english and german. If you want to use both, first add the missing language in 
the skill configuration in ASK. After that, you find an intent schema and sample utterances for both languages in 
`/app/config/amazon/example/`. For the german skill, you additionally need to setup a custom slot type
named *My_Country* with the values that are contained in this directory. For the english skill, a preconfigured 
slot type provided by Amazon is used.

As the skill demonstrates the account linking feature, you need to configure account linking with *implicit
grant* and provide *authorization* and *privacy policy* URLs (see `/app/config/routing.php`). When using the skill
and being asked to login for account linking, use the super secret credentials "test" / "test".


### Submit a skill for certification
Please test your skill thoroughly and step through
[Amazon's Certification Requirements](https://developer.amazon.com/public/solutions/alexa/alexa-skills-kit/docs/alexa-skills-kit-submission-checklist)
carefully to ensure the best experience for your end users and to improve the chance to get your skill certified.

**Please do not submit the example skill for certification.**   

## What's next?
VSMS aims to interact with multiple voice assistant systems, so it's not only nailed down to ASK. 
With more services popping up, VSMS will be extended to support those too. The idea is to have a single environment 
to handle all your voice assistant development needs without writing duplicate code.

You are welcome to contribute to this project, and so are your pull requests.

Found a bug or have a feature request? Please open a new issue and let us know.
