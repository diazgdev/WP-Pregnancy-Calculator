<?php
/*
Plugin Name: Semanas de Embarazo
Plugin URI: http://diazg.dev
Description: Calculadora de semanas de embarazo con información últil sobre el desarrollo del bebé.
Version: 1.0
Author: Guillermo Díaz
Author URI: http://diazg.dev
*/

function weeks_of_pregnancy($last_period) {
  $now = time();
  $last_period_timestamp = strtotime($last_period);
  $diff_weeks = floor(($now - $last_period_timestamp) / (7 * 24 * 60 * 60));
  return $diff_weeks;
}

function weeks_of_pregnancy_shortcode($atts) {
  $atts = shortcode_atts(array(
      'last_period' => ''
  ), $atts);

  ob_start();
  weeks_of_pregnancy_form();
  $output = ob_get_clean();

  $output .= '<div id="weeks-of-pregnancy-result"></div>';

  return $output;
}


add_shortcode('semanas_de_embarazo', 'weeks_of_pregnancy_shortcode');

function weeks_of_pregnancy_form() {
  ?>
  <form id="weeks_of_pregnancy_form">
      <label for="last-period">Selecciona la fecha de tu última regla:</label>
      <input type="text" id="last-period" name="last_period">
      <button id="submit-weeks-of-pregnancy" disabled>Calcular semanas de embarazo</button>
  </form>
  <div id="weeks-of-pregnancy-result"></div>
  <?php
}

function weeks_of_pregnancy_ajax_handler() {
  check_ajax_referer('weeks_of_pregnancy_nonce', 'nonce');

  $last_period = $_POST['last_period'];
  $weeks = weeks_of_pregnancy($last_period);

  if ($weeks == 4 || $weeks == 5) {
    echo "<h3>Actualmente tienes $weeks semanas de embarazo.</h3>";
    echo "Te encuentras entre las semanas 4 y 5: Durante esta etapa, ocurre la fertilización del óvulo por el espermatozoide y el óvulo fecundado se implanta en el revestimiento del útero, formando el embrión. El embrión comienza a desarrollarse rápidamente, formando el saco gestacional y la placenta, y se producen los primeros latidos del corazón.";
    wp_die();
  } elseif ($weeks >= 8 && $weeks <= 12 ) {
    echo "<h3>Actualmente tienes $weeks semanas de embarazo.</h3>";
    echo "Te encuentras entre las semanas 8 y 12: Durante este período, el embrión se convierte en un feto y se forman los principales órganos, como el cerebro, el corazón, los pulmones y los riñones. Se empiezan a formar los dedos de las manos y los pies, y se produce una rápida multiplicación celular. El feto comienza a moverse, aunque la madre no pueda sentirlo aún.";
    wp_die();
  } elseif ($weeks >= 16 && $weeks <= 20) {
    echo "<h3>Actualmente tienes $weeks semanas de embarazo.</h3>";
    echo "Te encuentras entre las semanas 16 y 20: Durante esta etapa, el feto comienza a moverse y a patear, y se puede sentir en el útero materno. Los órganos y los huesos del feto están ya completamente formados y los rasgos faciales se hacen más evidentes. También se realizan las primeras ecografías para detectar posibles anomalías y comprobar el crecimiento del feto.";
    wp_die();
  } elseif ($weeks >= 28 && $weeks <= 32) {
    echo "<h3>Actualmente tienes $weeks semanas de embarazo.</h3>";
    echo "Te encuentras entre las semanas 28 y 32: En este período, el feto comienza a tomar una posición adecuada para el parto, y se produce un importante aumento de peso. El útero se expande al máximo y la madre puede sentir cierta incomodidad debido al tamaño del feto. En esta etapa, el feto es lo suficientemente grande como para que se pueda escuchar su latido fetal con un estetoscopio.";
    wp_die();
  } elseif ($weeks >= 36 && $weeks <= 40) {
    echo "<h3>Actualmente tienes $weeks semanas de embarazo.</h3>";
    echo "Te encuentras entre las semanas 36 y 40: En la recta final del embarazo, se produce el parto y el nacimiento del bebé. El feto se encuentra completamente desarrollado y preparado para salir al mundo exterior. La madre puede experimentar contracciones uterinas y finalmente el bebé nace, completando así el embarazo. Durante esta etapa, el feto sigue creciendo y madurando, y la cabeza del feto se encaja en la pelvis materna, preparándose para el parto.";
    wp_die();
  } elseif ($weeks > 42) {
    echo "<h3>Debes seleccionar una fecha correcta.</h3>";
    wp_die();
  } else {
    echo "<h3>Actualmente tienes $weeks semanas de embarazo.</h3>";
    wp_die();
  }
}

add_action('wp_ajax_semanas_de_embarazo_ajax', 'weeks_of_pregnancy_ajax_handler');
add_action('wp_ajax_nopriv_semanas_de_embarazo_ajax', 'weeks_of_pregnancy_ajax_handler');

function weeks_of_pregnancy_scripts() {
  wp_enqueue_script('jquery');

  wp_register_script('weeks-of-pregnancy', plugins_url('/weeks-of-pregnancy.js', __FILE__), array('jquery'), '1.0', true);
  wp_localize_script('weeks-of-pregnancy', 'weeksOfPregnancyAjax', array('ajaxurl' => admin_url('admin-ajax.php')));
  wp_enqueue_script('weeks-of-pregnancy');

  wp_localize_script('weeks-of-pregnancy', 'weeksOfPregnancyAjax', array(
    'ajaxurl' => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('weeks_of_pregnancy_nonce')
  ));

  wp_enqueue_script('jquery');
  wp_enqueue_script('jquery-ui-datepicker');
  wp_enqueue_style('datepicker-custom', plugins_url('/datepicker-custom.css', __FILE__));

  wp_enqueue_style('jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
}

add_action('wp_enqueue_scripts', 'weeks_of_pregnancy_scripts');

?>
