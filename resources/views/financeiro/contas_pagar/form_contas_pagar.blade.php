@php
    $conta = $conta ?? null;
    $isEdit = $conta !== null;
    $hasStoreRoute = Route::has('pagina.salvar.conta_pagar');
    $hasUpdateRoute = $isEdit && Route::has('pagina.atualizar.conta_pagar');

    if ($isEdit && $hasUpdateRoute) {
        $formAction = route('pagina.atualizar.conta_pagar', ['id' => $conta->id]);
    } elseif (! $isEdit && $hasStoreRoute) {
        $formAction = route('pagina.salvar.conta_pagar');
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

        .field-group.full { grid-template-columns: 1fr; }

        .field-group.three { grid-template-columns: 1fr 1fr 1fr; }

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
        .field select,
        .field textarea {
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

        .field textarea { min-height: 80px; resize: vertical; }

        .field input:focus,
        .field select:focus,
        .field textarea:focus {
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

        .alert { margin-bottom: 16px; padding: 10px 12px; border-radius: 4px; font-size: 14px; }

        .alert-error {
            border: 1px solid #f5c6cb;
            background: #fdecea;
            color: #a94442;
        }
    </style>

    <h2>{{ $isEdit ? 'Editar conta a pagar' : 'Nova conta a pagar' }}</h2>

    <div class="card">
        @if ($formAction === '#')
            <div class="alert alert-error">Rotas de salvar/atualizar conta a pagar nao foram localizadas.</div>
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
                    {{ old('str_descricao', optional($conta)->str_descricao ?: 'Conta a pagar') }}
                </strong>
            </div>

            <div class="section-title">Dados (contas_pagar)</div>

            <div class="field-group full">
                <div class="field">
                    <label>Descricao</label>
                    <input type="text" name="str_descricao" maxlength="255" value="{{ old('str_descricao', optional($conta)->str_descricao ?? '') }}" placeholder="Ex.: NF fornecedor X">
                </div>
            </div>

            <div class="field-group three">
                <div class="field">
                    <label>Valor (R$)</label>
                    <input type="number" name="dbl_valor" step="0.01" min="0" required
                        value="{{ old('dbl_valor', optional($conta)->dbl_valor ?? '') }}">
                </div>
                <div class="field">
                    <label>Vencimento</label>
                    <input type="date" name="data_vencimento" required
                        value="{{ old('data_vencimento', optional($conta)->data_vencimento?->format('Y-m-d') ?? '') }}">
                </div>
                <div class="field">
                    <label>Data pagamento</label>
                    <input type="date" name="data_pagamento"
                        value="{{ old('data_pagamento', optional($conta)->data_pagamento?->format('Y-m-d') ?? '') }}">
                </div>
            </div>

            <div class="field-group">
                <div class="field">
                    <label>Status</label>
                    <select name="status" required>
                        @foreach (['aberto' => 'Aberto', 'pago' => 'Pago', 'cancelado' => 'Cancelado'] as $val => $label)
                            <option value="{{ $val }}" {{ old('status', optional($conta)->status ?? 'aberto') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Empresa</label>
                    <select name="empresa_id" required>
                        <option value="" disabled {{ old('empresa_id', optional($conta)->empresa_id) ? '' : 'selected' }}>Selecione...</option>
                        @foreach ($empresas as $emp)
                            <option value="{{ $emp->id }}"
                                {{ (string) old('empresa_id', optional($conta)->empresa_id ?? '') === (string) $emp->id ? 'selected' : '' }}>
                                {{ $emp->str_razao_social }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="field-group full">
                <div class="field">
                    <label>Fornecedor (opcional)</label>
                    <select name="fornecedores_id">
                        <option value="">(sem vinculo)</option>
                        @foreach ($fornecedores as $f)
                            <option value="{{ $f->id }}"
                                {{ (string) old('fornecedores_id', optional($conta)->fornecedores_id ?? '') === (string) $f->id ? 'selected' : '' }}>
                                {{ $f->str_nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="field-group full">
                <div class="field">
                    <label>Observacao</label>
                    <textarea name="str_observacao" maxlength="2000" placeholder="Observacoes...">{{ old('str_observacao', optional($conta)->str_observacao ?? '') }}</textarea>
                </div>
            </div>

            <div class="actions">
                <button class="btn btn-secondary" type="button" onclick="loadContent('{{ route('pagina.lista.contas_pagar') }}')">Cancelar</button>
                <button class="btn btn-primary" type="submit">{{ $isEdit ? 'Salvar alteracoes' : 'Cadastrar' }}</button>
            </div>
        </form>
    </div>
</div>
<script>
    function refreshIframeLayout() {
        const iframe = document.getElementById('content-frame');
        if (!iframe || !iframe.contentWindow) return;
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
