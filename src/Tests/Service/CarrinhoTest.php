<?php

namespace Loja\WebIII\Tests\Service;

use Loja\WebIII\Model\Carrinho;
use Loja\WebIII\Model\Produto;
use Loja\WebIII\Model\Usuario;
use Loja\WebIII\Service\ProcessaCompra;
use PHPUnit\Framework\TestCase;

class CarrinhoTest extends TestCase {

    /**
     * @dataProvider carrinhoComProdutos
     */
    public function testCarrinhoComProdutos(Carrinho $carrinho) {
        // Arrange - Given
        $compra = new ProcessaCompra();

        // Act - When
        $compra->finalizaCompra($carrinho);
        $totalDaCompra = $compra->getTotalDaCompra();
        $totalDeProdutos = $compra->getTotalDeProdutos();

        $this->assertEquals(3300, $totalDaCompra);
        $this->assertEquals(3, $totalDeProdutos);
    }

    public static function carrinhoComProdutos() {
        // Arrange - Given
        $maria = new Usuario('Maria');

        $carrinho1 = new Carrinho($maria);
        $carrinho1->adicionaProduto(new Produto('Produto 1', 1000));
        $carrinho1->adicionaProduto(new Produto('Produto 2', 1500));
        $carrinho1->adicionaProduto(new Produto('Produto 3', 800));

        

        return [
            'carrinho com produtos' => [$carrinho1],
            
        ];
    }
}
