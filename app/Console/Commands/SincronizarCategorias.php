<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Admin\TipoArticuloController;

class SincronizarCategorias extends Command
{
    protected $signature = 'sincronizar:categorias';
    protected $description = 'Sincroniza categorías desde el ERP externo';

    public function handle()
    {
        $this->info('Iniciando sincronización...');
        $controller = new TipoArticuloController();
        $controller->sincronizarCategorias();
        $this->info('Sincronización completada');
    }
}