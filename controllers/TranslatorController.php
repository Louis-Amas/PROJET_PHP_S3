<?php
require 'models/Translator.php';
require_once 'models/Lang.php';

class TranslatorController {

  public static $path = '/?controller=translator&action=';

  public function translator(){
    $path= $this::$path . 'translatorAction';
    $langs = array(fr,en,es,al);//Lang::findAll();
    require 'views/translator/translator.php';
  }

  public function translatorAction(){
    $sentenceS =filter_input(INPUT_POST, 'SENTENCE');
    $langS =filter_input(INPUT_POST, 'LANGS');
    $langT =filter_input(INPUT_POST, 'LANGT');
    $sentence = new SENTENCE('');
    $sentence->setSentence($sentenceS);
    $sentence->setLang($langS);
    $translated = Translator::getTradByLang($sentence,$langT);
    $returnArray = array("begin"=> array("sentence" => $sentenceS, "language" => $langS), "translated"=> array("sentence" => $translated->getSentence(), "language" => $langT));
    Util::redirect_to($this::$path . 'translator&information='.json_encode($returnArray));
  }

  public function destroy() {

  }
}
