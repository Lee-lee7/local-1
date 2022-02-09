<?php

namespace Drupal\li\Form;

use Drupal\Core\Url;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;

/**
 * Defines a confirmation form to confirm deletion cat by id.
 */
class Lidelete extends ConfirmFormBase {
  /**
   * ID of the item to delete.
   *
   * @var int
   */
  protected $id;
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, string $id = NULL) {
    $this->id = $id;
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $database = \Drupal::database();
    $database->delete('li')
      ->condition('id', $this->id)
      ->execute();
    \Drupal::messenger()->addStatus('Succesfully deleted.');
    $form_state->setRedirect('hello.content');
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() : string {
    return "li_delete";
  }
  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() : Url {
    return new Url('li.content');
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    $database = \Drupal::database();
    $result = $database->select('li', 'l')
      ->fields('l', ['id'])
      ->condition('id', $this->id)
      ->execute()
      ->fetch();
    return $this->t('Do you want to delete %id?', ['%id' => $result-> id]);
  }

}