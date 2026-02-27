<?php

namespace Tests\Feature;

use Cache;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProdutoTest extends TestCase
{
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

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}

