# Multilingual Language Lists for Laravel

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/petercoles/Multilingual-Language-List/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/petercoles/Multilingual-Language-List/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/petercoles/Multilingual-Language-List/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/petercoles/Multilingual-Language-List/?branch=master)
[![Build Status](https://travis-ci.org/petercoles/Multilingual-Language-List.svg?branch=master)](https://travis-ci.org/petercoles/Multilingual-Language-List)
[![License](http://img.shields.io/:license-mit-blue.svg)](http://doge.mit-license.org)

## Introduction

Over the years, many of the projects I've worked on have resulted in multilingual sites. During that time the number of languages typically supported has increased and the sensitivty to the importance of dialectical differences has improved, which are good things.

The purpose of this package is to make managing language lists, such as those used in language pulldowns or form select fields easier to generate via a simple API that gives access to an industry-maintained list.

Data can be returned as a lookup array or an array of key-value pairs, where both the key and value labels can be set according to the needs of the software consuming them.

## Installation

At the command line run

```
composer require petercoles/multilingual-language-list
```

then add the service provider to the providers entry in your config/app.php file

```
    'providers' => [
        // ...
        PeterColes\LiveOrLetDie\Providers\LanguagesServiceProvider::class,
        // ...
    ],
```

An optional facade is also available and can be enabled by adding the following to you config/app.php's aliases array

```
'Languages' => PeterColes\Languages\LanguagesFacade::class,
```

## Usage

Once installed the package exposes two API methods: lookup() and keyValue(), each of which returns a list of countries ordered by the country name in the language being used.

### Lookup

The ```lookup``` method takes three optional parameters and returns a collection.
* $filter determines which languages are to be included in the response. It defaults to "major", which will cause a list of only those languages with a two letter code to be returned (e.g. fr - French). Other options are "minor" which will add languages with three letter codes (e.g. arw - Arawak) and "all", which is not recommended and will return every possible entry including some dialects (e.g. es_MX - Mexican Spanish) and constructs (e.g. es_419 - Latin American Spanish).
* $locale determines the language and dialect in which the response will be returned. Locales can be languages (e.g. fr - French), dialects (e.g. fr_CA - Canadian French) and specials (e.g. bs_Cryl_BA - cryllic script for the dialect of Bosnian from Bosnia and Herzegovina or zh_Hans_HK - Simplified Chinese for the Hong Kong Dialect). They look rather like languages, but are more nuanced, i.e. there's a whole lot more of them. 
* $flip to switch the key and value for the response array so that the language name becomes the key and the language code becomes the value.

The resulting collection will be cast to a json object by Laravel if returned as a response, or can be cast to an array if needed with the toArray() method.

#### Example: Default Settigs

```
Languages::lookup();

// returns

{
  "ab": "Abkhazian",
  ...
  "zu": "Zulu"
}

```

#### Example: Limiting the languages displayed

```
Languages::lookup(['en', 'fr', 'de']);

// returns

{
  "en": "English",
  "fr": "French",
  "de": "German"
}
```

#### Example: Changing the display language

```
Languages::lookup(['en', 'fr', 'de'], 'fr');

// returns

{
  "de": "allemand",
  "en": "anglais",
  "fr": "français"
}
```

#### Example: Reverse lookups

```
Languages::lookup(['en', 'fr', 'de'], 'fr', true);

// returns

{
  "allemand": "de",
  "anglais": "en",
  "français": "fr"
}

```

#### Example: Non-latin character sets are supported too
```
Languages::lookup(['en', 'fr', 'de', 'bs'], 'bs_Cyrl');

// returns

{
  "bs": "босански",
  "en": "енглески",
  "de": "немачки",
  "fr": "француски"
}

```

### keyValue

The ```keyValue``` method takes four optional parameters:
* $filter - default "major". See lookup section for full explanation
* $locale - default "en". See lookup section for full explanation
* $key - default "key"
* $value - default "value"

## Issues

This package was developed to meet a specific need and then generalised for wider use. If you have a use case not currently met, or see something that appears to not be working correctly, please raise an issue at the [github repo](https://github.com/petercoles/countries/issues)

## License

This package is licensed under the [MIT license](http://opensource.org/licenses/MIT).
