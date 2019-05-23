<?php
class Usager
{
    private $username;
    private $password;
    private $banni;
    private $admin;

    public function __construct($param_username = "", $param_password = "", $param_banni =false,$param_admin=false)
    {
        $this->setUsername($param_username);
        $this->setPassword($param_password);
        $this->setBanni($param_banni);
        $this->setAdmin($param_admin);
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
            trigger_error("Le nom doit être une chaine de caractères....", E_USER_ERROR);
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        //https://stackoverflow.com/questions/8297995/filter-var-for-password/8298050
        //There is no need for sanitizing your password as you need to hash it anyway.
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getBanni()
    {
        return $this->banni;
    }

    /**
     * @param string $banni
     */
    public function setBanni($banni)
    {
        //if(filter_var($banni, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))
        if(is_bool($banni))
            $this->banni = $banni;
        else
            trigger_error("Doit être booléen....", E_USER_ERROR);
    }

    /**
     * @return string
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param string $admin
     */
    public function setAdmin($admin)
    {
        //if(filter_var($admin, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))
        if(is_bool($admin))
            $this->admin = $admin;
        else
            trigger_error("Doit être booléen....", E_USER_ERROR);
    }

}

?>