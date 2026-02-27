<?php

namespace Tests\Feature;

use Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class ProdutoTest extends TestCase
{
    #Usar a trait 'RefreshDatabase' para garantir que o banco
    #de dados seja limpo e atualizado antes de cada teste
    //use RefreshDatabase;

    /*
        Método 'setUp' é executado antes de cada teste.
    */
    protected function setUp(): void
    {
        parent::setUp(); # Chama o método 'setUp' da classe pai

        #Ignorar todos os middlewares para evitar autenticação
        #e outras verificações durante os testes
        $this->withoutMiddleware();

        #Executar os migrations para garantir que
        #o banco de dados esteja atualizado
        $this->artisan('migrate');

        #Limpar o cache antes de cada teste
        Cache::flush();
    }

    #[Test]
    public function deve_criar_produto_com_sucesso()
    {
        //ARRANGE -> Preparar os dados necessários para o teste
        $nome = fake()->word();
        $preco = fake()->randomFloat(2, 10, 10000);
        $quantidade = fake()->numberBetween(1, 100);

        //ACT -> Faz requisição POST para criar um novo produto
        $response = $this->postJson('/api/v1/produtos', [
            'nome' => $nome,
            'preco' => $preco,
            'quantidade' => $quantidade
        ]);

        //ASSERT -> Verifica se a resposta tem status 201 (Criado)
        $response->assertStatus(201)
            ->assertJsonFragment([
                'message' => 'Produto criado com sucesso'
            ]);

        //ASSERT -> Verifica se o produto foi realmente criado no banco de dados
        $this->assertDatabaseHas('produtos', [
            'nome' => $nome,
            'preco' => $preco,
            'quantidade' => $quantidade
        ]);
    }

    #[Test]
    public function nao_deve_criar_produto_com_dados_invalidos()
    {
        //ARRANGE -> Preparar os dados necessários para o teste
        $nome = ''; // Nome vazio para simular dados inválidos
        $preco = -10; // Preço negativo para simular dados inválidos
        $quantidade = -1; // Quantidade negativa para simular dados inválidos

        //ACT -> Faz requisição POST para criar um novo produto
        $response = $this->postJson('/api/v1/produtos', [
            'nome' => $nome,
            'preco' => $preco,
            'quantidade' => $quantidade
        ]);

        //ASSERT -> Verifica se a resposta tem status 422 (Dados inválidos)
        $response->assertStatus(422)
            ->assertJsonFragment([
                'message' => 'Ocorreram erros de validação'
            ]);
    }

    #[Test]
    public function deve_listar_produtos()
    {
        $this->markTestIncomplete('Teste ainda não implementado.');
    }

    #[Test]
    public function deve_buscar_produto_por_id()
    {
        $this->markTestIncomplete('Teste ainda não implementado.');
    }

    #[Test]
    public function deve_atualizar_produto()
    {
        $this->markTestIncomplete('Teste ainda não implementado.');
    }

    #[Test]
    public function deve_excluir_produto()
    {
        $this->markTestIncomplete('Teste ainda não implementado.');
    }
}
