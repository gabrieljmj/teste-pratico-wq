# Teste Prático

## Instalação

Após o download da aplicação, siga os seguintes passos:

1. ```$ npm install``` ou ```$ yarn``` para as instalar as dependências do JavaScript.
2. ```$ npm run dev``` ou ```$ yarn dev``` para compilar o JavaScript e o CSS (Sass).
3. ```$ composer update``` para instalar as dependências do PHP.
4. ```$ cp .env.example .env && php artisan key:generate``` para criar o arquivo de confirguração de variáveis de ambiente e gerar um key.
5. Altere as configurações de banco de dados e a variável ```GOOGLE_MAPS_API_KEY``` no arquivo ```.env```.
6. Rode o comando ```$ php artisan migrate --seed```. Este comando irá criar as tabelas no banco e um acesso para o usuário com o email ```test@test.com``` e senha ```password```.
7. ```$ php artisan storage:link``` para ligar a pasta de uploads à pasta ```public```.
8. ```$ php artisan serve``` para iniciar o servidor.

## Rotas acessáveis (sem as de auth)

| Rota | Descrição | Necessário autenticação |
| ---- | --------- | ----------------------- |
| ```/``` | Página inicial com busca de imóveis. | Não |
| ```/properties``` | Lista dos imóveis cadastrados pelo usuário. | Sim |
| ```/properties/new``` | Formulário para cadastrar novo imóvel. | Sim |
| ```/properties/{property]/edit``` | Formulário para editar imóvel. | Sim |
| ```/properties/{property}``` | Página de exibição das informacões do imóvel. | Não |

## Funcionalidades

### Busca

A busca é efeita através de dois campos na página incial da aplicação: **Endereço** e **Raio de Busca**.

No campo **Endereço** o usuário preencherá com um endereço que será buscado pelo Google Maps e adiconado um marcador vermelho no mapa indicando o local deste endereço.

O campo **Raio de Busca** que possui um valor padrão de ```80``` indica o raio de distância em kilômetros.

Assim que ambos os campos estiverem preenchidos, será buscado no banco de dados localidades próximas a posição do mapa indicada e serão inseridos marcadores verdes clicáveis no mapa indicando esses imóveis e uma lista ao lado do mapa com mais informações sobre os imóveis encontrados.

O marcador vermelho é movivel. Ou seja, é possível move-lo pelo mapa e quanto solto, uma nova busca será feita utilizando dessa nova localização.

### Cadastro de imóveis

O cadastro possui um formilário com campos de detalhes do imóvel e endereço, além de um mapa preenchido com um marcador assim que todo o endereço estiver preenchido.

Por conta de falhas na precisão da busca de endereço pelo Google Maps, é possível mover o marcador até a posição correta.

Assim que ocorrer o envio do formulário, haverá uma validação, e se os dados passarem por ela, o usuário é direcionado para a página do imóvel; se não, serão indicados os erros do formulário abaixo de cada campo.

> As validações são feitas tanto no frontend quanto no backend.

### Edição de imóveis

Utiliza o mesmo formulário que o de cadastro com a diferença que os campos já vem preenchidos com as informações do imóvel.

### Exclusão de imóveis

É possível ser feita na lista de imóveis através do botão vermelho, que abrirá um modal perguntando pela confirmação da exclusão.

### Exibição de imóveis

A tela de exibição do imóvel contém todas as informações do imóvel incluindo um mapa com um marcador central indicando o local e uma sessão logo abaixo que indica imóveis próximos aquele num raio definido na variável de ambiente ```NEARBY_DISTANCE``` encontrada no fim do arquivo ```.env```.

## Design

O design da aplicação foi desenvolvido utilizando uma mistura de Blade e Vue.js.

As views relacionadas à autenticação mantive as originais do boilerplate Laravel apenas tranduzindo os campos.
