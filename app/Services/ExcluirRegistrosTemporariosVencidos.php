<?php 

namespace App\Services;

use App\Models\RegistroTemporario;
use Illuminate\Support\Facades\Log;
use DB;

class ExcluirRegistrosTemporariosVencidos
{
	/**
	 * Retorna todos os registros temporários com mais de 1 dia de idade
	 * 
	 * @return Collection
	 */
	private function buscarRegistrosTemporariosVencidos()
	{
		return RegistroTemporario::where('created_at', '<', date('Y-m-d H:i:s', strtotime('-1 day')))->get();
	}

	/**
	 * Exclui registro temporário
	 * 
	 * @param RegistroTemporario $registro
	 */
	private function excluirRegistro(RegistroTemporario $registro) 
	{
		// Busca conteúdo a ser excluído
		$model = app('\\' . $registro->model);
		$conteudo = $model->withoutGlobalScopes()->find($registro->conteudo_id);

		// Se conteúdo existir e created_at for vazio, exclui
		if ($conteudo && empty($conteudo->created_at)) {
			$conteudo->delete();
		}

		// Exclui registro temporário da tabela de registros temporários
		$registro->delete();
	}

	/**
	 * Excluir registros temporários vencidos
	 */
	public function excluir()
	{
		DB::transaction(function () {
			try {
				// Registros vencidos 
				$registros = $this->buscarRegistrosTemporariosVencidos();

				if ($registros->count() === 0){
					Log::info('Job - ExcluirRegistrosTemporariosVencidos executado com sucesso.');
				    return;
				}

				// Exclui os registros
				foreach ($registros as $registro) {
					$this->excluirRegistro($registro);
				}

				Log::info('Job - ExcluirRegistrosTemporariosVencidos executado com sucesso ' . $registros->count() . ' registros excluídos.');
			} catch (Exception $e) {
				Log::info('Job - ExcluirRegistrosTemporariosVencidos executado com falha: ' . $e->getMessage());
			}
		});
	}
}