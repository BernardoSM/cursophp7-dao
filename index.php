<?php 

require_once("config.php"); //o arquivo config chama todas as classes (em arquivos diferentes)

$root = new Usuario(); //a variavel root receberá o tratamento da classe Usuario, que no caso foi criada para chamar todos os valores da tabela e retorná-los para serem exibidos

$root->loadbyID(3); //o loadbyId é a classe que seleciona em qual índice de usuário eu quero as informações

echo $root;

 ?>