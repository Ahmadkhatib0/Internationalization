<?php

  require 'src/App/I18n.php';
  require __DIR__ . '/vendor/autoload.php';
  $i18n                     = new App\I18n(['en_US', 'en_GB', 'es']);
  list($subdomain, $domain) = explode(".", $_SERVER['HTTP_HOST'], 2);

  //   convert en_gb or en-gb from the browser to => en_GB what php needs
  $locale = $i18n->getBestMatch($subdomain);

  $getBrowserLanguages = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
  // print($i18n->getAcceptLocales());

  if ($locale == null) {
    $lang = $this->getLocaleForRedirect();
    // exit;
    $subdomain = substr($locale, 0, 2);
    header("Location: http://" . $subdomain . ".localhost:3000/");
    exit;
  }

  putenv("LANG=$locale");
  putenv("LANGUAGE=$locale"); //these tow lines if gettext didn't work

  setLocale(LC_ALL, $locale); //SET locale that php will use
  $domain = "messages"; //this called translation domain

  textdomain($domain); //this optional, because it's = messages by default

  bindtextdomain($domain, 'locales'); //tell gettext where translation messages are

  bind_textdomain_codeset($domain, 'UTF-8');

?>

<!DOCTYPE html>
<html lang="<?php str_replace("_", "-", $locale);?>">

<head>
    <meta charset="UTF-8">
    <title> <?=gettext("Example")?> </title>
</head>

<body>
    <h1><?=gettext('Home')?></h1>
    <!-- <P> <?=gettext('HELLO AND WELCOME')?> </P> or with just _ -->
    <P> <?=_('HELLO AND WELCOME')?> </P>
</body>

</html>