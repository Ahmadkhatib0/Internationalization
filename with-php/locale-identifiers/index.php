<?php

  require 'src/App/I18n.php';
  $i18n                     = new App\I18n(['en_GB', 'es']);
  list($subdomain, $domain) = explode(".", $_SERVER['HTTP_HOST'], 2);

  //   convert en_gb or en-gb from the browser to => en_GB what php needs
  $lang = $i18n->getBestMatch($subdomain);

  $getBrowserLanguages = $_SERVER['HTTP_ACCEPT_LANGUAGE'];
  print($i18n->getAcceptLocales());

  if ($lang == null) {
    $default = $i18n->getDefault();
    header("Location: http://" . $default . ".internationalization.test/");
    exit;
  }
  if ($lang == 'en_GB') {
    $trans = [
      'title'   => 'Example',
      'header'  => 'HOME',
      'welcome' => 'HELLO AND WELCOME',
    ];
  } elseif ($lang == 'es') {
    $trans = [
      'title'   => '',
      'header'  => 'ejemplo',
      'welcome' => 'Hola y bienvenida',
    ];
  }
?>

<!DOCTYPE html>
<html lang="<?php str_replace("_", "-", $lang);?>">

<head>
    <meta charset="UTF-8">
    <title> <?php echo $trans['title'] ?> </title>
</head>

<body>
    <h1><?php echo $trans['header'] ?></h1>
    <P> <?php echo $trans['welcome'] ?> </P>
</body>

</html>