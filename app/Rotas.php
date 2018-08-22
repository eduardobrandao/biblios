<?php

/* 
*    Este é o nosso arquivo que gerencia as rotas
*    Ex: $rota->get|post()("/suarota","Controller@metodo");
*/

$rota->get("/login","Login@index");
$rota->post("/login", "Login@entrar");
$rota->get("/sair", "Login@sair");


$rota->get("/","Home@index");


# ROTAS RELACIONADAS AO ACERVO (LIVROS) 
#=====================================================
$rota->get("/acervo","Livro@lista");
$rota->get("/acervo/novo","Livro@form");
$rota->post("/acervo/novo", "Livro@save");
$rota->get("/acervo/[i:isbn]/editar", "Livro@form");
$rota->get("/acervo/[i:isbn]/excluir", "Livro@excluir");


# ROTAS RELACIONADAS A FUNCIONARIOS
# ====================================================
$rota->get("/funcionario","Funcionario@listar");
$rota->get("/funcionario/novo","Funcionario@form");
$rota->post("/funcionario/novo","Funcionario@save");
$rota->get("/funcionario/[i:id]/editar", "Funcionario@form");
$rota->get("/funcionario/[i:id]/excluir", "Funcionario@excluir");


# ROTAS RELACIONADAS A EMPRESTIMOS
# =====================================================
$rota->get("/emprestimo","Emprestimo@listarLivros");
$rota->get("/emprestimo/lista","Emprestimo@listarEmprestimos");
$rota->post("/emprestimo/novo","Emprestimo@formEmprestimo");
$rota->post("/emprestimo/confirmar","Emprestimo@emprestar");
$rota->get("/emprestimo/devolver/[i:emprestimoid]","Emprestimo@devolver");
$rota->get("/emprestimo/vizualizar/[i:emprestimoid]", "Emprestimo@visualizar");
$rota->get('/emprestimo/minhalista', "Emprestimo@meusEmprestimos");

// $rota->get("/","Controller@teste");
// $rota->get("/login","Login@tela");
// $rota->get('/eduardo', 'Teste@teste');

// $rota->get("/login","Login@tela");