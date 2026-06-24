<?php

namespace App\Http\Controllers\Configuracao;

use App\Http\Controllers\Controller;
use App\Models\Configuracao\Parametros;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ParamentrosController extends Controller
{
    public function edit()
    {
        $parametro = Parametros::query()->first();

        return view('configuracao.parametros.form-parametros', compact('parametro'));
    }

    public function store(Request $request)
    {
        if (Parametros::exists()) {
            return redirect()->route('pagina.parametros');
        }

        $validated = $this->validarParametros($request);
        $validated['is_gera_financeiro'] = (bool) (int) $validated['is_gera_financeiro'];

        Parametros::create($validated);

        return redirect()->route('pagina.parametros');
    }

    public function update(Request $request, $id)
    {
        $parametro = Parametros::findOrFail($id);

        $validated = $this->validarParametros($request);
        $validated['is_gera_financeiro'] = (bool) (int) $validated['is_gera_financeiro'];

        $parametro->update($validated);

        return redirect()->route('pagina.parametros');
    }

    private function validarParametros(Request $request): array
    {
        return $request->validate(
            [
                'is_gera_financeiro' => ['required', Rule::in(['0', '1', 0, 1, true, false])],
            ],
            [
                'is_gera_financeiro.required' => 'Informe se deve gerar financeiro ao baixar pedidos.',
            ],
            [
                'is_gera_financeiro' => 'gerar financeiro',
            ]
        );
    }
}
