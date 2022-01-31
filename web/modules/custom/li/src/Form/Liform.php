<?php
namespace Drupal\li\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\MessageCommand;
use Drupal\Core\Messenger\Messenger;


class Liform extends FormBase {


  public function getFormId() {
    return 'collect_phone';
  }

 
  public function buildForm(array $form, FormStateInterface $form_state) {
  

    $form['name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Your cat’s name:'),
      '#placeholder' => $this->t("min 2 ---- max 32 symbols"),
      //'#description' => $this->t('min-2 ---- max-32'),
      '#required' => TRUE
    );
    $form['email'] = [
      '#title' => 'Your email:',
      '#type' => 'email',
      '#required' => TRUE,
      '#placeholder' => $this->t('Email can only contain Latin letters, "_" or "-" '),
     // '#description' => $this->t('Email can only contain Latin letters, "_" or "-" '),
      '#ajax' => [
        'callback' => '::validateEmailAjax',
        'event' => 'change',
        'progress' => array(
          'type' => 'throbber',
          'message' => t('Verifying email..'),
        ),
      ],
      '#suffix' => '<div class="email-validation-message"></div>'
    ];
    $form['my_file']['image_dir'] = [
      '#type' => 'managed_file',
      '#title' => 'Add image:',
      '#name' => 'my_custom_file',
      '#description' => $this->t('jpg, png, jpeg <br> max-size: 2MB'),
      '#required' => TRUE,
      '#upload_validators' => [
        'file_validate_is_image' => array(),
        'file_validate_extensions' => array('png jpg jpeg'),
        'file_validate_size' => array(25600000)
      ],
      '#upload_location' => 'public://'
    ];

    
    
   
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
    $My_File = $form_state->getValue(['my_file' => 'image_dir']);
    if (empty($My_File)) {
      $form_state->setErrorByName('my_file', $this->t('No image found'));
    }
  }

  public function validateEmailAjax(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();
    $input = $form_state->getValue('email');
    $regex = '/^[A-Za-z_\-]+@\w+(?:\.\w+)+$/';
    if (preg_match($regex, $input)) {
    $response->addCommand(new MessageCommand(t('Email valid')));
    }
    else {
    $response->addCommand(new MessageCommand(t('E-mail name can only contain latin characters, hyphens and underscores.'), NULL, ['type' => 'error']));
    }
    return $response;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger()->addStatus('Hello) This is perfect name!' );
  }
  function callback($form, $form_state) {
    return $form['name'];
  }
}