<?php 

require_once("config.php"); //o arquivo config chama todas as classes (em arquivos diferentes)


// CARREGA UM USUÁRIO
//$root = new Usuario(); //a variavel root receberá o tratamento da classe Usuario, que no caso foi criada para chamar todos os valores da tabela e retorná-los para serem exibidos
//$root->loadbyID(3); //o loadbyId é a classe que seleciona em qual índice de usuário eu quero as informações (apenas um usuário)
//echo $root;

//CARREGA UMA LISTA DE USUÁRIOS
//$lista = Usuario::getList();
//echo json_encode($search);

//CARREGA UMA LISTA DE USUÁRIOS BUSCANDO PELO LOGIN
//$search = Usuario::search("jo"); //retorna os usuários que começam com "jo"
//echo json_encode($search);

//CARREGA UM USUÁRIO USANDO O LOGIN E A SENHA
//$usuario = new Usuario();
//$usuario->login("jose", "1234567");
//echo $usuario;


//INSERE UM NOVO USUÁRIO E SENHA
//$aluno = new Usuario("aluno", "wolf");
//$aluno->insert();
//echo $aluno;

//ALTERANDO UM USUÁRIO E SENHA
//$usuario = new Usuario();
//$usuario->loadById(6);
//$usuario->update("professor","wooolf");
//echo $usuario;

$usuario = new Usuario();

$usuario->loadById(7);
$usuario->delete();

echo $usuario;

 ?>