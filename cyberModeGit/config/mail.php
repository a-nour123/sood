<?php return array (
  'default' => 'smtp',
  'mailers' =>
  array (
    'smtp' =>
    array (
        // system
        // 'transport' => 'smtp',
        // 'host' => 'smtp.hostinger.com',
        // 'port' => '465',
        // 'encryption' => 'ssl',
        // 'username' => 'info@icg.queenland-group.com',
        // 'password' => 'Info#236',

        // Khaled
        'transport' => 'smtp',
        'host' => env('MAIL_HOST', 'smtp.mailtrap.io'),
        'port' => env('MAIL_PORT', 2525),
        'encryption' => env('MAIL_ENCRYPTION', 'tls'),
        'username' => env('MAIL_USERNAME'),
        'password' => env('MAIL_PASSWORD'),

      'timeout' => NULL,
      'auth_mode' => NULL,
      'stream' =>
      array (
        'ssl' =>
        array (
          'allow_self_signed' => true,
        'verify_peer' => false,
        'verify_peer_name' => false,
        ),
      ),
    ),
    'ses' =>
    array (
      'transport' => 'ses',
    ),
    'mailgun' =>
    array (
      'transport' => 'mailgun',
    ),
    'postmark' =>
    array (
      'transport' => 'postmark',
    ),
    'sendmail' =>
    array (
      'transport' => 'sendmail',
      'path' => '/usr/sbin/sendmail -bs',
    ),
    'log' =>
    array (
      'transport' => 'log',
      'channel' => NULL,
    ),
    'array' =>
    array (
      'transport' => 'array',
    ),
  ),
  'from' =>
  array (
    'address' => 'info@icg.queenland-group.com',
    'name' => 'cybermode',
  ),
  'markdown' =>
  array (
    'theme' => 'default',
    'paths' =>
    array (
      0 => 'D:\\grc_git\\grc\\resources\\views/vendor/mail',
    ),
  ),
);
