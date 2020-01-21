<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>


<img src="https://www.grupoimagetech.com.br/wp-content/themes/imagetech/assets/images/logo.svg" alt="">

## Sobre o Projeto Curso Grupo Imatech.


Foi Desenvolvido um sistema com a seguinte perspectiva. Um sistema de gestão de Cursos com multiplas entidades Estudantis neste caso Chamadas de CDE --> (Centro de Distribuição Estudantil), aonde se realiza o cadastro de Cursos, que ficam a disposição de todos os polos (CDE), aonde cada polo adiciona o curso em seus registro determinando a data de início da turma, quantidade de vagas disponível e o período. Cada CDE também consegue realizar Cadastro dos alunos assim como a matrícula, efetivando o aluno em seu curso. segue as informações de disponíveis. 


## MENU

- [Dashboard]().
- [Sistema]().
- Sub-Menu [Sistema GERAL - Unidades]() 

        _- Cadastra de Unidades e Sessões como (Administrativas,Pedagógicas, Sessão Professoras e Etc,) 
        
          
        


- Sub-Menu [Sistema GERAL - Perfils]().

        _- Cadastro de Perfil relacioando com Unidade Gerada Anteriormente você consegue direcionar as permissões que serão dadas a este Perfil;


- Sub-Menu [Sistema GERAL - Usuários]().
        
        _- Cadastro de Usuários, Dados do Usuário serão registrados e a ele o Perfil-> que esta realacionado com a Unidade; 

- Sub-Menu [Sistema GERAL - Centro de Distribuição]().
        
        _- Finalmente Cadastro de CDE - Centro de Distribuição Estutantil - Que proverá toda Gestão do fluxo a seguir; 

- Sub-Menu [Sistema ENDEREÇAMENTO - Estado]().

        _- Cadastro dos Estados em Geral; 

- Sub-Menu [Sistema ENDEREÇAMENTO - Municípios]().
        
            _- Cadastro dos Municípios em Geral; 

- Sub-Menu [Sistema CONFIGURAÇÕES - Auditoria]().
            
            _- Auditoria o sistema possui uma estrutura de Auditoria que monitora toda atividade do usuário e registra a informação
             
- Sub-Menu [Sistema CONFIGURAÇÕES - Sistema]().

            _- Configurações Gerais - Como: Fuso horário,E-mail, e Termo de Uso;

- [Gestão Matrícula]().
            
- Sub-Menu [Cadastro de Matrículas]().
            
            _- Cadastro de Matrícula do aluno dentro do CDE;
           
- Sub-Menu [Listagem de Matrículas]().
           
           _- Listagem de Matrícula do aluno dentro do CDE;
           
- [Gestão Aluno]().
- Sub-Menu [Cadastro de Alunos]().
           
           _- Cadastro do aluno dentro do CDE;
           
- Sub-Menu [Listagem de Alunos]().
           
           _- Listagem do aluno dentro do CDE;
           
- [Gestão Cursos]().
- Sub-Menu [Cadastro de Período]().
           
           _- Cadastro de Período dos Cursos(Matutino,Vespertino,Noturno);
           
- Sub-Menu [Listagem de Período]().
           
           _- Listagem de Período dos Cursos;
           
- Sub-Menu [Cadastro de Cursos]().

           _- Cadastro dos Cursos de Acesso a Todos os CDEs;
           
- Sub-Menu [Listagem de Cursos]().
           
           _- Listagem dos Cursos de Acesso a Todos os CDEs;
           
           
- Sub-Menu [Listar Cursos Cadastro Educacional]().

           _- Cadastro dos Cursos Dentro dos CDE, com toda particularidade como, quantidade de vagas disponíveis,data de início da turma e período;


Na Barra Superior do Menu se encontra o menu de Gestão do Usuário, lado Esquerdo do ícone de usuário se encontrado a Unidade Lotada do Usuário atual, do lado direito o Nome do Perfil e Primeiro nome do usuário, clicando em cima do nome do usuário voce encontra 3 menus:

- Sub-Menu [Alterar Senha]().
           
           _- Trocar a senha do usuário;
           
- Sub-Menu [Selecionar Centro]().
           
           _- Um usuário pode ser lotado em mais de uma CDE, sendo assim você pode navegar entre os Centros aqui;
           
- Sub-Menu [Alterar Perfil]().
           
           _- Alterar Perfil do Usuário;
           

## Cadastro de Usuários

O Cadastro de usuários novos o login e senha são o cpf do usuário, no hora do usuário se logar no sistema ele será redirecionado para uma nova view que solicitara uma nova senha do mesmo.


## Apresentação do Sistema

Segue abaixo uma Apresentação Geral do Sistema;

![](public/img/info_sistema/apresentacao.gif)

## Processo de Instalação

- Realizar o clone do projeto :

git clone https://github.com/IRMarcio/GrupoImagetech-curso.git

- Executar a instalação do Laravel :

        composer install

- Executar a instalação do Node [Package.json]() :

        npm install && npm run dev
        
- Gerar Arquivo .env e Adicionar os dados do banco de dados:

        cp .env.example .env

- Gerar APP_KEY do arquivo .env :

        php artisan key:generate

- Dar Permissões para pasta storage/Bootstrape :

        sudo chmod -R 777 storage/ bootstrap/

- Gerar as Migration do Sistema :

        php artisan migrate

- Carregar as Bibliotecas de Dados do sistema:

        php artisan db:seed

- Carregar as Bibliotecas de Dados de Teste do Projeto:

        php artisan db:seed --class=UnidadePerfilSeeder

- Após carregar os dados gerar o v-host na Máquina local:

        <VirtualHost *:80>
            ServerAdmin curso
            DocumentRoot "/sua_pasta_ate/curso/public"
            ServerName curso
            ServerAlias dev.curso
        
                <Directory "/sua_pasta_ate/curso/public">
                        Options Indexes FollowSymLinks
                        AllowOverride All
                        Order allow,deny
                        Allow from all
                        Require all granted
                </Directory>
        
        </VirtualHost>

- Senha do usuario padrão:

               "cpf": "00000000000",
               "senha": "admin",

- Após Logar no sistema, adicionar ao usuário [PADRÃO]() os Perfis Previamente Cadastrados, e adicionar aos cursos cadastrados, os períodos: [Matutino, Vespertino, Noturmo](), como mostra a ilustração abaixo:


![](public/img/info_sistema/apresentacao2.gif)

## Observação
- O sistema caberia muitas funcionalidades que permite a leitura ainda superficial do projeto, como fluxo de movimento financeiros entre os CDE, mensalidades de taxas de matrículas etc....
infelizmente o fator tempo esta curto devido as atividade tive somente o final de semana e as noites para desenvolver este projeto, espero que esteja satisfatório. Agradeço atenciosamente a atenção e me colocar a disposição.

## Exemplos de Trabalhos Realizados em Analise de Projeto e execução

- https://www.lucidchart.com/documents/view/73367593-8c54-441d-89a5-3a42b06c9cae/0_0

- https://www.lucidchart.com/documents/view/a3e01733-d566-4a84-b90d-70a5c4effe80

- https://www.lucidchart.com/documents/view/e5ee01ef-1d96-42cf-bd1f-331e401c0d2e

## Contatos

- Autor :
    - [Marcio Rozendo Rodrigues Gonçalves, Campo Grande - MS, (67)99273-7505 / (67)99204-0958, adm.evento@gmail.com]()
