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
    if (!Util::can_acces('NOR')){
      if(!empty($_SESSION['NEXTTRAD'])){
        if ($_SESSION['NEXTTRAD'] > new DateTime()){
          new Alert('danger',text('10_MINUTES_WAIT'));
          Util::redirect_to('/');
        }
      }
      $dateEnd = new DateTime();
      $dateEnd->add(new DateInterval('PT10M'));
      $_SESSION['NEXTTRAD'] = $dateEnd ;
    }
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
    }elseif(Util::can_acces('PRE')){
      $showModal = 'true';
    }
    require 'views/translator/translator.php';
  }

  public function showUserTranslation() {
    Util::must_connected('/','PRE');
    $listLangs = Lang::findAll();
    $listAsk = ToTranslate::findByUserId($_SESSION['USER']['id']);
    if(Util::can_acces('TRA')){
      $listAll = ToTranslate::findAll();
    }
    if(!empty($_POST)){
      $sentenceFrom = filter_input(INPUT_POST,'SENTENCEFROM');
      $sentenceTo = filter_input(INPUT_POST,'SENTENCETO');
      $langFrom= filter_input(INPUT_POST,'langFrom');
      $langTo= filter_input(INPUT_POST,'langTo');
      $newSentence1 = Sentence::findBySentenceAndLang($sentenceFrom,$langFrom);
      $newSentence2 = Sentence::findBySentenceAndLang($sentenceTo,$langTo);
      $askID = filter_input(INPUT_POST,'askID');
      if (!$newSentence1 && !$newSentence2){
        $newSentence1 = new Sentence(null);
        $newSentence1->setSentence($sentenceFrom);
        $newSentence1->setLang($langFrom);
        if (Sentence::insertNew($newSentence1)) {
          $newSentence1 = Sentence::findBySentenceAndLang($sentenceFrom,$langFrom);
          $newSentence2 = new Sentence(null);
          $newSentence2->setSentence($sentenceTo);
          $newSentence2->setLang($langTo);
          $newSentence2->setID($newSentence1->getID());
          Sentence::insertOrUpdateAccordingID($newSentence2);
        }

      } elseif ($newSentence1 && !$newSentence2 ) {
        $newSentence2 = new Sentence(null);
        $newSentence2->setSentence($sentenceTo);
        $newSentence2->setLang($langTo);
        $newSentence2->setID($newSentence1->getID());
        Sentence::insertOrUpdateAccordingID($newSentence2);
      } elseif (!$newSentence1 && $newSentence2 ) {
        $newSentence1 = new Sentence(null);
        $newSentence1->setSentence($sentenceFrom);
        $newSentence1->setLang($langFrom);
        $newSentence1->setID($newSentence2->getID());
        Sentence::insertOrUpdateAccordingID($newSentence1);
      } else {
          new Alert('success',"Translation already exist !");
          $totranslate = ToTranslate::findById($askID);
          if(!empty($totranslate))
            $totranslate->updateStatus('DENIED');
          Util::back();
          return;
      }
      $totranslate = ToTranslate::findById($askID);
      if(!empty($totranslate))
        $totranslate->updateStatus('ACCEPTED');
      Util::back();
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
      new Alert('success', text('ASK_TRANSLATE_OK'));
      Util::redirect_to($this::$path . 'translator');
    }
    else {
      new Alert('danger', text('ASK_TRANSLATE_BAD'));
      Util::redirect_to($this::$path . 'askForTranslate');
    }
  }

  public function destroy() {

  }
}
