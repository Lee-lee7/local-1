<?php
/**
 * @file
 * Contains \Drupal\hello_world\Controller\HelloController.
 */
namespace Drupal\li\Controller;

use Drupal\file\Entity\File;
use Drupal\Core\Controller\ControllerBase;

class HelloController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {
    $form = \Drupal::formBuilder()->getForm('Drupal\li\Form\Liform');
    $build['content'] = [
      '#form' => $form,
      '#theme' => 'li_theme',
      '#text' => $this
        ->t('Hello! You can add here a photo of your cat.'),
    ];
    $header_title = [
      'name' => t('Name'),
      'email' => t('Email'),
      'image' => t('Image'),
      'timestamp' => t('Date and time'),
    ];
    $cats['table'] = [
      '#type' => 'table',
      '#header' => $header_title,
      '#rows' => $this->getCats(),
    ];
    return [$form, $cats];
  }

  /**
   * Getting data from the moliek table.
   */
  public function getCats() {
    $database = \Drupal::database();
    $result = $database->select('li', 'l')
      ->fields('l', ['name', 'email', 'image', 'timestamp'])
      ->orderBy('id', 'DESC')
      ->execute();
    $cats = [];
    foreach ($result as $cat) {
      $cats[] = [
        'name' => $cat->name,
        'email' => $cat->email,
       'image' => File::load($cat->image)->getFileUri(),
        'timestamp' => $cat->timestamp,
      ];
    }
    return $cats;
  }

}


