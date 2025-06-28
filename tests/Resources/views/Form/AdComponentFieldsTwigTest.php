<?php

namespace ADComponentBundle\Tests\Resources\views\Form;

use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Symfony\Component\Form\FormView;

class AdComponentFieldsTwigTest extends TestCase
{
    private $twig;

    protected function setUp(): void
    {
        $loader = new FilesystemLoader([
            __DIR__ . '/../../../../Resources/views/Form',
            __DIR__ . '/../../views',
        ]);

        $this->twig = new Environment($loader);
        $this->twig->addFunction(new \Twig\TwigFunction('ad_component_get_layout', function () {
            return 'base.html.twig'; // o cualquier layout dummy
        }));

    }

    public function testFormWidgetRendersHelp()
    {
        $view = new FormView();
        $view->vars['ad_component_help'] = 'Este es un mensaje de ayuda';

        $template = $this->twig->load('ad_component_fields.html.twig');
        $output = $template->renderBlock('form_widget', [
            'form' => $view,
            'ad_component_help' => $view->vars['ad_component_help'], // 🔥 este es el truco
        ]);

        $this->assertStringContainsString('alert-info', $output);
        $this->assertStringContainsString('Este es un mensaje de ayuda', $output);
    }

    public function testFormWidgetSimpleWithPreIconAddon()
    {
        $view = new FormView();
        $view->vars['value'] = ''; // valor del campo
        $view->vars['ad_component_addon_type_pre'] = 'icon';
        $view->vars['ad_component_addon_content_pre'] = 'fa-user';
        $view->vars['ad_component_addon_attr_pre'] = ['class' => 'icono'];

        $template = $this->twig->load('ad_component_fields.html.twig');

        $output = $template->renderBlock('form_widget_simple', [
            'form' => $view,
            'ad_component_addon_type_pre' => $view->vars['ad_component_addon_type_pre'],
            'ad_component_addon_content_pre' => $view->vars['ad_component_addon_content_pre'],
            'ad_component_addon_attr_pre' => $view->vars['ad_component_addon_attr_pre'],
            'value' => $view->vars['value'],
        ]);

        $this->assertStringContainsString('input-group', $output);
        $this->assertStringContainsString('<i', $output);
        $this->assertStringContainsString('fa-user', $output);
    }

    public function testFormWidgetSimpleWithPostIconAddon()
    {
        $view = new FormView();
        $view->vars['value'] = '';
        $view->vars['ad_component_addon_type_post'] = 'icon';
        $view->vars['ad_component_addon_content_post'] = 'fa-lock';
        $view->vars['ad_component_addon_attr_post'] = ['class' => 'icono'];

        $template = $this->twig->load('ad_component_fields.html.twig');

        $output = $template->renderBlock('form_widget_simple', [
            'form' => $view,
            'ad_component_addon_type_post' => $view->vars['ad_component_addon_type_post'],
            'ad_component_addon_content_post' => $view->vars['ad_component_addon_content_post'],
            'ad_component_addon_attr_post' => $view->vars['ad_component_addon_attr_post'],
            'value' => $view->vars['value'],
        ]);

        $this->assertStringContainsString('input-group', $output);
        $this->assertStringContainsString('<i', $output);
        $this->assertStringContainsString('fa-lock', $output);
    }
    public function testFormWidgetSimpleWithPreButtonAddon()
    {
        $view = new FormView();
        $view->vars['value'] = '';
        $view->vars['ad_component_addon_type_pre'] = 'button';
        $view->vars['ad_component_addon_content_pre'] = 'Buscar';
        $view->vars['ad_component_addon_attr_pre'] = [
            'class' => 'btn-warning',
            'type' => 'submit'
        ];
        $view->vars['ad_component_addon_content_type_pre'] = 'text';

        $template = $this->twig->load('ad_component_fields.html.twig');

        $output = $template->renderBlock('form_widget_simple', [
            'form' => $view,
            'ad_component_addon_type_pre' => $view->vars['ad_component_addon_type_pre'],
            'ad_component_addon_content_pre' => $view->vars['ad_component_addon_content_pre'],
            'ad_component_addon_attr_pre' => $view->vars['ad_component_addon_attr_pre'],
            'ad_component_addon_content_type_pre' => $view->vars['ad_component_addon_content_type_pre'],
            'value' => $view->vars['value'],
        ]);

        $this->assertStringContainsString('<button', $output);
        $this->assertStringContainsString('Buscar', $output);
        $this->assertStringContainsString('btn', $output);
        $this->assertStringContainsString('type="submit"', $output);
    }

    public function testFormWidgetSimpleWithPostButtonAddon()
    {
        $view = new FormView();
        $view->vars['value'] = '';
        $view->vars['ad_component_addon_type_post'] = 'button';
        $view->vars['ad_component_addon_content_post'] = 'Aceptar';
        $view->vars['ad_component_addon_attr_post'] = [
            'class' => 'btn-success',
            'type' => 'button'
        ];
        $view->vars['ad_component_addon_content_type_post'] = 'text';

        $template = $this->twig->load('ad_component_fields.html.twig');

        $output = $template->renderBlock('form_widget_simple', [
            'form' => $view,
            'ad_component_addon_type_post' => $view->vars['ad_component_addon_type_post'],
            'ad_component_addon_content_post' => $view->vars['ad_component_addon_content_post'],
            'ad_component_addon_attr_post' => $view->vars['ad_component_addon_attr_post'],
            'ad_component_addon_content_type_post' => $view->vars['ad_component_addon_content_type_post'],
            'value' => $view->vars['value'],
        ]);

        $this->assertStringContainsString('<button', $output);
        $this->assertStringContainsString('Aceptar', $output);
        $this->assertStringContainsString('btn', $output);
        $this->assertStringContainsString('type="button"', $output); // validación clave
    }

    public function testFormWidgetSimpleWithAddonAndHelp()
    {
        $view = new FormView();
        $view->vars['value'] = '';
        $view->vars['ad_component_addon_type_pre'] = 'icon';
        $view->vars['ad_component_addon_content_pre'] = 'fa-user';
        $view->vars['ad_component_addon_attr_pre'] = ['class' => 'icono'];
        $view->vars['ad_component_help'] = 'Texto de ayuda visible';

        $template = $this->twig->load('ad_component_fields.html.twig');

        $output = $template->renderBlock('form_widget_simple', [
            'form' => $view,
            'ad_component_addon_type_pre' => $view->vars['ad_component_addon_type_pre'],
            'ad_component_addon_content_pre' => $view->vars['ad_component_addon_content_pre'],
            'ad_component_addon_attr_pre' => $view->vars['ad_component_addon_attr_pre'],
            'ad_component_help' => $view->vars['ad_component_help'],
            'value' => $view->vars['value'],
        ]);

        $this->assertStringContainsString('input-group', $output);
        $this->assertStringContainsString('fa-user', $output);
        $this->assertStringContainsString('alert-info', $output);
        $this->assertStringContainsString('Texto de ayuda visible', $output);
    }
    public function testFormWidgetSimpleWithPostAddonAndHelp()
    {
        $view = new FormView();
        $view->vars['value'] = '';
        $view->vars['ad_component_addon_type_post'] = 'icon';
        $view->vars['ad_component_addon_content_post'] = 'fa-lock';
        $view->vars['ad_component_addon_attr_post'] = ['class' => 'icono'];
        $view->vars['ad_component_help'] = 'Ayuda contextual con ícono post';

        $template = $this->twig->load('ad_component_fields.html.twig');

        $output = $template->renderBlock('form_widget_simple', [
            'form' => $view,
            'ad_component_addon_type_post' => $view->vars['ad_component_addon_type_post'],
            'ad_component_addon_content_post' => $view->vars['ad_component_addon_content_post'],
            'ad_component_addon_attr_post' => $view->vars['ad_component_addon_attr_post'],
            'ad_component_help' => $view->vars['ad_component_help'],
            'value' => $view->vars['value'],
        ]);

        $this->assertStringContainsString('input-group', $output);
        $this->assertStringContainsString('fa-lock', $output);
        $this->assertStringContainsString('alert-info', $output);
        $this->assertStringContainsString('Ayuda contextual con ícono post', $output);
    }
    public function testFormWidgetSimpleWithoutAddonsOrHelp()
    {
        $view = new FormView();
        $view->vars['value'] = '';

        $template = $this->twig->load('ad_component_fields.html.twig');

        $output = $template->renderBlock('form_widget_simple', [
            'form' => $view,
            'value' => $view->vars['value'],
        ]);

        // Este es el fallback: parent() definido en base.html.twig
        $this->assertStringContainsString('<input type="text"', $output);
        $this->assertStringNotContainsString('input-group', $output);
        $this->assertStringNotContainsString('alert-info', $output);
        $this->assertStringNotContainsString('<i ', $output);
        $this->assertStringNotContainsString('<button', $output);
    }
    public function testIconWidgetRendersWithValueAsIconClass()
    {
        $view = new FormView();
        $view->vars['value'] = 'fa-check';

        $template = $this->twig->load('ad_component_fields.html.twig');

        $output = $template->renderBlock('icon_widget', [
            'form' => $view,
            'value' => $view->vars['value'],
        ]);

        $this->assertStringContainsString('input-group', $output);
        $this->assertStringContainsString('<i', $output);
        $this->assertStringContainsString('fa-check', $output);
    }
    public function testRatingWidgetRendersCorrectlyWithValue3()
    {
        $view = new FormView();
        $view->vars['value'] = 3;
        $view->vars['rating_values'] = [1, 2, 3, 4, 5];
        $view->vars['rating_icon_base'] = 'fa-star-o';
        $view->vars['rating_icon_check'] = 'fa-star';
        $view->vars['rating_labels'] = [
            1 => 'Pésimo',
            2 => 'Malo',
            3 => 'Normal',
            4 => 'Muy Bueno',
            5 => 'Excelente'
        ];
        $view->vars['rating_label_empty'] = 'Sin puntuar';
        $view->vars['rating_min'] = 1;

        $template = $this->twig->load('ad_component_fields.html.twig');

        $output = $template->renderBlock('rating_widget', [
            'form' => $view,
            'value' => $view->vars['value'],
            'rating_values' => $view->vars['rating_values'],
            'rating_icon_base' => $view->vars['rating_icon_base'],
            'rating_icon_check' => $view->vars['rating_icon_check'],
            'rating_labels' => $view->vars['rating_labels'],
            'rating_label_empty' => $view->vars['rating_label_empty'],
            'rating_min' => $view->vars['rating_min'],
        ]);

        $this->assertStringContainsString('ad_component-rating', $output);
        $this->assertEquals(3, substr_count($output, 'class="fa fa-2x fa-star"'));
        $this->assertEquals(2, substr_count($output, 'class="fa fa-2x fa-star-o"'));
        $this->assertStringContainsString('Normal', $output);      // etiqueta
    }
    public function testRatingWidgetWithEmptyValueShowsLabelEmpty()
    {
        $view = new FormView();
        $view->vars['value'] = null;
        $view->vars['rating_values'] = [1, 2, 3, 4, 5];
        $view->vars['rating_icon_base'] = 'fa-star-o';
        $view->vars['rating_icon_check'] = 'fa-star';
        $view->vars['rating_labels'] = [
            1 => 'Pésimo',
            2 => 'Malo',
            3 => 'Normal',
            4 => 'Muy Bueno',
            5 => 'Excelente'
        ];
        $view->vars['rating_label_empty'] = 'Sin puntuar';
        $view->vars['rating_min'] = 1;

        $template = $this->twig->load('ad_component_fields.html.twig');

        $output = $template->renderBlock('rating_widget', [
            'form' => $view,
            'value' => $view->vars['value'],
            'rating_values' => $view->vars['rating_values'],
            'rating_icon_base' => $view->vars['rating_icon_base'],
            'rating_icon_check' => $view->vars['rating_icon_check'],
            'rating_labels' => $view->vars['rating_labels'],
            'rating_label_empty' => $view->vars['rating_label_empty'],
            'rating_min' => $view->vars['rating_min'],
        ]);

        $this->assertEquals(0, substr_count($output, 'class="fa fa-2x fa-star"'));
        $this->assertEquals(5, substr_count($output, 'class="fa fa-2x fa-star-o"'));
        $this->assertStringContainsString('Sin puntuar', $output);
    }
    public function testRatingWidgetWithValueBelowMinimumShowsLabelEmpty()
    {
        $view = new FormView();
        $view->vars['value'] = 0; // < rating_min
        $view->vars['rating_values'] = [1, 2, 3, 4, 5];
        $view->vars['rating_icon_base'] = 'fa-star-o';
        $view->vars['rating_icon_check'] = 'fa-star';
        $view->vars['rating_labels'] = [
            1 => 'Pésimo',
            2 => 'Malo',
            3 => 'Normal',
            4 => 'Muy Bueno',
            5 => 'Excelente'
        ];
        $view->vars['rating_label_empty'] = 'Sin calificación';
        $view->vars['rating_min'] = 1;

        $template = $this->twig->load('ad_component_fields.html.twig');

        $output = $template->renderBlock('rating_widget', [
            'form' => $view,
            'value' => $view->vars['value'],
            'rating_values' => $view->vars['rating_values'],
            'rating_icon_base' => $view->vars['rating_icon_base'],
            'rating_icon_check' => $view->vars['rating_icon_check'],
            'rating_labels' => $view->vars['rating_labels'],
            'rating_label_empty' => $view->vars['rating_label_empty'],
            'rating_min' => $view->vars['rating_min'],
        ]);

        $this->assertEquals(0, substr_count($output, 'class="fa fa-2x fa-star"'));
        $this->assertEquals(5, substr_count($output, 'class="fa fa-2x fa-star-o"'));
        $this->assertStringContainsString('Sin calificación', $output);
    }

}
