<?php

namespace Drupal\bc_user\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'bc_notes_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "bc_notes_formatter",
 *   label = @Translation("BC Notes Formatter"),
 *   field_types = {
 *     "bc_notes"
 *   }
 * )
 *
 */
class BcNotesFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $fieldInfo = $items->getFieldDefinition();
    $elements = [];
    foreach ($items as $delta => $item) {
      $elements[$delta] = [
        '#type' => 'processed_text',
        '#text' => $item->value,
        '#format' => $item->format,
        '#langcode' => $item->getLangcode(),
      ];
    }

    return $elements;
  }
}
