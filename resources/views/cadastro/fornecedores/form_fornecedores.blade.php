@php
    $fornecedor = $fornecedor ?? null;
    $isEdit = $fornecedor !== null;
    $hasStoreRoute = Route::has('pagina.salvar.fornecedor');
    $hasUpdateRoute = $isEdit && Route::has('pagina.atualizar.fornecedor');

    if ($isEdit && $hasUpdateRoute) {
        $formAction = route('pagina.atualizar.fornecedor', ['id' => $fornecedor->id]);
    } elseif (! $isEdit && $hasStoreRoute) {
        $formAction = route('pagina.salvar.fornecedor');
    } else {
        $formAction = '#';
    }

    $empresasLista = collect($empresas ?? []);
    if ($empresasLista->isEmpty() && isset($empresa)) {
        $empresasLista = collect([$empresa]);
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
            max-width: 960px;
        }

        .card-header {
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
            grid-template-columns: 2fr 1fr 1fr;
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
        }

        .alert-error {
            border: 1px solid #f5c6cb;
            background: #fdecea;
            color: #a94442;
        }
    </style>

    <h2>{{ $isEdit ? '✏️ Editar Fornecedor' : '🏭 Novo Fornecedor' }}</h2>

    <div class="card">
        @if ($formAction === '#')
            <div class="alert alert-error">
                Rotas de salvar/atualizar fornecedor nao foram localizadas. Configure as rotas para concluir o envio do formulario.
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Existem erros no formulario:</strong>
                <ul style="margin: 8px 0 0 18px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $formAction }}" method="POST">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="card-header">
                <strong style="font-size: 18px; color: #2c3e50;">
                    {{ old('str_nome', optional($fornecedor)->str_nome ?? 'Novo Fornecedor') }}
                </strong>
            </div>

            <div class="section-title">Identificacao</div>
            <div class="field-group">
                <div class="field">
                    <label>Nome</label>
                    <input type="text" name="str_nome" maxlength="150" required value="{{ old('str_nome', optional($fornecedor)->str_nome ?? '') }}">
                </div>
                <div class="field">
                    <label>CPF</label>
                    <input type="text" name="str_cpf" maxlength="14" required value="{{ old('str_cpf', optional($fornecedor)->str_cpf ?? '') }}" placeholder="000.000.000-00">
                </div>
            </div>

            <div class="section-title">Contato</div>
            <div class="field-group">
                <div class="field">
                    <label>E-mail</label>
                    <input type="email" name="str_email" maxlength="120" required value="{{ old('str_email', optional($fornecedor)->str_email ?? '') }}">
                </div>
                <div class="field">
                    <label>Telefone</label>
                    <input type="text" name="str_telefone" maxlength="20" value="{{ old('str_telefone', optional($fornecedor)->str_telefone ?? '') }}">
                </div>
            </div>

            <div class="section-title">Endereco</div>
            <div class="field-group three">
                <div class="field">
                    <label>Logradouro</label>
                    <input type="text" name="str_logradouro" maxlength="255" value="{{ old('str_logradouro', optional($fornecedor)->str_logradouro ?? '') }}">
                </div>
                <div class="field">
                    <label>Numero</label>
                    <input type="text" name="str_numero" maxlength="10" value="{{ old('str_numero', optional($fornecedor)->str_numero ?? '') }}">
                </div>
                <div class="field">
                    <label>Bairro</label>
                    <input type="text" name="str_bairro" maxlength="100" value="{{ old('str_bairro', optional($fornecedor)->str_bairro ?? '') }}">
                </div>
            </div>

            <div class="field-group">
                <div class="field">
                    <label>Cidade</label>
                    <input type="text" name="str_cidade" maxlength="100" value="{{ old('str_cidade', optional($fornecedor)->str_cidade ?? '') }}">
                </div>
                <div class="field">
                    <label>Estado</label>
                    <input type="text" name="str_estado" maxlength="2" value="{{ old('str_estado', optional($fornecedor)->str_estado ?? '') }}" placeholder="UF">
                </div>
            </div>

            <div class="section-title">Vinculo</div>
            <div class="field-group full">
                <div class="field">
                    <label>Empresa</label>
                    <select name="empresa_id" required>
                        <option value="">Selecione uma empresa</option>
                        @foreach ($empresasLista as $itemEmpresa)
                            <option value="{{ $itemEmpresa->id }}"
                                {{ (string) old('empresa_id', optional($fornecedor)->empresa_id ?? '') === (string) $itemEmpresa->id ? 'selected' : '' }}>
                                {{ $itemEmpresa->str_razao_social }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="actions">
                <button class="btn btn-secondary" type="button" onclick="loadContent('{{ route('pagina.lista.fornecedores') }}')">Cancelar</button>
                <button class="btn btn-primary" type="submit">
                    {{ $isEdit ? 'Salvar Alteracoes' : 'Cadastrar Fornecedor' }}
                </button>
            </div>
        </form>
    </div>
</div>
<script>
    function refreshIframeLayout() {
        const iframe = document.getElementById('content-frame');
        if (!iframe || !iframe.contentWindow) {
            return;
        }
        try {
            iframe.contentWindow.dispatchEvent(new Event('resize'));
            iframe.contentWindow.postMessage({ type: 'erp:layout-resize' }, '*');
        } catch (e) {}
    }

    function loadContent(url) {
        if (url === '#') {
            alert('Esta seção ainda não foi implementada.');
            return;
        }
        window.parent.document.getElementById('content-frame').src = url;
        setTimeout(refreshIframeLayout, 200);
    }
</script>
