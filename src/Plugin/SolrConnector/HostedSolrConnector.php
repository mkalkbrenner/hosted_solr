<?php

namespace Drupal\hosted_solr\Plugin\SolrConnector;

use Drupal\Core\Form\FormStateInterface;
use Drupal\search_api_solr\SolrConnector\BasicAuthTrait;
use Drupal\search_api_solr\SolrConnector\SolrConnectorPluginBase;
use Solarium\Client;
use Solarium\Core\Client\Adapter\Http;

/**
 * Class HostedSolrConnector.
 *
 * Extends SolrConnectorPluginBase for Hosted Solr.
 *
 * @package Drupal\hosted_solr\Plugin\SolrConnector
 *
 * @SolrConnector(
 *   id = "hosted_solr",
 *   label = @Translation("Hosted Solr"),
 *   description = @Translation("Index items using the Hosted Solr service.")
 * )
 */
class HostedSolrConnector extends SolrConnectorPluginBase {

  use BasicAuthTrait {
    BasicAuthTrait::defaultConfiguration as basicAuthTraitDefaultConfiguration;
    BasicAuthTrait::buildConfigurationForm as basicAuthTraitBuildConfigurationForm;
    BasicAuthTrait::submitConfigurationForm as basicAuthTraitSubmitConfigurationForm;
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return [
      'scheme' => 'https',
      'host' => '',
      'port' => 443,
      'path' => '',
      'core' => 'core',
    ] + $this->basicAuthTraitDefaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form = $this->basicAuthTraitBuildConfigurationForm($form, $form_state);

    $form['scheme'] = [
      '#type' => 'value',
      '#value' => 'https',
    ];

    $form['port'] = [
      '#type' => 'value',
      '#value' => '443',
    ];

    $form['core'] = [
      '#type' => 'value',
      '#value' => 'core',
    ];

    $form['path']['#type'] = 'hidden';

    $form['host']['#title'] = $this->t('Hosted Solr Host');
    $form['host']['#description'] = $this->t('Just copy & paste the "Host" value of the Solr index as shown in your Hosted Solr account.');

    $form['auth']['#title'] = $this->t('Hosted Solr Credentials');
    $form['auth']['#description'] = $this->t('Just copy & paste the "User" and "Password" values of the Solr index as shown in your Hosted Solr account.');

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $form_state->setValue('path', '/' . $values['auth']['username']);

    $this->basicAuthTraitSubmitConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  protected function createClient(array &$configuration) {
    $adapter = new Http();
    $adapter->setTimeout($configuration['timeout'] ?? 5);
    return new Client($adapter, $this->eventDispatcher);
  }

  /**
   * {@inheritdoc}
   */
  public function pingServer() {
    return $this->pingCore();
  }

  /**
   * {@inheritdoc}
   */
  public function getServerInfo($reset = FALSE) {
    return $this->getCoreInfo($reset);
  }

  /**
   * {@inheritdoc}
   */
  public function reloadCore() {
    return FALSE;
  }

}
