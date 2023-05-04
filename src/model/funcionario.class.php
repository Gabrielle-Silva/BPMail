<?php

class funcionarioModel
{

    //atributos
    private $id;
    private $Contrato;
    private $Nome;
    private $Email;



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
     * Get the value of Contrato
     */
    public function getContrato()
    {
        return $this->Contrato;
    }

    /**
     * Set the value of Contrato
     *
     * @return  self
     */
    public function setContrato($Contrato)
    {
        $this->Contrato = $Contrato;

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




    public function deleteFuncionario()
    {

        global $conn;
        try {
            $sql = "DELETE from funcionarios WHERE Id = {$this->id}";

            if (mysqli_query($conn, $sql)) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function readFuncionario()
    {

        global $conn;
        try {
            $sql = "SELECT * from funcionarios ORDER BY Nome";
            return mysqli_query($conn, $sql);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }



    public function createFuncionario()
    {

        global $conn;
        try {
            $sql = "INSERT INTO funcionarios (Contrato, Nome, Email) VALUES ('{$this->Contrato}','{$this->Nome}','{$this->Email}')";

            if (mysqli_query($conn, $sql)) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public function updateFuncionario()
    {

        global $conn;
        try {
            $sql = "UPDATE funcionarios SET Contrato = '{$this->Contrato}', Nome ='{$this->Nome}', Email ='{$this->Email}' WHERE Id = {$this->id}";

            if (mysqli_query($conn, $sql)) {
                return true;
            } else {
                return false;
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
