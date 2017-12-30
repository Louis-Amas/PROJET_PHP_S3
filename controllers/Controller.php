<?php
    abstract class Controller {

        //Affiche tous la bases de données du modèle associé
        abstract protected function index();
        //Affiche la page de création du modèle associé
        abstract protected function new();
        //Affiche le tuple correspondant a l'URL
        abstract protected function show();
        //Affiche la page de modification d'un Tuple
        abstract protected function edit();
        //S'osscupe de traiter les données récupérer grace au new
        abstract protected function create();
        //S'occupe de traiter les données recupérer grace au edit();
        abstract protected function update();
        //Supprime le tuple associé
        abstract protected function destroy();
    }
?>