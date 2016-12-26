<?php/*
Arquivos CSS que são importados pela maior parte das páginas no site ou então em todas.
O arquivo style.php é um compilador de CSS LESS, ele recebe o endereço do arquivo LESS
através da variavel 'f' via GET, encodada em base64. Ele compila apenas LESS do interior
deste site e é manipulado na maior parte das vezes pela classe Page e suas filhas, é bem
provável que nunca se precise chamar ele diretamente.