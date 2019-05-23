<?php
    class Sujets
    {
        private $id_sujets;
        private $titre_sujets;
        private $texte_sujets;
        private $date_creation_sujets;
        private $username;

        public function __construct($param_id_sujets = 0, $param_titre_sujets = "", $param_texte_sujets = "",$param_date_creation_sujets="", $param_username = "")
        {
            $this->setIdSujets($param_id_sujets);
            $this->setTitreSujets($param_titre_sujets);
            $this->setTexteSujets($param_texte_sujets);
            $this->setDateCreationSujets($param_date_creation_sujets);
            $this->setUsername($param_username);
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
                trigger_error("Doit être numérique....", E_USER_ERROR);
        }

        /**
         * @return string
         */
        public function getTitreSujets()
        {
            return $this->titre_sujets;
        }

        /**
         * @param string $titre_sujets
         */
        public function setTitreSujets($titre_sujets)
        {
            if(is_string($titre_sujets))
                $this->titre_sujets = $titre_sujets;
            else
                trigger_error("Le nom doit être une chaine de caractères....", E_USER_ERROR);
        }

        /**
         * @return string
         */
        public function getTexteSujets()
        {
            return $this->texte_sujets;
        }

        /**
         * @param string $texte_sujets
         */
        public function setTexteSujets($texte_sujets)
        {
            if(is_string($texte_sujets))
                $this->texte_sujets = $texte_sujets;
            else
                trigger_error("Le texte doit être une chaine de caractères....", E_USER_ERROR);
        }

        /**
         * @return string
         */
        public function getDateCreationSujets()
        {
            return $this->date_creation_sujets;
        }

        /**
         * @param string $date_creation_sujets
         */
        public function setDateCreationSujets($date_creation_sujets)
        {
            //****On ne vérifie pas la validité de la date mais le fait qu'elle soit une chaine
            //Sinon il y aurait
            //https://www.developpez.net/forums/d1848196/php/langage/syntaxe/poo-setter-validation/
            if(is_string($date_creation_sujets))
                $this->date_creation_sujets = $date_creation_sujets;
            else
                trigger_error("La date doit être une chaine de caractères....", E_USER_ERROR);
        }

        /**
         * @return int
         */
        public function getUsername()
        {
            return $this->username;
        }

        /**
         * @param int $username
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