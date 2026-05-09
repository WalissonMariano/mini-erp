@php
    $isEdit = isset($usuario);
    $hasStoreRoute = Route::has('pagina.salvar.usuarios');
    $hasUpdateRoute = $isEdit && Route::has('pagina.atualizar.usuarios');

    if ($isEdit && $hasUpdateRoute) {
        $formAction = route('pagina.atualizar.usuarios', ['id' => $usuario->id]);
    } elseif (!$isEdit && $hasStoreRoute) {
        $formAction = route('pagina.salvar.usuarios');
    } else {
        $formAction = '#';
    }
@endphp

<div style="padding: 0 20px 20px 20px; background-color: #ffffff; min-height: 100vh; font-family: Arial, sans-serif;">
    <style>
        * { font-family: Arial, sans-serif; }

        .card {
            background: white;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 24px;
            max-width: 800px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 2px solid #ecf0f1;
        }

        .field-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .field-group.full {
            grid-template-columns: 1fr;
        }

        .field-group.three {
            grid-template-columns: 1fr 1fr 1fr;
        }

        .field label {
            display: block;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #7f8c8d;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }

        .field span {
            display: block;
            font-size: 15px;
            color: #2c3e50;
            padding: 8px 10px;
            background: #f8f9fa;
            border-radius: 4px;
            border: 1px solid #e9ecef;
            min-height: 36px;
        }

        .field input,
        .field select {
            width: 100%;
            font-size: 15px;
            color: #2c3e50;
            padding: 8px 10px;
            background: #f8f9fa;
            border-radius: 4px;
            border: 1px solid #d9dee3;
            min-height: 36px;
            box-sizing: border-box;
        }

        .field input:focus,
        .field select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.15);
            background: #fff;
        }

        .field span.empty {
            color: #bdc3c7;
            font-style: italic;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 20px 0 12px 0;
            padding-bottom: 6px;
            border-bottom: 1px solid #ecf0f1;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary { background-color: #3498db; color: white; }
        .btn-primary:hover { background-color: #2980b9; }

        .btn-secondary { background-color: #95a5a6; color: white; }
        .btn-secondary:hover { background-color: #7f8c8d; }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px solid #ecf0f1;
        }

        .alert {
            margin-bottom: 16px;
            padding: 10px 12px;
            border-radius: 4px;
            font-size: 14px;
            border: 1px solid #f5c6cb;
            background: #fdecea;
            color: #a94442;
        }
    </style>

    <h2>{{ $isEdit ? '✏️ Editar Usuario' : '👤 Novo Usuario' }}</h2>

    <div class="card">
        @if ($formAction === '#')
            <div class="alert">
                Rotas de salvar/atualizar usuario ainda nao foram criadas. Configure as rotas para concluir o envio do formulario.
            </div>
        @endif

        <form action="{{ $formAction }}" method="POST">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="card-header">
                <strong style="font-size: 18px; color: #2c3e50;">
                    {{ old('str_nome', $usuario->str_nome ?? 'Novo Usuario') }}
                </strong>
            </div>

            <div class="section-title">Identificacao</div>
            <div class="field-group full">
                <div class="field">
                    <label>Nome</label>
                    <input type="text" name="str_nome" maxlength="150" required value="{{ old('str_nome', $usuario->str_nome ?? '') }}">
                </div>
            </div>

            <div class="section-title">Contato</div>
            <div class="field-group full">
                <div class="field">
                    <label>E-mail</label>
                    <input type="email" name="str_email" maxlength="120" required value="{{ old('str_email', $usuario->str_email ?? '') }}">
                </div>
            </div>

            <div class="section-title">Seguranca</div>
            <div class="field-group full">
                <div class="field">
                    <label>{{ $isEdit ? 'Senha (deixe em branco para manter)' : 'Senha' }}</label>
                    <input type="password" name="str_password" minlength="6" {{ $isEdit ? '' : 'required' }}>
                </div>
            </div>

            <div class="section-title">Vinculos</div>
            <div class="field-group three">
                <div class="field">
                    <label>Empresa</label>
                    <select name="empresa_id" required>
                        <option value="">Selecione uma empresa</option>
                        @foreach (($empresas ?? collect()) as $empresa)
                            <option value="{{ $empresa->id }}" {{ old('empresa_id', $usuario->empresa_id ?? '') == $empresa->id ? 'selected' : '' }}>
                                {{ $empresa->str_razao_social }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label>Grupo</label>
                    <select name="grupo_id" required>
                        <option value="">Selecione um grupo</option>
                        @foreach (($grupos ?? collect()) as $grupo)
                            <option value="{{ $grupo->id }}" {{ old('grupo_id', $usuario->grupo_id ?? '') == $grupo->id ? 'selected' : '' }}>
                                {{ $grupo->str_nome }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label>Ativo</label>
                    <select name="is_active" required>
                        <option value="1" {{ old('is_active', $usuario->is_active ?? 1) == 1 ? 'selected' : '' }}>Sim</option>
                        <option value="0" {{ old('is_active', $usuario->is_active ?? 1) == 0 ? 'selected' : '' }}>Nao</option>
                    </select>
                </div>
            </div>

            <div class="actions">
                <button class="btn btn-secondary" type="button" onclick="history.back()">Cancelar</button>
                <button class="btn btn-primary" type="submit">
                    {{ $isEdit ? 'Salvar Alteracoes' : 'Cadastrar Usuario' }}
                </button>
            </div>
        </form>
    </div>
</div>
