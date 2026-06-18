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
@endphp

@vite('resources/css/app.css')
<div style="padding: 0 20px 20px 20px; background-color: #ffffff; min-height: 100vh; font-family: Arial, sans-serif;">
    <style>
        * { font-family: Arial, sans-serif; }

        .card {
            background: white;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 24px;
            max-width: 1000px;
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

        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.15);
            background: #fff;
        }

        .field textarea { min-height: 72px; resize: vertical; }

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

    <h2>{{ $isEdit ? 'Editar pedido de venda' : 'Novo pedido de venda' }}</h2>

    <div class="card">
        @if ($formAction === '#')
            <div class="alert alert-error">
                Rotas de salvar/atualizar pedido de venda nao foram localizadas.
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
                    {{ old('status', optional($pedidoVenda)->status ?? 'rascunho') }}
                    — {{ old('data_pedido', optional($pedidoVenda)->data_pedido?->format('Y-m-d') ?? now()->format('Y-m-d')) }}
                </strong>
            </div>

            <div class="section-title">Dados do pedido (pedidos_venda)</div>
            <div class="field-group three">
                <div class="field">
                    <label>Data do pedido</label>
                    <input type="date" name="data_pedido" required
                        value="{{ old('data_pedido', optional($pedidoVenda)->data_pedido?->format('Y-m-d') ?? now()->format('Y-m-d')) }}">
                </div>
                <div class="field">
                    <label>Status</label>
                    <input type="text" name="status" maxlength="20" required
                        value="{{ old('status', optional($pedidoVenda)->status ?? 'rascunho') }}"
                        placeholder="rascunho, confirmado...">
                </div>
                <div class="field">
                    <label>Empresa</label>
                    <select name="empresa_id" required>
                        <option value="" disabled {{ old('empresa_id', optional($pedidoVenda)->empresa_id) ? '' : 'selected' }}>Selecione...</option>
                        @foreach ($empresas as $emp)
                            <option value="{{ $emp->id }}"
                                {{ (string) old('empresa_id', optional($pedidoVenda)->empresa_id ?? '') === (string) $emp->id ? 'selected' : '' }}>
                                {{ $emp->str_razao_social }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="field-group">
                <div class="field">
                    <label>Cliente</label>
                    <select name="cliente_id">
                        <option value="">(opcional)</option>
                        @foreach ($clientes as $c)
                            <option value="{{ $c->id }}"
                                {{ (string) old('cliente_id', optional($pedidoVenda)->cliente_id ?? '') === (string) $c->id ? 'selected' : '' }}>
                                {{ $c->str_nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Vendedor</label>
                    <select name="vendedor_id">
                        <option value="">(opcional)</option>
                        @foreach ($vendedores as $v)
                            <option value="{{ $v->id }}"
                                {{ (string) old('vendedor_id', optional($pedidoVenda)->vendedor_id ?? '') === (string) $v->id ? 'selected' : '' }}>
                                {{ $v->str_nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="field-group full">
                <div class="field">
                    <label>Observacao</label>
                    <textarea name="str_observacao" maxlength="2000" placeholder="Observacoes do pedido...">{{ old('str_observacao', optional($pedidoVenda)->str_observacao ?? '') }}</textarea>
                </div>
            </div>

            @include('vendas.pedidos-venda-itens.form-repeater-pedidos-venda-itens', [
                'catalogoItens' => $catalogoItens,
                'itensFormRows' => $itensFormRows,
            ])

            <div class="actions">
                <button class="btn btn-secondary" type="button" onclick="loadContent('{{ route('pagina.lista.pedidos_venda') }}')">Cancelar</button>
                <button class="btn btn-primary" type="submit">{{ $isEdit ? 'Salvar alteracoes' : 'Cadastrar pedido' }}</button>
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

    (function () {
        const tbody = document.getElementById('pv-itens-tbody');
        const btnAdd = document.getElementById('pv-add-item-row');
        const tpl = document.getElementById('pv-item-row-template');
        if (!tbody || !btnAdd || !tpl) return;

        function bindRemover(tr) {
            tr.querySelectorAll('.pv-remove-item-row').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    const rows = tbody.querySelectorAll('tr.pv-item-linha');
                    if (rows.length <= 1) {
                        tr.querySelectorAll('select,input').forEach(function (el) {
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
            });
        }

        tbody.querySelectorAll('tr.pv-item-linha').forEach(bindRemover);

        btnAdd.addEventListener('click', function () {
            const clone = tpl.content.cloneNode(true);
            const tr = clone.querySelector('tr');
            if (!tr) return;
            tbody.appendChild(tr);
            bindRemover(tr);
        });
    })();
</script>
