<?php
use Timber\Timber;

$values = cs_compose_values();

cs_register_element('sp-logo-slider', [
  'title' => 'SP - Logo Slider',
  'values' => $values,
  'builder' => 'logo_slider_builder_setup',
  'render' => 'logo_slider_render',
  'options' => [
    'valid_children' => ['sp-logo-slider-item'],
    'add_new_element' => ['_type' => 'sp-logo-slider-item'],
  ],
]);

function logo_slider_builder_setup()
{
  $group_sp_logo_slider = 'sp-logo-slider';
  $group_sp_logo_slider_items = $group_sp_logo_slider . ':items';

  return cs_compose_controls(
    [
      'controls' => [['type' => 'sortable', 'group' => $group_sp_logo_slider_items]],
      'control_nav' => [
        $group_sp_logo_slider => 'Logo Slider',
        $group_sp_logo_slider_items => 'Items',
      ],
    ],
    cs_partial_controls('effects'),
    cs_partial_controls('omega', ['add_custom_atts' => true])
  );
}

function logo_slider_render($data)
{
  $items = [];
  $atts = [
    'class' => array_merge(['sp-logo-slider'], $data['classes']),
  ];

  $atts = cs_apply_effect($atts, $data);

  foreach ($data['_modules'] as $key => $element) {
    $element['image'] = cs_apply_image_atts([
      'src' => $element['image_src'] ?? '',
      'retina' => $element['image_retina'] ?? '',
      'width' => $element['image_width'] ?? '',
      'height' => $element['image_height'] ?? '',
      'alt' => $element['image_alt'] ?? '',
    ]);

    $items[] = $element;
  }

  $data['items'] = $items;

  return Timber::render('@cornerstone/logo-slider/logo-slider.twig', $data);
}
