<?php

namespace Loja\WebIII\Model;

class Carrinho
{
    /** @var Produto[] */
    private $produtos;
    /** @var Usuario */
    private $usuario;

    public function __construct(Usuario $usuario)
    {
        $this->usuario = $usuario;
        $this->produtos = [];
    }

    public function adicionaProduto(Produto $produto)
    {
        $this->produtos[] = $produto;
    }

    /**
     * @return Produto[]
     */
    public function getProdutos(): array
    {
        return $this->produtos;
    }
    public function getTotalDeProdutos(): int {
        // Lógica para obter a quantidade total de produtos no carrinho
        return count($this->produtos);
    }

    public function getValorTotalProdutos(): float {
        // Lógica para calcular o valor total dos produtos no carrinho
        $valorTotal = 0;
        foreach ($this->produtos as $produto) {
            $valorTotal += $produto->getValor();
        }
        return $valorTotal;
    }

    public function getProdutoDeMaiorValor(Carrinho $carrinho): float{
        $maiorValor = 0;
        $produtos = $carrinho->getProdutos(); // Use $carrinho aqui
        foreach ($produtos as $produto) {
            $maiorValor = max($maiorValor, $produto->getValor());
        }
        return $maiorValor;
    }
    
    public function getProdutoDeMenorValor(Carrinho $carrinho): float {
        $menorValor = PHP_FLOAT_MAX;
        $produtos = $carrinho->getProdutos(); // Use $carrinho aqui
        foreach ($produtos as $produto) {
            $menorValor = min($menorValor, $produto->getValor());
        }
        return $menorValor;
    }
}