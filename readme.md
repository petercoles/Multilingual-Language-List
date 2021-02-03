# Multilingual Language Lists for Laravel

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/c1edba78-da39-4465-b53b-362e8f0f8f6b/mini.png)](https://insight.sensiolabs.com/projects/c1edba78-da39-4465-b53b-362e8f0f8f6b)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/petercoles/Multilingual-Language-List/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/petercoles/Multilingual-Language-List/?branch=master)
[![Code Coverage](https://scrutinizer-ci.com/g/petercoles/Multilingual-Language-List/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/petercoles/Multilingual-Language-List/?branch=master)
[![Build Status](https://travis-ci.org/petercoles/Multilingual-Language-List.svg?branch=master)](https://travis-ci.org/petercoles/Multilingual-Language-List)
[![License](http://img.shields.io/:license-mit-blue.svg)](http://doge.mit-license.org)

## Introduction

Over the years, many of the projects I've worked on have resulted in multilingual sites. During that time the number of languages typically supported has increased and the sensitivity to the importance of dialectical differences has improved, which are good things.

The purpose of this package is to make managing language lists, such as those used in language pulldowns or form select fields easier to generate via a simple API that gives access to an industry-maintained list.

Data can be returned as a lookup array or an array of key-value pairs, where both the key and value labels can be set according to the needs of the software consuming them.

## Installation

At the command line run

```shell
composer require petercoles/multilingual-language-list
```

If you're using Laravel 5.5 or later (and haven't disabled package discovery), you're done. Move on to the usage section below.

If you're using an older version of Laravel, then add the service provider to the providers entry in your config/app.php file

```php
    'providers' => [
        // ...
        PeterColes\Languages\LanguagesServiceProvider::class,
        // ...
    ],
```

An optional facade is also available and can be enabled by adding the following to you config/app.php's aliases array

```php
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

#### Example: Default settigs

```php
Languages::lookup();

// returns

{
  "ab": "Abkhazian",
  ...
  "zu": "Zulu"
}

```

#### Example: Limiting the languages displayed

```php
Languages::lookup(['en', 'fr', 'de']);

// returns

{
  "en": "English",
  "fr": "French",
  "de": "German"
}
```

#### Example: Changing the display language

```php
Languages::lookup(['en', 'fr', 'de'], 'fr');

// returns

{
  "de": "allemand",
  "en": "anglais",
  "fr": "français"
}
```

#### Example: Reverse lookups

```php
Languages::lookup(['en', 'fr', 'de'], 'fr', true);

// returns

{
  "allemand": "de",
  "anglais": "en",
  "français": "fr"
}

```

#### Example: Non-latin character sets are supported too

```php
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

#### Example: Default settings

```php
Languages::keyValue();

// returns

[
  {"key": "ab", "value": "Abkhazian"},
  {"key": "aa", "value": "Afar"},
  ...
  {"key": "za", "value": "Zhuang"},
  {"key": "zu", "value": "Zulu"}
]
```

#### Example: Include "minor" languages

```php
Languages::keyValue('minor');

// returns

[
  {"key": "ab", "value": "Abkhazian"},
  {"key": "ace", "value": "Achinese"},
  {"key": "ach", "value": "Acoli"},
  ...
  {"key": "gbz", "value": "Zoroastrian Dari"},
  {"key": "zu", "value": "Zulu"},
  {"key": "zun", "value": "Zuni"}
]
```

#### Example: The kitchen sink - custom list, in non-Latin language with custom indices

```php
Languages::keyValue(['en', 'ja', 'zh'], 'zh', 'label', 'text');

// returns

[
  {"label": "ja", "text": "日文"},
  {"label": "en", "text": "英文"},
  {"label": "zh", "text": "中文"}
]
```

### Mixed Locales

Sometimes you might want to display a list of languages where each language is expressed in its own language and writing system e.g. one list with French as français, Japanese as 日本語 and Russian as русский. If so, we've got you covered.

By using the special "mixed" locale as the second parameter and a custom array as the first, the languages in that custom array will each be rendered in their own localised form, in the order given in the first parameter.

#### Example: lookup

```php
Languages::lookup(['en', 'fr', 'de', 'ja', 'ru', 'zh'], 'mixed');

// returns

{
  "en": "English",
  "fr": "français",
  "de": "Deutsch",
  "ja": "日本語",
  "ru": "русский",
  "zh": "中文",
}

```

#### Example: key-value

```php
Languages::keyValue(['en', 'fr', 'de', 'ja', 'ru', 'zh'], 'mixed');

// returns

[
  {"key" => "en", "value" => "English"},
  {"key" => "fr", "value" => "français"},
  {"key" => "de", "value" => "Deutsch"},
  {"key" => "ja", "value" => "日本語"},
  {"key" => "ru", "value" => "русский"},
  {"key" => "zh", "value" => "中文"}
]
```

As seen above, the mixed locale parameter can be used for generating lookups or key-value objects. The $flip, $key and $value parameters continue to work for the relevant list type in the same way as shown in the earlier sections.

#### Example: Find all possible mixed language candidates

Each locale file contains (currently) almost 600 language names expressed in that locale. However, the presence of a language in each locale file does not mean that the inverse is true, i.e. many of the languages do not have a locale file, though some have many locale files. That probably needs an example.

In addition to basic English locale file en.php, there are locale files for many variants of English (over 100 in fact). Each of those contains the English names for almost 600 languages, with slight variations where they have different names in different parts of the world. The first language in each of these locales is Abkhazian. However there is no locale file for Abkhazian so we don't know what "English" is in Abkhazian, or even how the Abkhazian language refers to itself, so it's not possible to include it in a list of mixed languages.

The list of languages that can be used will change over time, and could change each time the data is updated. Here's how you can generate a list of the currently feasible candidates.

Firstly obtain an array of the major languages (there is no locale data available for "minor" languages)

```php
$languageKeys = Languages::lookup('major')->keys()->toArray();

// returns
['ab', ... 'zu']
```

Then lookup these languages using the "parameter" which will filter out languages for which there is no locale file.

```php
$mixedLanguages = Languages::lookup($languageKeys, 'mixed');

// returns

{
  "af": "Afrikaans",
  "ak": "Akan",
  "sq": "shqip",
  "am": "አማርኛ",
  "ar": "العربية",
  "hy": "հայերեն",
  "as": "অসমীয়া",
  ...
  "zu": "isiZulu"
}
```

A word of caution however, generating this requires a lot of filesystem reads, so I recommend that you not call this every time you want to use the list and instead use Laravel's outstanding Caching system to persist the results for use in your live system.

If you don't personally read all 184 (current) candidate languages and want a list that you can understand (e.g. to remove obscure or irrelevant ones), simply feed the keys for the list back into the lookup method and specify the language of your choice:

```php
Languages::lookup($mixedLanguages->keys()->toArray(), 'fr');
```

## Issues

This package was developed to meet a specific need and then generalised for wider use. If you have a use case not currently met, or see something that appears to not be working correctly, please raise an issue at the [github repo](https://github.com/petercoles/countries/issues).

## Contributions

Contributions are welcome, but will generally need tests. I recommend raising an issue first so that proposed changes or enhancements can be discussed before development starts.

## License

This package is licensed under the [MIT license](http://opensource.org/licenses/MIT).
