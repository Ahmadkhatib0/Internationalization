<?php

namespace App;

class I18n {
  private $supported_locales;
  public function __construct(array $supported_locales) {
    $this->supported_locales = $supported_locales;
  }
  public function getBestMatch(string $lang) {
    $lang = \Locale::canonicalize($lang);
    if (in_array($lang, $this->supported_locales)) {
      return $lang;
    } else {
      foreach ($this->supported_locales as $supported_locale) {
        if (substr($supported_locale, 0, 2) == $lang) {
          return $supported_locale;
        }
      }
    }
    return null;
  }

  public function getDefault() {
    return $this->supported_locales[0];
  }

  public function getAcceptLocales() {

    if ($_SERVER['HTTP_ACCEPT_LANGUAGE'] == '') {
      return [];
    };
    $accepted_locales = [];
    $parts            = explode(",", $_SERVER['HTTP_ACCEPT_LANGUAGE']);

    foreach ($parts as $part) {
      $locale_and_preference = explode(';q=', $part);
      $locale                = trim($locale_and_preference[0]);
      $preference            = $locale[1] ?? 1.0;
      // (ie en-GB,es-ES;q=0.7,en;q=0.3)
      $accepted_locales[$locale] = $preference;
    }
    asort($accepted_locales); //hightest locale preference is first
    return array_keys($accepted_locales);
  }

  public function getBestMatchFromHeader() {
    $accepted_locales = $this->getAcceptLocales();

    array_walk($accepted_locales, function (&$locale) {
      $locale = \Locale::canonicalize($locale);
    });

    // array walk will run this function each time for every element in an array
    foreach ($accepted_locales as $locale) {
      if (in_array($locale, $this->supported_locales)) {
        return $locale;
      }
    }

    foreach ($accepted_locales as $locale) {
      $lang = substr($locale, 0, 2);

      foreach ($this->supported_locales as $supported_locale) {
        if (substr($supported_locale, 0, 2) == $lang) {
          return $supported_locale;
          // default to es if the browser sat to es-ES or es-MX
        }
      }
    }
    return null;
  }
}
?>