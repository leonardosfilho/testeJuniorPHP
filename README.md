Correções realizadas conforme README.md

Instalação do ambiente de Desenvolvimento

- Windows
    
    Servidor: recomendo a instalação do Wampp funciona muito melhor no windows
    
    64 bits:
    
    [WampServer](https://www.wampserver.com/en/#wampserver-64-bits-php-5-6-25-php-7)
    
    32 bits:
    
    [WampServer](https://www.wampserver.com/en/#wampserver-32-bits-php-5-6-25)
    
    ---
    
    IDE utilizada:
    
    [](https://code.visualstudio.com/sha/download?build=stable&os=win32-x64-user)
    
    ---
    
    Manipulação do Banco de Dados MysqlWorkbench:
    
    [MySQL :: Download MySQL Workbench](https://dev.mysql.com/downloads/workbench/)
    
- Linux
    
    Servidor:  no linux iremos utilizar o XAMPP:
    
    64 bits:
    
    [https://sourceforge.net/projects/xampp/files/XAMPP Linux/8.0.30/xampp-linux-x64-8.0.30-0-installer.run](https://sourceforge.net/projects/xampp/files/XAMPP%20Linux/8.0.30/xampp-linux-x64-8.0.30-0-installer.run)
    
    Comandos para instalar:
    
    Navegue até o diretório de Download, mude as permissões e instale: ’xampp’ quer dizer o nome do arquivo que foi baixado.
    
    sudo chmod 777 * xampp.run
    
    sudo ./xampp.run
    
    ---
    
    IDE:
    
    [](https://code.visualstudio.com/sha/download?build=stable&os=linux-deb-x64)
    
    Manipulação do Banco de Dados MysqlWorkbench:
    
    [MySQL :: Download MySQL Workbench](https://dev.mysql.com/downloads/workbench/)
    
- MacOS
    
    Servidor XAMPP: 
    
    [https://sourceforge.net/projects/xampp/files/XAMPP Mac OS X/8.0.28/xampp-osx-8.0.28-0-installer.dmg](https://sourceforge.net/projects/xampp/files/XAMPP%20Mac%20OS%20X/8.0.28/xampp-osx-8.0.28-0-installer.dmg)
    
    IDE:
    
    https://code.visualstudio.com/sha/download?build=stable&os=darwin-universal
    
    Manipulação do Banco de Dados MysqlWorkbench:
    
    [MySQL :: Download MySQL Workbench](https://dev.mysql.com/downloads/workbench/)
    

1 - Os ramais **offiline** não são exibidos corretamente no painel, para corrigir você deverá exibir os ramais indisponiveis, fazendo com que o card do painel fique cinza e traga um ícone circular no canto superior direito com a cor cinza mais escura. 

- **Correção:**
    - Background do card para cinza e icone circular superior direito com a cor cinza mais escura:
        
        **Solução:**
        
        Mudança no **trim($arr[4])** para **trim($arr[5])** pegando a posição correta do status:
        
        ```php
          if (trim($arr[1]) == '(Unspecified)' && trim($arr[5]) == 'UNKNOWN') {
                        list($nome,$username) = explode('/', $arr[0]);
                        $info_ramais[$nome] = array(
                            'nome' => $nome,
                            'ramal' => $username,
                            'online' => false,
                            'status' => $this->_status_ramais[$nome]['status']
                        );     
                    }
        ```
        
    
    Classe criada para o Cartão:
    
    ```css
    .cartao-indisponivel {
        width: 200px;
        height: 80px;
        border-style: solid;
        border-radius: 5px;
        border-width: 2px;
        border-color: #000;
        background-color: gray;
        float: left;
        position: relative;
        padding: 5px;
        margin: 2px;
    }
    ```
    
    Classe criada para ícone circular: 
    
    ```css
    .indisponivel {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background-color: var(--gray-dark);
       
    }
    ```
    
    Criação de mais um IF
    
    ```php
     if (strstr($linhas, '(Unavailable)')) {
                        $linha = explode(' ', trim($linhas));
                        list($tech, $ramal) = explode('/', $linha[0]);
                        $status_ramais[$ramal] = array('status' => 'indisponivel');
                    }
    ```
    
    Através de uma função criada anteriormente para separar os ramais pelo status ao chamar o id $('#cartoes').append ele chama na classe corresponde ao seu status
    
    ```jsx
      let classeCartao = `cartao-${status.toLowerCase()}`;
                        // Exibe os dados no HTML
                        $('#cartoes').append(`<div class="${classeCartao}">
                                    <div>${ramal.nome}</div>
                                    <div>${ramal.ramal}</div>
                                    <span class="${status} icone-posicao"></span>
                                    </div>`);
    ```
    

2 - Os ramais que estão em pausa no grupo de callcenter não estão sendo exibidos corretamente, para corrigir você deverá exibir os ramais que estão com com status de pausa, trazendo um ícone circular no canto superior direito com a cor laranja.

- **Correção:**
    
    Ramais em pausa não estão sendo exibidos corretamente, trazer ícone circular com a cor laranja. 
    
    **Solução**: mudar cor da classe ocupado
    
    ```css
    .ocupado {
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background-color: var(--orange);
    }
    ```
    
    Correção do if: $linhas, '(In Use)' com 'status' => 'disponivel'; e '(Not in use)' || '(paused)' com 'status' => 'ocupado';
    
    ```php
    if (strstr($linhas, '(In use)')) {
                        $linha = explode(' ', trim($linhas));
                        list($tech, $ramal) = explode('/', $linha[0]);
                        $status_ramais[$ramal] = array('status' => 'disponivel');
                    }
                    if (strstr($linhas, '(Not in use)') || strstr($linhas, '(paused)')) {
                        $linha = explode(' ', trim($linhas));
                        list($tech, $ramal) = explode('/', $linha[0]);
                        $status_ramais[$ramal] = array('status' => 'ocupado');
                    }
    ```
    

3 - Os card deverão exibir os nomes dos agentes que estão no grupo de callcenter SUPORTE (arquivo lib\filas)

- **Correção:**
    
    Ao adicionar a <div>${ramal.ramal}</div> é possível exibir os nomes dos agentes que estão no grupo callcenter SUPORTE
    
    ```jsx
     $('#cartoes').append(`<div class="${classeCartao}">
                                    <div>${ramal.nome}</div>
                                    <div>${ramal.ramal}</div>
                                    <span class="${status} icone-posicao"></span>
                                    </div>`);
    ```
    

### OBRIGATÓRIO  
 
 - Transformar o arquivo lib\ramais.php em uma classe e parar de utiliza-lo no sistema.
  Finalizado!
  
 - Criar uma base de dados utilizando mysql ou mariadb para armazenar as informações de cada ramal
  Finalizado!
  
 - Atualizar as informações no card através do AJAX a cada 10 segundos se tiver alteração atualizar banco de dados.
  Finalizado!
  
  Para informações mais detalhadas segue o código no final das instruções..

### MELHORIAS  
Após a correção destes itens, você deverá aplicar ao menos 3 (três) melhorias neste sistema.

- 1 - Melhoria
    
    Criação de uma função que trata o JSON enviado do PHP e já separa por classe utilizando um Array Multidimensional
    
    ```jsx
    function agruparPorStatus(dados) {
        const resultado = {};
        for (const ramalId in dados) {
            const ramal = dados[ramalId];
            const status = ramal.status;
            
            if (!resultado[status]) {
                resultado[status] = [];
            }
            resultado[status].push({
                nome: ramal.nome,
                ramal: ramal.ramal,
                online: ramal.online
            });
        }
    
        return resultado;
    }
    ```
    
- 2 - Melhoria
    
    Após separar os status por grupo utilizo o **grupo.length;** para pegar a quantidade dos Ramais presentes no array de cada status separando da melhor forma
    
    ```jsx
        const resultadoAgrupado = agruparPorStatus(data);
                
                for (const status in resultadoAgrupado) {
                    const grupo = resultadoAgrupado[status];
                    const quantidadeRamais = grupo.length;
    
                    $('#cartoes').append(`<div class="titulo-status"><h5>${status} &#160;
                    <button>${quantidadeRamais}</button></h5></div>`);
    
                    for (const ramal of grupo) {
                        let classeCartao = `cartao-${status.toLowerCase()}`;
    
                        $('#cartoes').append(`<div class="${classeCartao}">
                                    <div>${ramal.nome}</div>
                                    <div>${ramal.ramal}</div>
                                    <span class="${status} icone-posicao"></span>
                                    </div>`);
                    }
                    $('#cartoes').append('<br>');
                }
    ```
    
- 3 - Melhoria
    
    Criação de uma classe para cada status facilitando a distribuição através do javascript de forma automática.
    
    ```css
    .cartao-disponivel {
        font-weight: 500;
        width: 200px;
        height: 80px;
        border-style: solid;
        border-radius: 5px;
        border-width: 2px;
        border-color: #000;
        background-color: white;
        position: relative;
        align-items:left;
        padding: 5px;
        margin: 2px;
    }
    .cartao-indisponivel {
        font-weight: 500;
        width: 200px;
        height: 80px;
        border-style: solid;
        border-radius: 5px;
        border-width: 2px;
        border-color: #000;
        background-color: var(--gray);
        align-items:left;
        position: relative;
        padding: 5px;
        margin: 2px;
    }
    .cartao-ocupado {
        font-weight: 500;
        width: 200px;
        height: 80px;
        border-style: solid;
        border-radius: 5px;
        border-width: 2px;
        border-color: #000;
        background-color: white;
        align-items:left;
        position: relative;
        padding: 5px;
        margin: 2px;
    
    }
    .cartao-chamando {
        font-weight: 500;
        width: 200px;
        height: 80px;
        border-style: solid;
        border-radius: 5px;
        border-width: 2px;
        border-color: #000;
        background-color: white;
        align-items:left;
        position: relative;
        padding: 5px;
        margin: 2px;
    }
    .cartao {
        width: 200px;
        height: 80px;
        border-style: solid;
        border-radius: 5px;
        border-width: 2px;
        border-color: #000;
        align-items:left;
        position: relative;
        padding: 5px;
        margin: 2px;
    
    }
    ```
    
- 4 - Melhoria
    
    Deixando o front-end autoexplicativo com a separação e um botão que simboliza a quantidade de Ramais em cada Status
    

Código com Dump do MySQL e código utilizado.
