<?php

class emailModel
{

    //atributos
    private $id;
    private $Nome;
    private $Email;
    private $arrFunc;
    private $Mensagem;
    private $Arquivos;

    private $objValidar;

    /**
     * Get the value of cod
     */
    public function getObjValidar()
    {
        return $this->objValidar;
    }

    /**
     * Set the value of cod
     *
     * @return  self
     */
    public function setObjValidar($objValidar)
    {
        $this->objValidar = $objValidar;

        return $this;
    }


    //GETTERS / SETTERS

    /**
     * Get the value of cod
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of cod
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of Nome
     */
    public function getNome()
    {
        return $this->Nome;
    }

    /**
     * Set the value of Nome
     *
     * @return  self
     */
    public function setNome($Nome)
    {
        $this->Nome = $Nome;

        return $this;
    }

    /**
     * Get the value of Email
     */
    public function getEmail()
    {
        return $this->Email;
    }

    /**
     * Set the value of Email
     *
     * @return  self
     */
    public function setEmail($Email)
    {
        $this->Email = $Email;

        return $this;
    }

    /**
     * Get the value of arrFunc
     */
    public function arrFunc()
    {
        return $this->arrFunc;
    }

    /**
     * Set the value of arrFunc
     *
     * @return  self
     */
    public function setArrFunc($arrFunc)
    {
        $this->arrFunc = $arrFunc;

        return $this;
    }

    /**
     * Get the value of Mensagem
     */
    public function getMensagem()
    {
        return $this->Mensagem;
    }

    /**
     * Set the value of Mensagem
     *
     * @return  self
     */
    public function setMensagem($Mensagem)
    {
        $this->Mensagem = $Mensagem;

        return $this;
    }

    /**
     * Get the value of Arquivos
     */
    public function getArquivos()
    {
        return $this->Arquivos;
    }

    /**
     * Set the value of Arquivos
     *
     * @return  self
     */
    public function setArquivos($Arquivos)
    {
        $this->Arquivos = $Arquivos;

        return $this;
    }



    public function read()
    {

        global $conn;
        try {
            $sql = "SELECT * from funcionarios WHERE id IN ({$this->arrFunc})";

            return mysqli_query($conn, $sql);
        } catch (\Throwable $th) {
        }
    }
}
