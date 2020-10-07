<?php

namespace Drupal\hosted_solr\Plugin\SolrConnector;

use Drupal\Core\Form\FormStateInterface;
use Drupal\search_api_solr\SolrConnector\BasicAuthTrait;
use Drupal\search_api_solr\SolrConnector\SolrConnectorPluginBase;

/**
 * Class HostedSolrConnector.
 *
 * Extends SolrConnectorPluginBase for Hosted Solr.
 *
 * @package Drupal\hosted_solr\Plugin\SolrConnector
 *
 * @SolrConnector(
 *   id = "search_api_hosted_solr",
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
      'port' => 443,
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

    $form['path'] = [
      '#type' => 'value',
      '#value' => '/',
    ];

    $form['auth']['#title'] = $this->t('Hosted Solr Credentials');

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
