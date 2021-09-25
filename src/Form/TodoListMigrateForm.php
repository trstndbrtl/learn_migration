<?php

namespace Drupal\learn_migration\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Render\FormattableMarkup;  

class TodoListMigrateForm extends ConfigFormBase {

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
    return 'todo_list_migration_form';
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

    $form = [];
    $output = [];

    $header = [
      'ndx' => t(''),
      'stage' => t('Stage'),
      'description' => t('Description'),
      'branch' => t('Branch'),
    ];

    // Get all step
    $results = $this->getTodoList();

    // Loop all step
    $ndx = 1;
    foreach ($results as $result ) {
      $output[$result['id']] = [
        'ndx' => ['data' => $ndx , 'class' => 'db-i'],
        'stage' => ['data' => $result['stage'] , 'class' => 'db-hn'],
        'description' => ['data' => $result['description'] , 'class' => 'db-descrition'],
        'branch' => ['data' => new FormattableMarkup('<a href=":link" target="_blank">@name</a>', [':link' => $result['branch_link'], '@name' => $result['branch_name']]) , 'class' => 'db-branch'],
      ];
      $ndx++;
    }

    

    $form['table'] = [
      '#type' => 'table',
      '#header' => $header,
      '#rows' => $output,
      '#empty' => t('No task found'),
    ];

    $form_state->setCached(FALSE);

    // $form = parent::buildForm($form, $form_state);

    // $form['actions'] = [
    //   '#type' => 'actions',
    // ];

    // $form['actions']['submit'] = [
    //   '#type' => 'submit',
    //   '#value' => $this->t('Enregistrer'),
    // ];

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
  public function submitForm(array &$form, FormStateInterface $form_state) {}

  /**
   * getTodoList function.
   *  
   * @return array
   *   The array step
   */
  public function getTodoList() {
    $output = [
      [
        'id' => '1',
        'stage' => 'Installation du module learn_migration_settings', 
        'description' => 'On installe le module learn_migration_settings pour créer les types de contenus (revue, poeme, livres), ainsi que les taxonomies (domaines, figures, lieux, maison d\'édition, mouvement littéraire).',
        'branch_name' => '001-add-configuration-files',
        'branch_link' => 'https://github.com/trstndbrtl/learn_migration/tree/001-add-configuration-files',
        
      ],
    ];
    return $output;
  }

}