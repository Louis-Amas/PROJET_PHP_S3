<?php
require 'models/Translator.php';
require_once 'models/Lang.php';
require      'models/ToTranslate.php';

class TranslatorController {

  public static $path = '/?controller=translator&action=';

  public function translator(){
    $path= $this::$path . 'translatorResult';
    $langs = Lang::findAllUsable();

    require 'views/translator/translator.php';
  }

  public function translatorResult(){
    $sentenceS =filter_input(INPUT_POST, 'SENTENCE');
    $langs = Lang::findAllUsable();
    $langS =filter_input(INPUT_POST, 'LANGS');
    $langT =filter_input(INPUT_POST, 'LANGT');
    $sentence = new SENTENCE('');
    $sentence->setSentence($sentenceS);
    $sentence->setLang($langS);
    $origin = Sentence::findBySentenceAndLang($sentenceS,$langS);
    $translated = 'No result';
    if (!is_null($origin)){
      $translated = $origin->findTranslation($langT);
    }
    //var_dump($translated);
    //die;
    require 'views/translator/translator.php';
  }

  public function askForTranslate() {
    $path = $this::$path . 'askForTranslateAction';
    $langs = Lang::findAllUsable();
    require 'views/translator/addTranslate.php';
  }

  public function askForTranslateAction() {
    $langS    = filter_input(INPUT_POST, 'LANGS');
    $langD    = filter_input(INPUT_POST, 'LANGD');
    $sentence = filter_input(INPUT_POST, 'SENTENCE');
    $sentence = Sentence::findBySentenceAndLang($sentence, $lang);
    if ($sentence === null) {
      //ajouter une nouvelle sentence
      //ajouter dans to translate

    }
    else {
      //ajouter dans to translate à l'id correspondant à sentence
    }
  }

  public function destroy() {

  }
}
