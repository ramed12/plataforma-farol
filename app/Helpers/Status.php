<?php



//1 = Pendente de atualizar o cadastro

//2 = Cadastro Ativo

//3 = Cadastro suspenso

//4 = Cadastro Removido

function Status($status){

    switch($status){
        case 1:
            echo "Pendente";
        break;
        case 2:
            echo "Ativo";
        break;
        case 3:
            echo "Suspenso";
        break;
        case 4:
            echo "Removido";
        break;

    }

}
