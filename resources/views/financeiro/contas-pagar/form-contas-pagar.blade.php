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

@vite('resources/css/app.css')
<div class="app-shell">
    <div class="app-page">
        <header class="app-header">
            <div class="app-header__text">
                <p class="app-header__eyebrow">Financeiro</p>
                <h1 class="app-header__title">{{ $isEdit ? 'Editar conta a pagar' : 'Nova conta a pagar' }}</h1>
                <p class="app-header__subtitle">
                    {{ $isEdit ? 'Atualize os dados do título a pagar.' : 'Preencha os dados para cadastrar uma nova conta a pagar.' }}
                </p>
            </div>
        </header>

        <div class="app-form">
            @if ($formAction === '#' || $errors->any())
                <div class="app-form__alerts">
                    @if ($formAction === '#')
                        <div class="app-alert app-alert--warn">
                            Rotas de salvar/atualizar conta a pagar não foram localizadas.
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="app-alert app-alert--error">
                            <strong>Verifique os campos abaixo.</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            @endif

            <form action="{{ $formAction }}" method="POST">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="app-form-toolbar">
                    <button class="app-btn app-btn--secondary" type="button" onclick="loadContent('{{ route('pagina.lista.contas_pagar') }}')">Cancelar</button>
                    <button class="app-btn app-btn--primary" type="submit">
                        {{ $isEdit ? 'Salvar alterações' : 'Cadastrar conta' }}
                    </button>
                </div>

                <div class="app-form-hero">
                    <strong>{{ old('str_descricao', optional($conta)->str_descricao ?: 'Conta a pagar') }}</strong>
                </div>

                <div class="app-form-body">
                    <div class="app-section-title">Identificação</div>
                    <div class="app-field-group app-field-group--full">
                        <div class="app-field">
                            <label for="str_descricao">Descrição</label>
                            <input type="text" id="str_descricao" name="str_descricao" maxlength="255" value="{{ old('str_descricao', optional($conta)->str_descricao ?? '') }}" placeholder="Ex.: NF fornecedor X">
                        </div>
                    </div>

                    <div class="app-section-title">Valores e datas</div>
                    <div class="app-field-group app-field-group--three">
                        <div class="app-field">
                            <label for="dbl_valor">Valor (R$)</label>
                            <input type="number" id="dbl_valor" name="dbl_valor" step="0.01" min="0" required
                                value="{{ old('dbl_valor', optional($conta)->dbl_valor ?? '') }}">
                        </div>
                        <div class="app-field">
                            <label for="data_vencimento">Vencimento</label>
                            <input type="date" id="data_vencimento" name="data_vencimento" required
                                value="{{ old('data_vencimento', optional($conta)->data_vencimento?->format('Y-m-d') ?? '') }}">
                        </div>
                        <div class="app-field">
                            <label for="data_pagamento">Data pagamento</label>
                            <input type="date" id="data_pagamento" name="data_pagamento"
                                value="{{ old('data_pagamento', optional($conta)->data_pagamento?->format('Y-m-d') ?? '') }}">
                        </div>
                    </div>

                    <div class="app-section-title">Status e vínculos</div>
                    <div class="app-field-group">
                        <div class="app-field">
                            <label for="status">Status</label>
                            <select id="status" name="status" required>
                                @foreach (['aberto' => 'Aberto', 'pago' => 'Pago', 'cancelado' => 'Cancelado'] as $val => $label)
                                    <option value="{{ $val }}" {{ old('status', optional($conta)->status ?? 'aberto') === $val ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="app-field">
                            <label for="empresa_id">Empresa</label>
                            <select id="empresa_id" name="empresa_id" required>
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

                    <div class="app-field-group app-field-group--full">
                        <div class="app-field">
                            <label for="fornecedores_id">Fornecedor (opcional)</label>
                            <select id="fornecedores_id" name="fornecedores_id">
                                <option value="">(sem vínculo)</option>
                                @foreach ($fornecedores as $f)
                                    <option value="{{ $f->id }}"
                                        {{ (string) old('fornecedores_id', optional($conta)->fornecedores_id ?? '') === (string) $f->id ? 'selected' : '' }}>
                                        {{ $f->str_nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="app-section-title">Observações</div>
                    <div class="app-field-group app-field-group--full">
                        <div class="app-field">
                            <label for="str_observacao">Observação</label>
                            <textarea id="str_observacao" name="str_observacao" maxlength="2000" placeholder="Observações...">{{ old('str_observacao', optional($conta)->str_observacao ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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
        } catch (e) {
            // Ignore cross-context resize issues and keep UI functional.
        }
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
