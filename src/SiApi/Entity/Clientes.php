<?php

namespace SiApi\Entity;


class Clientes
 {
        private $name;
     private $email;
     private $doc;
     private $tipo;

     /**
      * @return mixed
      */
     public function getName()
     {
                return $this->name;
     }

     /**
      * @param mixed $name
      */
     public function setName($name)
     {
                $this->name = $name;
            }

     /**
      * @return mixed
      */
     public function getEmail()
     {
                return $this->email;
     }

     /**
      * @param mixed $email
      */
     public function setEmail($email)
     {
                $this->email = $email;
            }

     /**
      * @return mixed
      */
     public function getDoc()
     {
                return $this->doc;
     }

     /**
      * @param mixed $doc
      */
     public function setDoc($doc)
     {
                $this->doc = $doc;
            }

     /**
      * @return mixed
      */
     public function getTipo()
     {
                return $this->tipo;
     }

     /**
      * @param mixed $tipo
      */
     public function setTipo($tipo)
     {
                $this->tipo = $tipo;
            }

     public function getAll(){
                $cli = [
                        'clientes' =>[
                                    [
                                            'nome' => 'Jovair',
                                            'email' => 'jovair@hotmail.com',
                                            'doc' => '000.111.222-62',
                                            'tipo' =>'cpf'
                                            ],
                                    [
                                            'nome' => 'Nelson',
                                            'email' => 'nelson@hotmail.com',
                                            'doc' => '002.131.229-33',
                                            'tipo' =>'cpf'
                                            ],
                                    [
                                            'nome' => 'Richard',
                                            'email' => 'richard@hotmail.com',
                                            'doc' => '220.115.242-09',
                                            'tipo' =>'cpf'
                                            ],
                                ]
                        ];
                return $cli;
     }
 }