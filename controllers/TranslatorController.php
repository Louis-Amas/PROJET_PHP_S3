<?php
require 'models/Translator.php';
require_once 'models/Lang.php';
require      'models/ToTranslate.php';

class TranslatorController {

  public static $path = '/?controller=translator&action=';

  public function index() {
      $this->translator();
  }

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

  public function showUserTranslation() {
    $listAsk = ToTranslate::findByUserId($_SESSION['USER']['id']);
    if(Util::can_acces('TRA')){
      $listAll = ToTranslate::findAll();
    }
    require 'views/translator/showUserTranslation.php';
  }
  /*
   *   Affiche la vue de demande de traduction
   *
   *
   *
   */
  public function askForTranslate() {
    Util::must_connected('/?controller=user&action=loginPage');
    Util::can_acces('PRE');
    $path = $this::$path . 'askForTranslateAction';
    $langs = Lang::findAllUsable();
    require 'views/translator/askTranslate.php';
  }
  /*
   * Action de la vue demande de traduction verifier les données.
   *
   */
  public function askForTranslateAction() {
    Util::must_connected('/?controller=user&action=loginPage');
    Util::can_acces('PRE');
    $langS    = filter_input(INPUT_POST, 'LANGS');
    $langD    = filter_input(INPUT_POST, 'LANGD');
    $sentence = filter_input(INPUT_POST, 'SENTENCE');
    $result   = ToTranslate::findByLangDLangSAndSentence($sentence, $langS, $langD);
    if ($result === null) {
      $result   = ToTranslate::insert($sentence, $_SESSION['USER']['id'],  $langS, $langD);
      new Alert('success', 'ASK_TRANSLATE_OK');
      Util::redirect_to($this::$path . 'translator');
    }
    else {
      new Alert('danger', 'ASK_TRANSLATE_BAD');
      Util::redirect_to($this::$path . 'askForTranslate');
    }
  }

  public function destroy() {

  }
}
