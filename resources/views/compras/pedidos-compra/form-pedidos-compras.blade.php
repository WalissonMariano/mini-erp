@php
    $pedidoCompra = $pedidoCompra ?? null;
    $isEdit = $pedidoCompra !== null;
    $hasStoreRoute = Route::has('pagina.salvar.pedido_compra');
    $hasUpdateRoute = $isEdit && Route::has('pagina.atualizar.pedido_compra');

    if ($isEdit && $hasUpdateRoute) {
        $formAction = route('pagina.atualizar.pedido_compra', ['id' => $pedidoCompra->id]);
    } elseif (! $isEdit && $hasStoreRoute) {
        $formAction = route('pagina.salvar.pedido_compra');
    } else {
        $formAction = '#';
    }

    $statusAtual = old('status', optional($pedidoCompra)->status ?? \App\Models\Compras\PedidosCompra::STATUS_ABERTO);
    if (! in_array($statusAtual, [\App\Models\Compras\PedidosCompra::STATUS_ABERTO, \App\Models\Compras\PedidosCompra::STATUS_BAIXADO], true)) {
        $statusAtual = \App\Models\Compras\PedidosCompra::STATUS_ABERTO;
    }
    $statusLabel = \App\Models\Compras\PedidosCompra::statusLabels()[$statusAtual] ?? $statusAtual;
    $pedidoAberto = $statusAtual === \App\Models\Compras\PedidosCompra::STATUS_ABERTO;
    $dataPedido = old('data_pedido', optional($pedidoCompra)->data_pedido?->format('Y-m-d') ?? now()->format('Y-m-d'));
    $dataPedidoLabel = \Illuminate\Support\Carbon::parse($dataPedido)->format('d/m/Y');
@endphp

@vite('resources/css/app.css')
<div class="app-shell">
    <div class="app-page">
        <header class="app-header">
            <div class="app-header__text">
                <p class="app-header__eyebrow">Compras</p>
                <h1 class="app-header__title">{{ $isEdit ? 'Editar pedido de compra' : 'Novo pedido de compra' }}</h1>
                <p class="app-header__subtitle">
                    {{ $isEdit ? 'Atualize os dados do pedido e seus itens.' : 'Preencha os dados para cadastrar um novo pedido de compra.' }}
                </p>
            </div>
            @if ($isEdit)
                <button type="button" class="app-btn app-btn--secondary" onclick="loadContent('{{ route('pagina.lista.pedidos_compra') }}')">
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
                            Rotas de salvar/atualizar pedido de compra não foram localizadas. Configure as rotas para concluir o envio do formulário.
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
                        <button class="app-btn app-btn--secondary" type="button" onclick="loadContent('{{ route('pagina.lista.pedidos_compra') }}')">Cancelar</button>
                    @endunless
                    @if ($isEdit && $pedidoAberto && Route::has('pagina.baixar.pedido_compra'))
                        <button
                            type="submit"
                            class="app-btn app-btn--secondary"
                            formaction="{{ route('pagina.baixar.pedido_compra', ['id' => $pedidoCompra->id]) }}"
                            onclick="return confirm('Baixar este pedido de compra?')">
                            Baixar pedido
                        </button>
                    @endif
                    @if ($isEdit)
                        <button
                            type="submit"
                            class="app-btn app-btn--danger"
                            formaction="{{ route('pagina.deletar.pedido_compra', ['id' => $pedidoCompra->id]) }}"
                            name="_method"
                            value="DELETE"
                            onclick="return confirm('Excluir este pedido de compra permanentemente?')">
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
                                value="{{ $isEdit ? $pedidoCompra->numero_pedido : '-' }}"
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
                                <option value="" disabled {{ old('empresa_id', optional($pedidoCompra)->empresa_id) ? '' : 'selected' }}>Selecione...</option>
                                @foreach ($empresas as $emp)
                                    <option value="{{ $emp->id }}"
                                        {{ (string) old('empresa_id', optional($pedidoCompra)->empresa_id ?? '') === (string) $emp->id ? 'selected' : '' }}>
                                        {{ $emp->str_razao_social }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="app-field">
                            <label for="fornecedores_id">Fornecedor</label>
                            <select id="fornecedores_id" name="fornecedores_id" required>
                                <option value="" disabled {{ old('fornecedores_id', optional($pedidoCompra)->fornecedores_id) ? '' : 'selected' }}>Selecione...</option>
                                @foreach ($fornecedores as $f)
                                    <option value="{{ $f->id }}"
                                        {{ (string) old('fornecedores_id', optional($pedidoCompra)->fornecedores_id ?? '') === (string) $f->id ? 'selected' : '' }}>
                                        {{ $f->str_nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="app-field-group app-field-group--full">
                        <div class="app-field">
                            <label for="str_observacao">Observação</label>
                            <textarea id="str_observacao" name="str_observacao" maxlength="2000" placeholder="Observações do pedido...">{{ old('str_observacao', optional($pedidoCompra)->str_observacao ?? '') }}</textarea>
                        </div>
                    </div>

                    @include('compras.pedidos-compra-itens.form-repeater-pedidos-compra-itens', [
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
        const tbody = document.getElementById('pc-itens-tbody');
        const btnAdd = document.getElementById('pc-add-item-row');
        const tpl = document.getElementById('pc-item-row-template');
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
            root.querySelectorAll('.pc-valor-unitario').forEach(function (input) {
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
            const btn = e.target.closest('.pc-remove-item-row');
            if (!btn) {
                return;
            }
            const tr = btn.closest('tr.pc-item-linha');
            if (!tr) {
                return;
            }
            const rows = tbody.querySelectorAll('tr.pc-item-linha');
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
