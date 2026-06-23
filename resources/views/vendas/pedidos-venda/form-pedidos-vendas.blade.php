@php
    $pedidoVenda = $pedidoVenda ?? null;
    $isEdit = $pedidoVenda !== null;
    $hasStoreRoute = Route::has('pagina.salvar.pedido_venda');
    $hasUpdateRoute = $isEdit && Route::has('pagina.atualizar.pedido_venda');

    if ($isEdit && $hasUpdateRoute) {
        $formAction = route('pagina.atualizar.pedido_venda', ['id' => $pedidoVenda->id]);
    } elseif (! $isEdit && $hasStoreRoute) {
        $formAction = route('pagina.salvar.pedido_venda');
    } else {
        $formAction = '#';
    }

    $statusAtual = old('status', optional($pedidoVenda)->status ?? \App\Models\Venda\PedidosVenda::STATUS_ABERTO);
    if (! in_array($statusAtual, [\App\Models\Venda\PedidosVenda::STATUS_ABERTO, \App\Models\Venda\PedidosVenda::STATUS_BAIXADO], true)) {
        $statusAtual = \App\Models\Venda\PedidosVenda::STATUS_ABERTO;
    }
    $statusLabel = \App\Models\Venda\PedidosVenda::statusLabels()[$statusAtual] ?? $statusAtual;
    $pedidoAberto = $statusAtual === \App\Models\Venda\PedidosVenda::STATUS_ABERTO;
    $dataPedido = old('data_pedido', optional($pedidoVenda)->data_pedido?->format('Y-m-d') ?? now()->format('Y-m-d'));
    $dataPedidoLabel = \Illuminate\Support\Carbon::parse($dataPedido)->format('d/m/Y');
@endphp

@vite('resources/css/app.css')
<div class="app-shell">
    <div class="app-page">
        <header class="app-header">
            <div class="app-header__text">
                <p class="app-header__eyebrow">Vendas</p>
                <h1 class="app-header__title">{{ $isEdit ? 'Editar pedido de venda' : 'Novo pedido de venda' }}</h1>
                <p class="app-header__subtitle">
                    {{ $isEdit ? 'Atualize os dados do pedido e seus itens.' : 'Preencha os dados para cadastrar um novo pedido de venda.' }}
                </p>
            </div>
            @if ($isEdit)
                <button type="button" class="app-btn app-btn--secondary" onclick="loadContent('{{ route('pagina.lista.pedidos_venda') }}')">
                    <x-icon name="heroicon-o-arrow-left" class="app-icon" />
                    Voltar
                </button>
            @endif
        </header>

        <div class="app-form app-form--toolbar-top">
            @if ($formAction === '#' || $errors->any())
                <div class="app-form__alerts">
                    @if ($formAction === '#')
                        <div class="app-alert app-alert--warn">
                            Rotas de salvar/atualizar pedido de venda não foram localizadas. Configure as rotas para concluir o envio do formulário.
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
                        <button class="app-btn app-btn--secondary" type="button" onclick="loadContent('{{ route('pagina.lista.pedidos_venda') }}')">Cancelar</button>
                    @endunless
                    @if ($isEdit && $pedidoAberto && Route::has('pagina.baixar.pedido_venda'))
                        <button
                            type="submit"
                            class="app-btn app-btn--secondary"
                            formaction="{{ route('pagina.baixar.pedido_venda', ['id' => $pedidoVenda->id]) }}"
                            onclick="return confirm('Baixar este pedido de venda?')">
                            Baixar pedido
                        </button>
                    @endif
                    @if ($isEdit)
                        <button
                            type="submit"
                            class="app-btn app-btn--danger"
                            formaction="{{ route('pagina.deletar.pedido_venda', ['id' => $pedidoVenda->id]) }}"
                            name="_method"
                            value="DELETE"
                            onclick="return confirm('Excluir este pedido de venda permanentemente?')">
                            Excluir pedido
                        </button>
                    @endif
                    <button class="app-btn app-btn--primary" type="submit">
                        {{ $isEdit ? 'Salvar alterações' : 'Cadastrar' }}
                    </button>
                </div>

                <div class="app-form-body">
                    <div class="app-section-title">Dados do pedido</div>
                    <div class="app-field-group app-field-group--three">
                        <div class="app-field app-field--numero-pedido">
                            <label for="pedido_numero">Número do pedido</label>
                            <input type="text" id="pedido_numero"
                                value="{{ $isEdit ? $pedidoVenda->numero_pedido : '-' }}"
                                readonly disabled>
                        </div>
                        <div class="app-field">
                            <label for="data_pedido">Data do pedido</label>
                            <input type="text" id="data_pedido" value="{{ $dataPedidoLabel }}" readonly disabled>
                            <input type="hidden" name="data_pedido" value="{{ $dataPedido }}">
                        </div>
                        <div class="app-field">
                            <label for="status">Status</label>
                            <input type="text" id="status" value="{{ $statusLabel }}" readonly disabled>
                            <input type="hidden" name="status" value="{{ $statusAtual }}">
                        </div>
                    </div>
                    <div class="app-field-group app-field-group--three">
                        <div class="app-field">
                            <label for="empresa_id">Empresa</label>
                            <select id="empresa_id" name="empresa_id" required>
                                <option value="" disabled {{ old('empresa_id', optional($pedidoVenda)->empresa_id) ? '' : 'selected' }}>Selecione...</option>
                                @foreach ($empresas as $emp)
                                    <option value="{{ $emp->id }}"
                                        {{ (string) old('empresa_id', optional($pedidoVenda)->empresa_id ?? '') === (string) $emp->id ? 'selected' : '' }}>
                                        {{ $emp->str_razao_social }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="app-field">
                            <label for="cliente_id">Cliente</label>
                            <select id="cliente_id" name="cliente_id" required>
                                <option value="" disabled {{ old('cliente_id', optional($pedidoVenda)->cliente_id) ? '' : 'selected' }}>Selecione...</option>
                                @foreach ($clientes as $c)
                                    <option value="{{ $c->id }}"
                                        {{ (string) old('cliente_id', optional($pedidoVenda)->cliente_id ?? '') === (string) $c->id ? 'selected' : '' }}>
                                        {{ $c->str_nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="app-field">
                            <label for="vendedor_id">Vendedor</label>
                            <select id="vendedor_id" name="vendedor_id" required>
                                <option value="" disabled {{ old('vendedor_id', optional($pedidoVenda)->vendedor_id) ? '' : 'selected' }}>Selecione...</option>
                                @foreach ($vendedores as $v)
                                    <option value="{{ $v->id }}"
                                        {{ (string) old('vendedor_id', optional($pedidoVenda)->vendedor_id ?? '') === (string) $v->id ? 'selected' : '' }}>
                                        {{ $v->str_nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="app-field-group app-field-group--full">
                        <div class="app-field">
                            <label for="str_observacao">Observação</label>
                            <textarea id="str_observacao" name="str_observacao" maxlength="2000" placeholder="Observações do pedido...">{{ old('str_observacao', optional($pedidoVenda)->str_observacao ?? '') }}</textarea>
                        </div>
                    </div>

                    @include('vendas.pedidos-venda-itens.form-repeater-pedidos-venda-itens', [
                        'catalogoItens' => $catalogoItens,
                        'itensFormRows' => $itensFormRows,
                    ])
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

    (function () {
        const tbody = document.getElementById('pv-itens-tbody');
        const btnAdd = document.getElementById('pv-add-item-row');
        const tpl = document.getElementById('pv-item-row-template');
        if (!tbody || !btnAdd || !tpl) {
            return;
        }

        function formatValorUnitario(input) {
            if (!input || input.value === '') {
                return;
            }
            const valor = parseFloat(String(input.value).replace(',', '.'));
            if (Number.isNaN(valor) || valor < 0) {
                return;
            }
            input.value = valor.toFixed(2);
        }

        function bindValorUnitarioInputs(root) {
            root.querySelectorAll('.pv-valor-unitario').forEach(function (input) {
                if (input.dataset.boundValorUnit === '1') {
                    return;
                }
                input.dataset.boundValorUnit = '1';
                formatValorUnitario(input);
                input.addEventListener('blur', function () {
                    formatValorUnitario(input);
                });
            });
        }

        bindValorUnitarioInputs(tbody);

        tbody.addEventListener('click', function (e) {
            const btn = e.target.closest('.pv-remove-item-row');
            if (!btn) {
                return;
            }
            const tr = btn.closest('tr.pv-item-linha');
            if (!tr) {
                return;
            }
            const rows = tbody.querySelectorAll('tr.pv-item-linha');
            if (rows.length <= 1) {
                tr.querySelectorAll('select, input').forEach(function (el) {
                    if (el.tagName === 'SELECT') {
                        el.selectedIndex = 0;
                    } else {
                        el.value = '';
                    }
                });
                return;
            }
            tr.remove();
        });

        btnAdd.addEventListener('click', function () {
            const clone = tpl.content.cloneNode(true);
            const tr = clone.querySelector('tr');
            if (!tr) {
                return;
            }
            tbody.appendChild(tr);
            bindValorUnitarioInputs(tr);
        });
    })();
</script>
