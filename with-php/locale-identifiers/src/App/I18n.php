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
}
?>