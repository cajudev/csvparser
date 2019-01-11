Bem vindo ao CsvParser
======================

[![](https://img.shields.io/packagist/v/cajudev/csvparser.svg)](https://packagist.org/packages/cajudev/csvparser)
[![](https://img.shields.io/packagist/dt/cajudev/csvparser.svg)](https://packagist.org/packages/cajudev/csvparser)
[![](https://img.shields.io/github/license/cajudev/csvparser.svg)](https://raw.githubusercontent.com/cajudev/csvparser/master/LICENSE)
[![](https://img.shields.io/travis/cajudev/csvparser.svg)](https://travis-ci.org/cajudev/csvparser)
[![](https://coveralls.io/repos/github/cajudev/csvparser/badge.svg?branch=master)](https://coveralls.io/github/cajudev/csvparser)
[![](https://img.shields.io/github/issues/cajudev/csvparser.svg)](https://github.com/cajudev/csvparser/issues)
[![](https://img.shields.io/github/contributors/cajudev/csvparser.svg)](https://github.com/cajudev/csvparser/graphs/contributors)

Uma simples, porém eficiente interface para trabalhar com arquivos csv

Veja a documentação completa em: https://cajudev.readthedocs.io

Características
---------------

* Padrão PSR-4
* Testes unitários com PHPUnit

Instruções
----------

Considere o seguinte arquivo:

| Data       | Produto  | Preço       | Pagamento  | Nome     | Estado          |
|------------|----------|-------------|------------|----------|-----------------|
| 11/01/2019 | Produto1 | R$ 1.400,00 | Mastercard | João     | Rio de Janeiro  |
| 12/01/2019 | Produto2 | R$ 1.800,00 | Visa       | Maria    | São Paulo       |
| 11/01/2019 | Produto3 | R$ 1.200,00 | Mastercard | Pedro    | Minas Gerais    |
| 14/01/2019 | Produto3 | R$ 2.200,00 | Mastercard | Henrique | São Paulo       |
| 11/01/2019 | Produto2 | R$ 1.200,00 | Visa       | Julio    | Minas Gerais    |
| 16/01/2019 | Produto2 | R$ 5.000,00 | Visa       | Emanuel  | Rio de Janeiro  |
| 17/01/2019 | Produto2 | R$ 3.600,00 | Visa       | Silvia   | São Paulo       |
| 18/01/2019 | Produto1 | R$ 1.200,00 | Visa       | Reinaldo | Minas Gerais    |



Obtendo todos os dados:

```php
use Cajudev\CsvParser\CsvParser;

$dir = __DIR__ . '/file.csv';

$csv = new CsvParser($dir);

$csv->setDelimiter(';');

$results = $csv->parse();

print_r($results);

/** Saída **/

Array
(
    [0] => Array
        (
            [Data] => 11/01/2019
            [Produto] => Produto1
            [Preço] =>  R$ 1.400,00
            [Pagamento] => Mastercard
            [Nome] => João
            [Estado] => Rio de Janeiro
        )

    [1] => Array
        (
            [Data] => 12/01/2019
            [Produto] => Produto2
            [Preço] =>  R$ 1.800,00
            [Pagamento] => Visa
            [Nome] => Maria
            [Estado] => São Paulo
        )

    [2] => Array
        (
            [Data] => 11/01/2019
            [Produto] => Produto3
            [Preço] =>  R$ 1.200,00
            [Pagamento] => Mastercard
            [Nome] => Pedro
            [Estado] => Minas Gerais
        )

    [3] => Array
        (
            [Data] => 14/01/2019
            [Produto] => Produto3
            [Preço] =>  R$ 2.200,00
            [Pagamento] => Mastercard
            [Nome] => Henrique
            [Estado] => São Paulo
        )

    [4] => Array
        (
            [Data] => 11/01/2019
            [Produto] => Produto2
            [Preço] =>  R$ 1.200,00
            [Pagamento] => Visa
            [Nome] => Julio
            [Estado] => Minas Gerais
        )

    [5] => Array
        (
            [Data] => 16/01/2019
            [Produto] => Produto2
            [Preço] =>  R$ 5.000,00
            [Pagamento] => Visa
            [Nome] => Emanuel
            [Estado] => Rio de Janeiro
        )

    [6] => Array
        (
            [Data] => 17/01/2019
            [Produto] => Produto2
            [Preço] =>  R$ 3.600,00
            [Pagamento] => Visa
            [Nome] => Silvia
            [Estado] => São Paulo
        )

    [7] => Array
        (
            [Data] => 18/01/2019
            [Produto] => Produto1
            [Preço] =>  R$ 1.200,00
            [Pagamento] => Visa
            [Nome] => Reinaldo
            [Estado] => Minas Gerais
        )
)
```

Customizando o retorno:

```php
$csv->setColumns(['Produto', 'Preço', 'Pagamento', 'Nome']);

$results = $csv->parse();

print_r($results);

/** Saída **/

Array
(
    [0] => Array
        (
            [Produto] => Produto1
            [Preço] =>  R$ 1.400,00
            [Pagamento] => Mastercard
            [Nome] => João
        )

    [1] => Array
        (
            [Produto] => Produto2
            [Preço] =>  R$ 1.800,00
            [Pagamento] => Visa
            [Nome] => Maria
        )

    [2] => Array
        (
            [Produto] => Produto3
            [Preço] =>  R$ 1.200,00
            [Pagamento] => Mastercard
            [Nome] => Pedro
        )

    [3] => Array
        (
            [Produto] => Produto3
            [Preço] =>  R$ 2.200,00
            [Pagamento] => Mastercard
            [Nome] => Henrique
        )

    [4] => Array
        (
            [Produto] => Produto2
            [Preço] =>  R$ 1.200,00
            [Pagamento] => Visa
            [Nome] => Julio
        )

    [5] => Array
        (
            [Produto] => Produto2
            [Preço] =>  R$ 5.000,00
            [Pagamento] => Visa
            [Nome] => Emanuel
        )

    [6] => Array
        (
            [Produto] => Produto2
            [Preço] =>  R$ 3.600,00
            [Pagamento] => Visa
            [Nome] => Silvia
        )

    [7] => Array
        (
            [Produto] => Produto1
            [Preço] =>  R$ 1.200,00
            [Pagamento] => Visa
            [Nome] => Reinaldo
        )
)
```

Filtrando os dados:

```php
$csv->setFilters([
    'Pagamento' => ['Visa'],
    'Estado'    => ['São Paulo', 'Rio de Janeiro'],
]);

$results = $csv->parse();

Array
(
    [0] => Array
        (
            [Produto] => Produto2
            [Preço] =>  R$ 1.800,00
            [Pagamento] => Visa
            [Nome] => Maria
        )

    [1] => Array
        (
            [Produto] => Produto2
            [Preço] =>  R$ 5.000,00
            [Pagamento] => Visa
            [Nome] => Emanuel
        )

    [2] => Array
        (
            [Produto] => Produto2
            [Preço] =>  R$ 3.600,00
            [Pagamento] => Visa
            [Nome] => Silvia
        )
)
```
