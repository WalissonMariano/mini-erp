@php
    $conta = $conta ?? null;
    $isEdit = $conta !== null;
    $hasStoreRoute = Route::has('pagina.salvar.conta_receber');
    $hasUpdateRoute = $isEdit && Route::has('pagina.atualizar.conta_receber');

    if ($isEdit && $hasUpdateRoute) {
        $formAction = route('pagina.atualizar.conta_receber', ['id' => $conta->id]);
    } elseif (! $isEdit && $hasStoreRoute) {
        $formAction = route('pagina.salvar.conta_receber');
    } else {
        $formAction = '#';
    }

    $statusAtual = old('status', optional($conta)->status ?? \App\Models\Financeiro\ContasReceber::STATUS_ABERTO);
    if (! in_array($statusAtual, [\App\Models\Financeiro\ContasReceber::STATUS_ABERTO, \App\Models\Financeiro\ContasReceber::STATUS_PAGO, \App\Models\Financeiro\ContasReceber::STATUS_CANCELADO], true)) {
        $statusAtual = \App\Models\Financeiro\ContasReceber::STATUS_ABERTO;
    }
    $statusLabel = \App\Models\Financeiro\ContasReceber::statusLabels()[$statusAtual] ?? $statusAtual;
    $tituloAberto = $statusAtual === \App\Models\Financeiro\ContasReceber::STATUS_ABERTO;
    $dataRecebimento = old('data_recebimento', optional($conta)->data_recebimento?->format('Y-m-d') ?? '');
    $dataRecebimentoLabel = $dataRecebimento !== '' ? \Illuminate\Support\Carbon::parse($dataRecebimento)->format('d/m/Y') : '—';

    $descricaoHero = trim((string) old('str_descricao', optional($conta)->str_descricao ?? ''));
    $clienteIdHero = (string) old('cliente_id', optional($conta)->cliente_id ?? '');
    $nomeClienteHero = optional($conta)->cliente?->str_nome;
    if ($nomeClienteHero === null && $clienteIdHero !== '') {
        $nomeClienteHero = optional($clientes->firstWhere('id', $clienteIdHero))->str_nome;
    }
    $heroTitulo = match (true) {
        $descricaoHero !== '' && $nomeClienteHero !== null && $nomeClienteHero !== '' => "{$descricaoHero} — {$nomeClienteHero}",
        $descricaoHero !== '' => $descricaoHero,
        $nomeClienteHero !== null && $nomeClienteHero !== '' => $nomeClienteHero,
        default => 'Conta a receber',
    };
@endphp

@vite('resources/css/app.css')
<div class="app-shell">
    <div class="app-page">
        <header class="app-header">
            <div class="app-header__text">
                <p class="app-header__eyebrow">Financeiro</p>
                <h1 class="app-header__title">{{ $isEdit ? 'Editar conta a receber' : 'Nova conta a receber' }}</h1>
                <p class="app-header__subtitle">
                    {{ $isEdit ? 'Atualize os dados do título a receber.' : 'Preencha os dados para cadastrar uma nova conta a receber.' }}
                </p>
            </div>
            @if ($isEdit)
                <button type="button" class="app-btn app-btn--secondary" onclick="loadContent('{{ route('pagina.lista.contas_receber') }}')">
                    <x-icon name="heroicon-o-arrow-left" class="app-icon" />
                    Voltar
                </button>
            @endif
        </header>

        <div class="app-form">
            @if ($formAction === '#' || $errors->any())
                <div class="app-form__alerts">
                    @if ($formAction === '#')
                        <div class="app-alert app-alert--warn">
                            Rotas de salvar/atualizar conta a receber não foram localizadas.
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
                    @unless ($isEdit)
                        <button class="app-btn app-btn--secondary" type="button" onclick="loadContent('{{ route('pagina.lista.contas_receber') }}')">Cancelar</button>
                    @endunless
                    @if ($isEdit && $tituloAberto && Route::has('pagina.baixar.conta_receber'))
                        <button
                            type="submit"
                            class="app-btn app-btn--secondary"
                            formaction="{{ route('pagina.baixar.conta_receber', ['id' => $conta->id]) }}"
                            onclick="return confirm('Baixar este título a receber?')">
                            Baixar título
                        </button>
                    @endif
                    @if ($isEdit && Route::has('pagina.deletar.conta_receber'))
                        <button
                            type="submit"
                            class="app-btn app-btn--danger"
                            formaction="{{ route('pagina.deletar.conta_receber', ['id' => $conta->id]) }}"
                            name="_method"
                            value="DELETE"
                            onclick="return confirm('Excluir esta conta a receber permanentemente?')">
                            Excluir conta
                        </button>
                    @endif
                    <button class="app-btn app-btn--primary" type="submit">
                        {{ $isEdit ? 'Salvar alterações' : 'Cadastrar conta' }}
                    </button>
                </div>

                <div class="app-form-hero">
                    <strong>{{ $heroTitulo }}</strong>
                </div>

                <div class="app-form-body">
                    <div class="app-section-title">Identificação</div>
                    <div class="app-field-group app-field-group--full">
                        <div class="app-field">
                            <label for="str_descricao">Descrição</label>
                            <input type="text" id="str_descricao" name="str_descricao" maxlength="255" required value="{{ old('str_descricao', optional($conta)->str_descricao ?? '') }}" placeholder="Ex.: Parcela pedido 10">
                        </div>
                    </div>

                    <div class="app-section-title">Status e vínculos</div>
                    <div class="app-field-group app-field-group--three">
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
                        <div class="app-field">
                            <label for="cliente_id">Cliente</label>
                            <select id="cliente_id" name="cliente_id" required>
                                <option value="" disabled {{ old('cliente_id', optional($conta)->cliente_id) ? '' : 'selected' }}>Selecione...</option>
                                @foreach ($clientes as $c)
                                    <option value="{{ $c->id }}"
                                        {{ (string) old('cliente_id', optional($conta)->cliente_id ?? '') === (string) $c->id ? 'selected' : '' }}>
                                        {{ $c->str_nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="app-field">
                            <label for="status">Status</label>
                            <input type="text" id="status" value="{{ $statusLabel }}" readonly disabled>
                            <input type="hidden" name="status" value="{{ $statusAtual }}">
                        </div>
                    </div>

                    <div class="app-section-title">Valores e datas</div>
                    <div class="app-field-group app-field-group--three">
                        <div class="app-field">
                            <label for="dbl_valor">Valor</label>
                            <div class="app-repeater__money">
                                <span class="app-repeater__money-prefix">R$</span>
                                <input type="number" id="dbl_valor" name="dbl_valor" class="cr-valor" step="0.01" min="0" required
                                    value="{{ old('dbl_valor', optional($conta)->dbl_valor ?? '') }}">
                            </div>
                        </div>
                        <div class="app-field">
                            <label for="data_vencimento">Vencimento</label>
                            <input type="date" id="data_vencimento" name="data_vencimento" required
                                value="{{ old('data_vencimento', optional($conta)->data_vencimento?->format('Y-m-d') ?? '') }}">
                        </div>
                        <div class="app-field">
                            <label for="data_recebimento">Data recebimento</label>
                            @if ($tituloAberto)
                                <input type="text" id="data_recebimento" value="—" readonly disabled>
                            @else
                                <input type="text" id="data_recebimento" value="{{ $dataRecebimentoLabel }}" readonly disabled>
                                <input type="hidden" name="data_recebimento" value="{{ $dataRecebimento }}">
                            @endif
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

    (function () {
        function formatValor(input) {
            if (!input || input.value === '') {
                return;
            }
            const valor = parseFloat(String(input.value).replace(',', '.'));
            if (Number.isNaN(valor) || valor < 0) {
                return;
            }
            input.value = valor.toFixed(2);
        }

        document.querySelectorAll('.cr-valor').forEach(function (input) {
            formatValor(input);
            input.addEventListener('blur', function () {
                formatValor(input);
            });
        });
    })();
</script>
