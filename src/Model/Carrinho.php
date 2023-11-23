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

    public function removeProduto($descricao) {
        foreach ($this->produtos as $indice => $produto) {
            if ($produto->getProduto() === $descricao) {
                unset($this->produtos[$indice]);
                // Reindexa o array para manter a consistência
                $this->produtos = array_values($this->produtos);
                return true; // Produto removido com sucesso
            }
        }
        return false; // Produto não encontrado no carrinho
    }

    public function getTopMaisCaros($n) {
        $produtosOrdenados = $this->ordenarProdutosPorValor(true);
        return array_slice($produtosOrdenados, 0, $n);
    }

    // Obtém os N produtos mais baratos no carrinho
    public function getTopMaisBaratos($n) {
        $produtosOrdenados = $this->ordenarProdutosPorValor(false);
        return array_slice($produtosOrdenados, 0, $n);
    }

    // Método auxiliar para ordenar os produtos por valor
    private function ordenarProdutosPorValor($ordemCrescente = true) {
        $produtos = $this->produtos;

        usort($produtos, function($a, $b) use ($ordemCrescente) {
            if ($a->getValor() == $b->getValor()) {
                return 0;
            }
            return ($ordemCrescente ? ($a->getValor() < $b->getValor() ? 1 : -1) : ($a->getValor() > $b->getValor() ? 1 : -1));
        });

        return $produtos;
    }
}