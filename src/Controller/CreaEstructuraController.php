<?php

namespace Drupal\crea_estructura\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\taxonomy\Entity\Term;
use Drupal\taxonomy\Entity\Vocabulary;

class CreaEstructuraController extends ControllerBase {

  public function content() {



    $resultado = "";

// Creación de taxonomías
  $vocab['sexo'] = array ('Hombre' => '21', 'Mujer' => '22');

  $vocab['lugar_de_nacimiento'] = array ('Artigas, Uruguay' => '82', 'Canelones, Uruguay' => '83', 'Cerro Largo, Uruguay' => '84', 'Colonia, Uruguay' => '85', 'Durazno, Uruguay' => '86', 'Flores, Uruguay' => '87', 'Florida, Uruguay' => '88', 'Lavalleja, Uruguay' => '89', 'Maldonado, Uruguay' => '90', 'Montevideo, Uruguay' => '91', 'Paysandú, Uruguay' => '92', 'Río Negro, Uruguay' => '93', 'Rivera, Uruguay' => '94', 'Rocha, Uruguay' => '95', 'Salto, Uruguay' => '96', 'San José, Uruguay' => '97', 'Soriano, Uruguay' => '98', 'Tacuarembó, Uruguay' => '99', 'Treinta y Tres, Uruguay' => '100', 'UY, dpto. desconocido' => '5', 'Alemania' => '10', 'Argentina' => '6', 'Austria' => '35', 'Bélgica' => '54', 'Bolivia' => '149', 'Brasil' => '17', 'Bulgaria' => '177', 'Cabo Verde' => '183', 'Canadá' => '168', 'Checoslovaquia' => '181', 'Chile' => '23', 'Colombia' => '194', 'Costa Rica' => '782', 'Cuba' => '34', 'Dinamarca' => '52', 'Eslovaquia' => '39', 'Egipto' => '62', 'España' => '11', 'Estados Unidos' => '16', 'Filipinas' => '722', 'Finlandia' => '153', 'Francia' => '15', 'Gibraltar' => '171', 'Grecia' => '18', 'Holanda' => '208', 'Hungría' => '30', 'Indonesia' => '273', 'Inglaterra' => '7', 'Israel' => '138', 'Irlanda' => '781', 'Italia' => '9', 'Letonia' => '139', 'Líbano' => '824', 'Lituania' => '19', 'Marruecos' => '58', 'México' => '207', 'Namibia' => '55', 'Noruega' => '750', 'Paraguay' => '33', 'Perú' => '27', 'Polonia' => '102', 'Portugal' => '40', 'República Checa' => '148', 'Rumania' => '8', 'Rusia' => '50', 'Senegal' => '60', 'Sudáfrica' => '777', 'Suecia' => '169', 'Suiza' => '51', 'Trinidad y Tobago' => '710', 'Turquía' => '20', 'Ucrania' => '14', 'Venezuela' => '46');

  foreach ($vocab as $key => $value) {

    $resultado.= "<br><br>";

    foreach ($value as $name => $tid) {

      $terminos = Term::loadMultiple();
      if (!isset($terminos[$tid])) {
        $term = Term::create([
          'vid' => $key,
          'langcode' => 'es',
          'name' => $name,
          'tid' => $tid,
        ]);
        $term->save();
        $resultado.= "<li>Taxonomia '".$name."' del vocabulario '".$key."' creada";
      } else {
        $resultado.= "<li>Taxonomia '".$name."' del vocabulario '".$key."' ya estaba creada";
      }
    }
  }

// el arreglo está compuesto por 'Nombre de termino' => ['tid', 'tidPadre']
  $vocabparent['disciplina_autoral'] = array ('Escritura' => ['1', ''], 'Música' => ['4', ''], 'Artes visuales' => ['2', ''], 'Artes escénicas' => ['12', ''], 'Audiovisual' => ['13', ''], 'Arquitectura' => ['115', '2'], 'Cerámica' => ['117', '2'], 'Dibujo' => ['112', '2'], 'Diseño gráfico' => ['460', '2'], 'Escultura' => ['114', '2'], 'Grabado' => ['113', '2'], 'Fotografía' => ['459', '2'], 'Pintura' => ['111', '2'], 'Tapiz' => ['180', '2'], 'Otras' => ['116', '2'], 'Orfebrería' => ['118', '2'], 'Animación' => ['131', '13'], 'Dirección cinematográfica' => ['129', '13'], 'Dirección televisiva' => ['130', '13'], 'Otras' => ['132', '13'], 'Crónica' => ['156', '1'], 'Dramaturgia' => ['121', '1'], 'Narrativa' => ['122', '1'], 'Periodismo' => ['127', '1'], 'Poesía' => ['120', '1'], 'Traducción' => ['125', '1'], 'No ficción' => ['123', '1'], 'Artes y humanidades' => ['800', '1'], 'Ciencias aplicadas' => ['801', '1'], 'Ciencias biológicas' => ['802', '1'], 'Ciencias físicas' => ['803', '1'], 'Ciencias formales' => ['804', '1'], 'Ciencias sociales' => ['805', '1'], 'Otras' => ['124', '1'], 'Autor de letra' => ['134', '4'], 'Autor de música' => ['135', '4'], 'Adaptación' => ['137', '4'], 'Arreglos' => ['136', '4'], 'Coreografía' => ['487', '12'], 'Pantomima' => ['488', '12'] );

  foreach ($vocabparent as $key => $value) {

    $resultado.= "<br><br>";

    foreach ($value as $name => $tid) {

      $terminos = Term::loadMultiple();
      if (!isset($terminos[$tid[0]])) {

        $parent = array();
        if (isset($tid[1])) { array_push($parent, $tid[1]); }

        $term = Term::create([
          'parent' => $parent,
          'vid' => $key,
          'langcode' => 'es',
          'name' => $name,
          'tid' => $tid[0],
        ]);
        $term->save();
        $resultado.= "<li>Taxonomia '".$name."' del vocabulario '".$key."' creada";
      } else {
        $resultado.= "<li>Taxonomia '".$name."' del vocabulario '".$key."' ya estaba creada";
      }
    }
  }

    $key = 'estatus_de_derechos';
    $resultado.= "<br><br>";
    for ($i = 0; $i <= 13; $i++) {
      $nombre = $i;

      $query = \Drupal::entityQuery('taxonomy_term')
        ->condition('vid', 'estatus_de_derechos')
        ->condition('name', $nombre);
      $tid = $query->execute();

      if (empty($tid)) {
        $term = Term::create([
          'vid' => $key,
          'langcode' => 'es',
          'name' => $nombre
        ]);
        $term->save();
        $resultado.= "<li>Taxonomia '".$nombre."' del vocabulario '".$key."' creada";
      } else {
        $resultado.= "<li>Taxonomia '".$nombre."' del vocabulario '".$key."' ya estaba creada";
      }
    }

    $arreglo['#resultado'] = array(
      '#markup' => $resultado,
      '#allowed_tags' => ['li', 'br'],
    );

    $arreglo['#theme'] = "hola";
    return $arreglo;

  }


}
