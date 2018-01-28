<?php
    require 'models/Sentence.php';
    require 'models/Lang.php';

    class SentenceController {
        public static $path = '/?controller=sentence&action=';

        public function index() {
          $filterMissing = filter_input(INPUT_POST,'ONLYMISSING');
          $filterBasic = filter_input(INPUT_POST,'ONLYBASIC');
          $filterLanguages = $_POST['LANGUAGESSELECTED'];
          Util::must_connected('/','TRA');
          $path= $this::$path . 'actionSentence';
          $allLangs = Lang::findAll();
          if(!empty($filterLanguages)){
            foreach ($allLangs as $key => $value) {
              if(in_array($value->getLang(),$filterLanguages)){
                $listLangs[] =$value;
              }
            }
          } else {
            $listLangs = $allLangs;
          }


          if (empty($filterBasic)){
            $allSentences = Sentence::findAll();
          } else {
            $allSentences = Sentence::findAllInternal();
          }

          $listSentencesByID = array();

          foreach ($allSentences as $key => $value) {
            if(empty($filterLanguages) || in_array($value->getLang(),$filterLanguages)){
              $listSentencesByID[$value->getId()][$value->getLang()] = $value;
            }
          }

          if(!empty($filterMissing)){
            foreach ($listSentencesByID as $key => $value) {
              if (count($value) == count($listLangs)){
                unset($listSentencesByID[$key]);
              }
            }
          }

          require 'views/sentence/viewall.php';
        }

        public function actionSentence(){
          Util::must_connected('/','TRA');
          $newlanguagecode = filter_input(INPUT_POST,"LANGUAGECODE");
          $newlanguagename = filter_input(INPUT_POST,"LANGUAGENAME");

          if (isset($newlanguagecode) && isset($newlanguagename)){
            if (empty($newlanguagecode) || empty($newlanguagename) ||strlen($newlanguagecode) != 5 || $newlanguagecode[2]!='.' || !ctype_alpha(substr($newlanguagecode,0,2).substr($newlanguagecode,3,2))){
              new Alert('danger','Wrong language format');
              Util::redirect_to('/?controller=sentence');
              exit;
            } else {
              Util::must_connected('/','ADM');
              $language = new Lang(null);
              $language->setLang($newlanguagecode);
              $language->setName($newlanguagename);
              Lang::insert($language);
              new Alert('success','New Language added!');
              Util::back();
              exit;
            }
          }

          $lang = filter_input(INPUT_POST,"LANG");
          $sentenceToAdd = filter_input(INPUT_POST,"SENTENCE");
          $id = filter_input(INPUT_POST,"SENTENCEID");
          $newSentence = new Sentence(null);
          $newSentence->setLang($lang);
          $newSentence->setSentence($sentenceToAdd);
          $listLangs = Lang::findAll();
          if(!in_array($lang,$listLangs)){
            new Alert('danger','An error occured: No such langage: ');
            Util::redirect_to($path);
          }

          if (empty($id)){
            Sentence::insertNew($newSentence);
          } else {
            $newSentence->setID($id);
            Sentence::insertOrUpdateAccordingID($newSentence);
          }
          Util::back();
        }

    }

?>
