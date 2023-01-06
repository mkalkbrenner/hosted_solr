<?php

namespace Drupal\Tests\hosted_solr\Kernel;

use Drupal\hosted_solr_test\Plugin\SolrConnector\HostedSolrTestConnector;
use Drupal\Tests\search_api_solr\Kernel\SearchApiSolrTest;

/**
 * Tests index and search capabilities using the Solr search backend.
 *
 * @group hosted_solr
 */
class HostedSolrTest extends SearchApiSolrTest {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    'hosted_solr',
    'hosted_solr_test',
  ];

  /**
   * The language IDs.
   *
   * @var array
   */
  protected $languageIds = [
    'ar' => 'ar',
    'bg' => 'bg',
    'ca' => 'ca',
    'cs' => 'cs',
    'da' => 'da',
    'de' => 'de',
    'de-at' => 'de',
    'el' => 'el',
    'en' => 'en',
    'es' => 'es',
    'et' => 'et',
    'fa' => 'fa',
    'fi' => 'fi',
    'fr' => 'fr',
    'ga' => 'ga',
    'hi' => 'hi',
    'hr' => 'hr',
    //'hu' => 'hu',
    'id' => 'id',
    'it' => 'it',
    'ja' => 'ja',
    'lv' => 'lv',
    'nb' => 'nb',
    'nl' => 'nl',
    'nn' => 'nn',
    'pl' => 'pl',
    'pt-br' => 'pt_br',
    'pt-pt' => 'pt_pt',
    'ro' => 'ro',
    'ru' => 'ru',
    'sk' => 'sk',
    'sr' => 'sr',
    'sv' => 'sv',
    'th' => 'th',
    'tr' => 'tr',
    'xx' => FALSE,
    'uk' => 'uk',
    'zh-hans' => 'zh_hans',
    'zh-hant' => 'zh_hant',
  ];

  /**
   * {@inheritdoc}
   */
  protected function installConfigs() {
    parent::installConfigs();

    $this->installConfig([
      'hosted_solr',
      'hosted_solr_test',
    ]);

    // Swap the connector.
    HostedSolrTestConnector::adjustBackendConfig('search_api.server.solr_search_server');
  }

  /**
   * {@inheritdoc}
   */
  public function testConfigGeneration(array $files = []) {
    self::markTestSkipped('Config generation tests are skipped as Hosted Solr uses the jump start config sets.');
  }

}
