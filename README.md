Teebot
========

[![Build Status](https://travis-ci.org/rudestan/Teebot.svg?branch=master)](https://travis-ci.org/rudestan/Teebot) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/rudestan/Teebot/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/rudestan/Teebot/?branch=master) [![Coverage Status](https://coveralls.io/repos/github/rudestan/Teebot/badge.svg?branch=master)](https://coveralls.io/github/rudestan/Teebot?branch=master)

Teebot is yet another Telegram bot API framework. The main difference from other implementations that
it is very flexible, easy to extend and configure. You can focus on business logic implementation and
do not think about implementation of manual Telegram API calls. It has object oriented architecture yet
quite simple and understandable. Additionally you can create and run as many bots as you want at the same
time.

## Usage

The very first step is installation of the required packages. To install the packages please run

```composer install```

To run your bots you can use command line application called just like the package ```teebot```
and placed in ```bin``` directory.
 
If you would like to tryout the example bot from the package just rename or copy the file ```.env.template``` to ```.env``` and
modify it with your own data. The only thing you have to provide is Telegram's API Token. If you do not have
one yet you can easily get it from the official Telegram's web site.

After you got the token and set it in the ```.env``` you are ready to run the example bot. So from
the command line just run:

```php bin/teebot listener:start Bot/Example```

Then find your bot in Telegram client and send the message ```/me``` or ```/foo``` to it. You should now
see the message "Me command triggered!" in the console where you started your bot.

## Capability

PHP 5.6 and higher