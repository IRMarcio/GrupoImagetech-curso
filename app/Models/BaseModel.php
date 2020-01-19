<?php

namespace App\Models;

use App\Traits\HasHashSlug;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    use HasHashSlug, PivotEventTrait;

    protected static $minSlugLength = 15;

    protected $guarded = ['id'];

    protected $appends = ['slug_id'];

    /**
     * Gera um registro temporário na tabela do model autal e um registro temporário na tebela de registro_temporario
     *
     * @return Model
     * @throws \ReflectionException
     */
    public static function gerarTemporario()
    {
        $self = new static();

        // Gera registro temporário vazio na tabela do model atual
        $self->timestamps = false;
        $self->save();

        // Cria reg temp na tabela registro_temporario
        RegistroTemporario::create(
            [
                'conteudo_id' => $self->id,
                'model'       => (new \ReflectionClass($self))->getName()
            ]
        );

        return $self;
    }

    /**
     * Retorna a data de atualização do registro formatada.
     *
     * @return string
     */
    public function getAtualizadoEmAttribute()
    {
        if (!$this->updated_at) {
            return null;
        }

        if ($this->updated_at instanceof Carbon) {
            return $this->updated_at->formatLocalized('%d/%b/%y');
        }


        return formatarData($this->updated_at);
    }

    /**
     * Escopo para filtrar somente os registros ativos.
     *
     * @param $q
     *
     * @return mixed
     */
    public function scopeAtivo($q)
    {
        return $q->where('ativo', true);
    }

    /**
     * Transforma registro temporário em registro permanente
     *
     * @param array $dados
     *
     * @return bool
     * @throws \ReflectionException
     */
    public function transformarPermanente($dados = [])
    {
        // Exclui reg temp da tabela registro_temporario
        RegistroTemporario::where('conteudo_id', $this->id)->where('model', (new \ReflectionClass($this))->getName())->delete();

        // Seta create_at deixando de ser registro temporário
        $this->setCreatedAt(date('Y-m-d H:i:s'));

        // Atualiza os dados
        return $this->update($dados);
    }

    /**
     * Retorna o slug.
     *
     * @return string
     */
    public function getSlugIdAttribute()
    {
        return $this->slug();
    }
}
