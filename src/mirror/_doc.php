<?php/*
Essa pasta espelha todas as coisas do site:
Veja como utilizar a classe Page para espelhar arquivos para esta pasta:

A classe Page é uma classe pai, ela nunca é instanciada como objeto, somente
extendida para objetos filhos (isso me permite utilizar sempre a mesma classe
em todos os sites que eu faço, mudando apenas algumas configurações simples
na estrutura), no contexto deste site a classe filha da classe Page é a classe Rev,
de Revolution:

1) Espelho de Template:

$info = $sql->Query("MINHA QUERY");
$rev = new Rev(array(
	"html" => array(
		"info" => $info,
		"hoje" => date("d/m/Y")
	)
));

Nessa classe Page, eu fiz algumas alterações na classe RainTpl para que ela suporte
o estilo de espelhamento da classe Page, as informações de banco de dados que vão fazer
loop, ou vão ser tiradas do sistema para enviar para o HTML devem ser passadas em um array.
Se você colocar simplesmente "html" => TRUE, a classe vai saber que existe um HTML espelhado
sem a necessidade de ter informações atribuidas à este.
As pastas de espelhamento html são a pasta HTML e a pasta CACHE, a pasta CACHE serve para
administração interna do raintpl, nunca mexa nela, nem olhe para ela.


2) Espelho de CSS

$rev = new Rev(array(
	"html" => TRUE,
	"css" => array( "ie7", "ie8" )
));

$rev = new Rev(array(
	"html" => TRUE,
	"less" => array( "opera", "webkit", "ie" )
));

O espelhamento de CSS é feito tanto para Less como para o Css normal, se você chamar CSS e
também chamar Less através do array, ele vai chamar o arquivo somente uma vez utilizando Less.
Você pode configurar no array arquivos de compatibilidade, por exemplo: Se existe uma falha de
CSS somente nos browsers que usam webkit, ou então em todos os IEs, você pode chamar arquivos
de compatibilidade através de um array, os tipos possíveis são:

ie
ie6
ie7
ie8
ie9
ie10
firefox
opera
webkit
chrome
safari

O arquivo de compatibilidade deve ficar dentro da mesma pasta onde o arquivo é espelhado, mas com
um prefixo à sua extenção, por exemplo, se o arquivo /forums/topicos.php for espelhado com compatibilidade
para ie6, ie, webkit e firefox, seus arquivo serão:

/forums/topicos.ie.css
/forums/topicos.ie6.css
/forums/topicos.webkit.css
/forums/topicos.firefox.css

Quando o site for aberto em IE6, o arquivo ie.css será importado primeiro e depois o ie6.css, da mesma
forma se webkit e chrome estiverem instanciados: primeiro o webkit será chamado, depois o chrome (o mais
específico sempre por último).

Se você não quiser adicionar nenhum arquivo de compatibilidade, ao invés de passar um array, passe o valor
TRUE para o CSS.


3) Espelhamento de JavaScript

$rev = new Rev(array(
	"html" => TRUE,
	"js" => array( "forms", "tooltip" )
));

No caso do espelhamento para javascript, te é permitido chamar classes JavaScript que você irá utilizar.
As classes que forem desenvolvidas por nós ficaram dentro da pasta /resource/js/class/minhaclasse.class.js
e minhaclasse será passado como um item do array.
Se sua classe javascript depender de CSS (como é o cado da classe forms e também da classe tooltip), então
será necessário fazer uma alteração direta na classe Page Pai.


4) Anulando problemas com CACHE

$rev = new Rev(array(
	"html" => TRUE,
	"js" => array( "forms", "tooltip" ),
	"css" => array( "ie", "ie7", "ie8" ),
	"cache" => FALSE
));

Para evitar ficar pressionando Ctrl + F5 com todas as forças sem nenhum resultado, foi criado um anulador
de cache na classe: se você coloca que ele é igual a FALSE, ele vai importar todos os arquivos diretamente
do servidor sempre.

Esse módulo deve ser apenas utilizado enquanto os arquivos estão sendo editados, depois que terminarem de
ser editados, deve-se desabilitar o modo de cache falso.