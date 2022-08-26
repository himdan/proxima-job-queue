<?php
$content = file_get_contents('./diff_files');
$files = explode("\n", $content);

$directories = array_map(function($item){
    return "<directory suffix=\".php\">${item}</directory>";
}, $files);

$directoriesStr = implode(PHP_EOL, $directories);


$xml = <<< xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="https://schema.phpunit.de/9.3/phpunit.xsd" backupGlobals="false" colors="true" bootstrap="tests/bootstrap.php">
  <coverage processUncoveredFiles="true">
    <include>
        ${directoriesStr}
    </include>
  </coverage>
  <php>
    <ini name="error_reporting" value="-1"/>
    <server name="APP_ENV" value="test" force="true"/>
    <server name="SHELL_VERBOSITY" value="-1"/>
    <server name="SYMFONY_PHPUNIT_REMOVE" value=""/>
    <server name="SYMFONY_PHPUNIT_VERSION" value="9.0"/>
    <!-- ###+ nelmio/cors-bundle ### -->
    <env name="CORS_ALLOW_ORIGIN" value="'^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$'"/>
    <!-- ###- nelmio/cors-bundle ### -->
    <!-- ###+ knplabs/github-api ### -->
    <env name="GITHUB_AUTH_METHOD" value="http_password"/>
    <env name="GITHUB_USERNAME" value="username"/>
    <env name="GITHUB_SECRET" value="password_or_token"/>
    <env name="MERCURE_URL" value="https://127.0.0.1:8000/.well-known/mercure"/>
    <env name="MERCURE_PUBLIC_URL" value="https://127.0.0.1:8000/.well-known/mercure"/>
    <env name="MERCURE_JWT_SECRET" value="!ChangeMe!"/>
    <!-- Choose one of the transports below -->
    <!-- MESSENGER_TRANSPORT_DSN=doctrine://default -->
    <!-- MESSENGER_TRANSPORT_DSN=amqp://guest:guest@localhost:5672/%2f/messages -->
    <!-- MESSENGER_TRANSPORT_DSN=redis://localhost:6379/messages -->
    <!-- ###- symfony/messenger ### -->
    <env name="SYMFONY_DEPRECATIONS_HELPER" value="disabled" />
    <env name="DATABASE_URL" value="" />
  </php>
  <testsuites>
    <testsuite name="Project Test Suite">
      <directory>tests</directory>
    </testsuite>
  </testsuites>
  <extensions>
        <extension class="DAMA\DoctrineTestBundle\PHPUnit\PHPUnitExtension"/>
   </extensions>
</phpunit>
xml;
echo $xml;
?>