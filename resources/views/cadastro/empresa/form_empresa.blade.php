@php
    $isEdit = isset($empresa);
    $hasStoreRoute = Route::has('pagina.salvar.empresa');
    $hasUpdateRoute = $isEdit && Route::has('pagina.atualizar.empresa');

    if ($isEdit && $hasUpdateRoute) {
        $formAction = route('pagina.atualizar.empresa', ['id' => $empresa->id]);
    } elseif (!$isEdit && $hasStoreRoute) {
        $formAction = route('pagina.salvar.empresa');
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

        .field input {
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

        .field input:focus {
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

    <h2>{{ $isEdit ? '✏️ Editar Empresa' : '🏢 Nova Empresa' }}</h2>

    <div class="card">
        @if ($formAction === '#')
            <div class="alert">
                Rotas de salvar/atualizar empresa ainda nao foram criadas. Configure as rotas para concluir o envio do formulario.
            </div>
        @endif

        <form action="{{ $formAction }}" method="POST">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="card-header">
                <strong style="font-size: 18px; color: #2c3e50;">
                    {{ old('str_razao_social', $empresa->str_razao_social ?? 'Nova Empresa') }}
                </strong>
            </div>

            <div class="section-title">Identificacao</div>
            <div class="field-group">
                <div class="field">
                    <label>Razao Social</label>
                    <input type="text" name="str_razao_social" maxlength="150" required value="{{ old('str_razao_social', $empresa->str_razao_social ?? '') }}">
                </div>
                <div class="field">
                    <label>Nome Fantasia</label>
                    <input type="text" name="str_nome_fantasia" maxlength="150" value="{{ old('str_nome_fantasia', $empresa->str_nome_fantasia ?? '') }}">
                </div>
            </div>

            <div class="field-group three">
                <div class="field">
                    <label>CNPJ</label>
                    <input type="text" name="str_cnpj" maxlength="18" required value="{{ old('str_cnpj', $empresa->str_cnpj ?? '') }}">
                </div>
                <div class="field">
                    <label>Inscricao Estadual</label>
                    <input type="text" name="str_inscricao_estadual" maxlength="30" value="{{ old('str_inscricao_estadual', $empresa->str_inscricao_estadual ?? '') }}">
                </div>
                <div class="field">
                    <label>Inscricao Municipal</label>
                    <input type="text" name="str_inscricao_municipal" maxlength="30" value="{{ old('str_inscricao_municipal', $empresa->str_inscricao_municipal ?? '') }}">
                </div>
            </div>

            <div class="section-title">Contato</div>
            <div class="field-group three">
                <div class="field">
                    <label>E-mail</label>
                    <input type="email" name="str_email" maxlength="120" value="{{ old('str_email', $empresa->str_email ?? '') }}">
                </div>
                <div class="field">
                    <label>Telefone</label>
                    <input type="text" name="str_telefone" maxlength="20" value="{{ old('str_telefone', $empresa->str_telefone ?? '') }}">
                </div>
                <div class="field">
                    <label>Celular</label>
                    <input type="text" name="str_celular" maxlength="20" value="{{ old('str_celular', $empresa->str_celular ?? '') }}">
                </div>
            </div>

            <div class="section-title">Endereco</div>
            <div class="field-group">
                <div class="field">
                    <label>Logradouro</label>
                    <input type="text" name="str_logradouro" maxlength="200" value="{{ old('str_logradouro', $empresa->str_logradouro ?? '') }}">
                </div>
                <div class="field">
                    <label>Numero / Complemento</label>
                    <input type="text" name="int_numero" maxlength="10" value="{{ old('int_numero', $empresa->int_numero ?? '') }}" placeholder="Numero">
                </div>
            </div>

            <div class="field-group three">
                <div class="field">
                    <label>Bairro</label>
                    <input type="text" name="str_bairro" maxlength="120" value="{{ old('str_bairro', $empresa->str_bairro ?? '') }}">
                </div>
                <div class="field">
                    <label>Cidade</label>
                    <input type="text" name="str_cidade" maxlength="120" value="{{ old('str_cidade', $empresa->str_cidade ?? '') }}">
                </div>
                <div class="field">
                    <label>Estado</label>
                    <input type="text" name="str_estado" maxlength="2" value="{{ old('str_estado', $empresa->str_estado ?? '') }}" placeholder="UF">
                </div>
            </div>

            <div class="field-group full">
                <div class="field">
                    <label>Complemento</label>
                    <input type="text" name="str_complemento" maxlength="120" value="{{ old('str_complemento', $empresa->str_complemento ?? '') }}">
                </div>
            </div>

            <div class="actions">
                <button class="btn btn-secondary" type="button" onclick="history.back()">Cancelar</button>
                <button class="btn btn-primary" type="submit">
                    {{ $isEdit ? 'Salvar Alteracoes' : 'Cadastrar Empresa' }}
                </button>
            </div>
        </form>
    </div>
</div>
