<?php

namespace Drupal\bc_user\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\StringTextareaWidget;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;

/**
 * Plugin implementation of the 'bc_notes_widget' widget.
 *
 * @FieldWidget(
 *   id = "bc_notes_widget",
 *   label = @Translation("BC Notes"),
 *   field_types = {
 *     "bc_notes"
 *   }
 * )
 */
class BcNotesWidget extends StringTextareaWidget { //} WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $allowed_formats = $this->getFieldSetting('allowed_formats');
    $element['value'] = [
      '#type' => 'text_format',
      '#title' => $this->t('BC Notes'),
      '#default_value' => isset($items[$delta]->value) ? $items[$delta]->value : '',
      '#format' => isset($items[$delta]->format) ? $items[$delta]->format : filter_default_format(),
      '#rows' => 3,
      '#weight' => $element['#weight'] ?? 0,
    ];
    $element['uid'] = [
      '#type' => 'textfield',
      '#title' => $this->t('UID'),
      '#default_value' => isset($items[$delta]->uid) ? $items[$delta]->uid : \Drupal::currentUser()->id(),
      '#size' => 60,
      '#maxlength' => 128,
      '#required' => $element['#required'],
      '#weight' => $element['#weight'] ?? 1,
    ];
    $element['created'] = [
      '#type' => 'number',
      '#title' => $this->t('Created'),
      '#default_value' => isset($items[$delta]->created) ? $items[$delta]->created : time(),
      '#weight' => 2,
    ];
    $element['updated'] = [
      '#type' => 'number',
      '#title' => $this->t('Updated'),
      '#default_value' => isset($items[$delta]->updated) ? $items[$delta]->updated : time(),
      '#weight' => 3,
    ];

    return $element;
  }
}
