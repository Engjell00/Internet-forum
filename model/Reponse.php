<?php
    class Reponse
    {
        private $id_reponse;
        private $titre_reponse;
        private $texte_reponse;
        private $date_creation_reponse;
        private $id_sujets;
        private $username;

        /**
         * Reponse constructor.
         * @param $id_reponse
         * @param $titre_reponse
         * @param $texte_reponse
         * @param $date_creation_reponse
         * @param $id_sujet
         * @param $username
         */
        public function __construct($id_reponse = 0, $titre_reponse = "", $texte_reponse = "", $date_creation_reponse = "", $id_sujets = 0, $username= "")
        {
            $this->setIdReponse($id_reponse);
            $this->setTitreReponse($titre_reponse);
            $this->setTexteReponse($texte_reponse);
            $this->setDateCreationReponse($date_creation_reponse);
            $this->setIdSujets($id_sujets);
            $this->setUsername($username);
        }

        /**
         * @return int
         */
        public function getIdReponse()
        {
            return $this->id_reponse;
        }

        /**
         * @param int $id_reponse
         */
        public function setIdReponse($id_reponse)
        {
            if((filter_var($id_reponse, FILTER_VALIDATE_INT)  || (filter_var($id_reponse, FILTER_VALIDATE_INT) === 0)))
            //if(is_numeric($id_reponse))
                $this->id_reponse = $id_reponse;
            else
                trigger_error("Doit être numérique....", E_USER_ERROR);
        }

        /**
         * @return string
         */
        public function getTitreReponse()
        {
            return $this->titre_reponse;
        }

        /**
         * @param string $titre_reponse
         */
        public function setTitreReponse($titre_reponse)
        {
            if(is_string($titre_reponse))
                $this->titre_reponse = $titre_reponse;
            else
                trigger_error("Le titre doit être une chaine de caractères....", E_USER_ERROR);
        }

        /**
         * @return string
         */
        public function getTexteReponse()
        {
            return $this->texte_reponse;
        }

        /**
         * @param string $texte_reponse
         */
        public function setTexteReponse($texte_reponse)
        {
            if(is_string($texte_reponse))
                $this->texte_reponse = $texte_reponse;
            else
                trigger_error("Le texte doit être une chaine de caractères....", E_USER_ERROR);
        }

        /**
         * @return string
         */
        public function getDateCreationReponse()
        {
            return $this->date_creation_reponse;
        }

        /**
         * @param string $date_creation_reponse
         */
        public function setDateCreationReponse($date_creation_reponse)
        {
            //****On ne vérifie pas la validité de la date mais le fait qu'elle soit une chaine
            //Sinon il y aurait
            //https://www.developpez.net/forums/d1848196/php/langage/syntaxe/poo-setter-validation/
            if(is_string($date_creation_reponse))
                $this->date_creation_reponse = $date_creation_reponse;
            else
                trigger_error("Le nom doit être une chaine de caractères....", E_USER_ERROR);
        }

        /**
         * @return int
         */
        public function getIdSujets()
        {
            return $this->id_sujets;
        }

        /**
         * @param int $id_sujets
         */
        public function setIdSujets($id_sujets)
        {
            if((filter_var($id_sujets, FILTER_VALIDATE_INT)  || (filter_var($id_sujets, FILTER_VALIDATE_INT) === 0)))
            // OU   --   if(is_numeric($id_sujets))
                $this->id_sujets = $id_sujets;
            else
                trigger_error("L'ID du sujets doit être numérique....", E_USER_ERROR);
        }

        /**
         * @return string
         */
        public function getUsername()
        {
            return $this->username;
        }

        /**
         * @param string $username
         */
        public function setUsername($username)
        {
            if(is_string($username))
                $this->username = $username;
            else
                trigger_error("Le nom d'utilisateur doit être une chaine de caractères....", E_USER_ERROR);
        }

    }
?>