<?php

class emailModel
{

    //atributos
    private $arrFunc;




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



    //METHOD

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
