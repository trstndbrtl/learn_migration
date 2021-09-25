<?php

namespace Drupal\learn_migration\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SettingsMigrationForm extends ConfigFormBase {

   /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['learn_migration.settings'];
  }

  /**
   * {@inheritdoc}
   */

  public function getFormId() {
    return 'learn_migration_store_form';
  }

  /**
   * Form constructor.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The form structure.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = array();

    $config = $this->config('learn_migration.settings');

    $form['users_url_form'] = [
      '#type' => 'text_format',
      '#format' => 'plain_text',
      '#title' => $this->t('User Api'),
      '#default_value' => $config->get('users_url_form') ? $config->get('users_url_form') : '',
      // '#description' => $this->t(''),
      '#prefix' => '<div id="users-url-form-wrapper">',
      '#suffix' => 'Entrez une url par ligne, dans le format url|libellé.</div>',
    ];

    $form['terms_url_form'] = [
      '#type' => 'text_format',
      '#format' => 'plain_text',
      '#title' => $this->t('Terms Api'),
      '#default_value' => $config->get('terms_url_form') ? $config->get('terms_url_form') : '',
      // '#description' => $this->t(''),
      '#prefix' => '<div id="terms-url-form-wrapper">',
      '#suffix' => 'Entrez une url par ligne, dans le format url|libellé.</div>',
    ];

    $form['nodes_url_form'] = [
      '#type' => 'text_format',
      '#format' => 'plain_text',
      '#title' => $this->t('Node Api'),
      '#default_value' => $config->get('nodes_url_form') ? $config->get('nodes_url_form') : '',
      // '#description' => $this->t(''),
      '#prefix' => '<div id="nodes-url-form-wrapper">',
      '#suffix' => 'Entrez une url par ligne, dans le format url|libellé.</div>',
    ];

    $form['media_url_base'] = array(
      '#title' => t('Base medias Url path'),
      '#type' => 'textfield',
      '#default_value' => $config->get('media_url_base') ? $config->get('media_url_base') : '',
      '#prefix' => '<div id="media-url-form-wrapper">',
      '#suffix' => 'Veuillez entrer la base url pour accéder aux images.</div>',
    );

    $form_state->setCached(FALSE);

    $form = parent::buildForm($form, $form_state);

    $form['actions'] = [
      '#type' => 'actions',
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Enregistrer'),
    ];

    return $form;

  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->config('learn_migration.settings')
      ->set('users_url_form', $form_state->getValue('users_url_form')['value'])
      ->set('terms_url_form', $form_state->getValue('terms_url_form')['value'])
      ->set('nodes_url_form', $form_state->getValue('nodes_url_form')['value'])
      ->set('media_url_base', $form_state->getValue('media_url_base'))
      ->save();

    $messenger = \Drupal::messenger();
    $messenger->addMessage('Les modifications ont été enregistrés.');
  }

}