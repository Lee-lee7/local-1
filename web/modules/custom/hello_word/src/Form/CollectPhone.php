<?php
namespace Drupal\hello_world\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;


class CollectPhone extends FormBase {


  public function getFormId() {
    return 'collect_phone';
  }

 
  public function buildForm(array $form, FormStateInterface $form_state) {
  

    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your cat’s name:'),
      '#description' => $this->t('min-2 ---- max-32'),
      '#required' => TRUE
    );

   
    $form['actions']['#type'] = 'actions';
   
    $form['actions']['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Add cat'),
      '#button_type' => 'primary',
    );
    return $form;
  }

 
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('name')) < 2 ) {
      $form_state->setErrorByName('name', $this->t('Name is too short.'));
    }
    if (strlen($form_state->getValue('name')) > 32){
      $form_state->setErrorByName('name', $this->t('Name is too long.'));

    }
    
  }


  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus('Hello) This is perfect name!' );
  }
  function callback($form, $form_state) {
    return $form['name'];
  }
}