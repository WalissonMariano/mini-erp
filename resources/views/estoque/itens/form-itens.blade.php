@php
    $isEdit = isset($item);
    $hasStoreRoute = Route::has('pagina.salvar.itens');
    $hasUpdateRoute = $isEdit && Route::has('pagina.atualizar.itens');

    if ($isEdit && $hasUpdateRoute) {
        $formAction = route('pagina.atualizar.itens', ['id' => $item->id]);
    } elseif (!$isEdit && $hasStoreRoute) {
        $formAction = route('pagina.salvar.itens');
    } else {
        $formAction = '#';
    }
@endphp

@vite('resources/css/app.css')
<div class="corp-shell">
    <style>
        :root {
            --corp-bg: #f1f5f9;
            --corp-surface: #ffffff;
            --corp-border: #e2e8f0;
            --corp-text: #0f172a;
            --corp-text-muted: #64748b;
            --corp-accent: #0c4a6e;
            --corp-accent-soft: #0369a1;
            --corp-accent-hover: #075985;
            --corp-danger: #b91c1c;
            --corp-danger-bg: #fef2f2;
            --corp-radius: 10px;
            --corp-shadow: 0 1px 2px rgba(15, 23, 42, 0.06), 0 4px 12px rgba(15, 23, 42, 0.04);
        }

        html,
        body {
            margin: 0;
            padding: 0;
            min-height: 100%;
            height: 100%;
            background: var(--corp-bg);
        }

        .corp-shell {
            min-height: 100vh;
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 14px 24px 28px;
            background: var(--corp-bg);
            font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            color: var(--corp-text);
            box-sizing: border-box;
        }

        .corp-shell *,
        .corp-shell *::before,
        .corp-shell *::after {
            box-sizing: border-box;
        }

        .corp-header {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px 16px;
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--corp-border);
        }

        .corp-header__eyebrow {
            margin: 0 0 3px 0;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--corp-text-muted);
        }

        .corp-header__title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-size: 1.125rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            color: var(--corp-text);
            line-height: 1.2;
        }

        .corp-header__title .corp-icon {
            width: 1.25rem;
            height: 1.25rem;
            color: var(--corp-accent);
            flex-shrink: 0;
        }

        .corp-header__subtitle {
            margin: 4px 0 0 0;
            font-size: 0.8125rem;
            color: var(--corp-text-muted);
            line-height: 1.35;
            max-width: 62ch;
        }

        .corp-form-card {
            width: 100%;
            max-width: 100%;
            margin: 0;
            background: var(--corp-surface);
            border: 1px solid var(--corp-border);
            border-radius: var(--corp-radius);
            box-shadow: var(--corp-shadow);
            overflow: hidden;
        }

        .corp-form-card__alerts {
            padding: 18px 20px 4px;
        }

        .corp-form-card__alerts .corp-alert + .corp-alert {
            margin-top: 10px;
        }

        .corp-form-toolbar {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            padding: 12px 20px;
            border-bottom: 1px solid var(--corp-border);
            background: linear-gradient(180deg, #fafbfc 0%, #ffffff 100%);
        }

        .corp-form-card__hero {
            margin: 10 16px 18px;
            padding: 16px 22px;
            width: auto;
            max-width: calc(100% - 32px);
            margin-left: auto;
            margin-right: auto;
            border: 1px solid var(--corp-border);
            border-radius: 8px;
            background: linear-gradient(180deg, #f8fafc 0%, #ffffff 100%);
            box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
        }

        .corp-form-card__hero strong {
            font-size: 1.0625rem;
            font-weight: 600;
            color: var(--corp-text);
            letter-spacing: -0.02em;
            line-height: 1.35;
            display: block;
        }

        .corp-form-card__body {
            padding: 8px 24px 26px;
        }

        .corp-alert {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 8px;
            font-size: 0.8125rem;
            line-height: 1.45;
        }

        .corp-alert--error {
            border: 1px solid #fecaca;
            background: var(--corp-danger-bg);
            color: var(--corp-danger);
        }

        .corp-alert--warn {
            border: 1px solid var(--corp-border);
            background: #f8fafc;
            color: var(--corp-text-muted);
        }

        .corp-alert ul {
            margin: 8px 0 0 18px;
            padding: 0;
        }

        .corp-field-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .corp-field-group--full {
            grid-template-columns: 1fr;
        }

        .corp-field label {
            display: block;
            font-size: 0.6875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--corp-text-muted);
            margin-bottom: 6px;
        }

        .corp-field input,
        .corp-field select,
        .corp-field textarea {
            width: 100%;
            font-size: 0.875rem;
            color: var(--corp-text);
            padding: 9px 11px;
            background: #f8fafc;
            border-radius: 8px;
            border: 1px solid var(--corp-border);
            min-height: 40px;
            transition: border-color 0.15s ease, box-shadow 0.15s ease, background 0.15s ease;
        }

        .corp-field input:focus,
        .corp-field select:focus,
        .corp-field textarea:focus {
            outline: none;
            border-color: var(--corp-accent-soft);
            box-shadow: 0 0 0 3px rgba(3, 105, 161, 0.12);
            background: #fff;
        }

        .corp-field textarea {
            resize: vertical;
            min-height: 88px;
        }

        .corp-field--inline {
            margin: 0;
        }

        .corp-section-title {
            font-size: 0.6875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--corp-text-muted);
            margin: 22px 0 12px 0;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--corp-border);
        }

        .corp-section-title:first-of-type {
            margin-top: 4px;
        }

        .corp-hint {
            font-size: 0.8125rem;
            color: var(--corp-text-muted);
            margin: 0 0 14px 0;
            line-height: 1.45;
        }

        .corp-btn--toolbar {
            min-width: 7.5rem;
        }

        .corp-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 18px;
            border: none;
            border-radius: 8px;
            font-size: 0.8125rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s ease, border-color 0.2s ease, color 0.2s ease;
        }

        .corp-btn--primary {
            background: var(--corp-accent);
            color: #fff;
            box-shadow: 0 1px 2px rgba(12, 74, 110, 0.25);
        }

        .corp-btn--primary:hover {
            background: var(--corp-accent-hover);
        }

        .corp-btn--secondary {
            background: #fff;
            color: var(--corp-text);
            border: 1px solid var(--corp-border);
        }

        .corp-btn--secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e1;
        }

        .corp-btn .corp-icon {
            width: 1rem;
            height: 1rem;
        }

        @media (max-width: 640px) {
            .corp-shell {
                padding: 12px 16px 24px;
            }

            .corp-field-group {
                grid-template-columns: 1fr;
            }

            .corp-form-card__alerts {
                padding: 14px 16px 4px;
            }

            .corp-form-toolbar {
                padding: 10px 16px;
                flex-direction: column-reverse;
                align-items: stretch;
            }

            .corp-form-toolbar .corp-btn {
                width: 100%;
            }

            .corp-form-card__hero {
                margin: 0 12px 14px;
                max-width: calc(100% - 24px);
                padding: 14px 16px;
            }

            .corp-form-card__body {
                padding: 6px 16px 22px;
            }
        }
    </style>

    <header class="corp-header">
        <div>
            <p class="corp-header__eyebrow">Estoque</p>
            <h1 class="corp-header__title">
                @if ($isEdit)
                    <x-icon name="heroicon-o-pencil-square" class="corp-icon" />
                    Editar item
                @else
                    <x-icon name="heroicon-o-cube" class="corp-icon" />
                    Novo item
                @endif
            </h1>
        </div>
    </header>

    <div class="corp-form-card">
        @if ($formAction === '#' || $errors->any())
            <div class="corp-form-card__alerts">
                @if ($formAction === '#')
                    <div class="corp-alert corp-alert--warn">
                        Rotas de salvar ou atualizar item ainda não estão disponíveis. Configure as rotas para enviar o formulário.
                    </div>
                @endif

                @if ($errors->any())
                    <div class="corp-alert corp-alert--error">
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

        <form id="corp-item-form" action="{{ $formAction }}" method="POST">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="corp-form-toolbar">
                <button class="corp-btn corp-btn--secondary corp-btn--toolbar" type="button" onclick="loadContent('{{ route('pagina.lista.itens') }}')">Cancelar</button>
                <button class="corp-btn corp-btn--primary corp-btn--toolbar" type="submit">
                    {{ $isEdit ? 'Salvar alterações' : 'Cadastrar item' }}
                </button>
            </div>

            <div class="corp-form-card__hero">
                <strong>{{ old('str_descricao', optional($item)->str_descricao ?? 'Novo item') }}</strong>
            </div>

            <div class="corp-form-card__body">
                <div class="corp-section-title">Dados do item</div>
                <div class="corp-field-group">
                    <div class="corp-field">
                        <label for="str_codigo">Código</label>
                        <input id="str_codigo" type="text" name="str_codigo" maxlength="50" required
                            value="{{ old('str_codigo', optional($item)->str_codigo ?? '') }}"
                            placeholder="Ex.: SKU-001, PROD-12…">
                    </div>
                    <div class="corp-field">
                        <label for="dbl_preco">Preço</label>
                        <input id="dbl_preco" type="number" name="dbl_preco" step="0.01" min="0" required
                            value="{{ old('dbl_preco', optional($item)->dbl_preco ?? '') }}"
                            placeholder="0,00">
                    </div>
                </div>
                <div class="corp-field-group corp-field-group--full">
                    <div class="corp-field">
                        <label for="categoria_id">Categoria</label>
                        <select id="categoria_id" name="categoria_id" required>
                            @php
                                $categoriaAtual = old('categoria_id', optional($item)->categoria_id);
                            @endphp
                            <option value="" disabled {{ $categoriaAtual ? '' : 'selected' }}>Selecione uma categoria</option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}"
                                    {{ (string) $categoriaAtual === (string) $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->str_descricao }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="corp-field-group corp-field-group--full">
                    <div class="corp-field">
                        <label for="str_descricao">Descrição</label>
                        <textarea id="str_descricao" name="str_descricao" maxlength="150" required
                            placeholder="Descrição do item…">{{ old('str_descricao', optional($item)->str_descricao ?? '') }}</textarea>
                    </div>
                </div>

                @include('estoque.itens-embalagens.form-repeater-itens-embalagens', [
                    'embalagens' => $embalagens,
                    'embalagensSelecionadas' => $embalagensSelecionadas ?? [],
                ])
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

    (function () {
        const tbody = document.getElementById('embalagem-tbody');
        const btnAdd = document.getElementById('embalagem-add-linha');
        if (!tbody || !btnAdd) {
            return;
        }

        function renumberEmbalagemLinhas() {
            tbody.querySelectorAll('tr.embalagem-linha').forEach(function (tr, i) {
                const cell = tr.querySelector('.embalagem-idx');
                if (cell) {
                    cell.textContent = String(i + 1);
                }
            });
        }

        btnAdd.addEventListener('click', function () {
            const ref = tbody.querySelector('tr.embalagem-linha');
            if (!ref) {
                return;
            }
            const clone = ref.cloneNode(true);
            clone.querySelectorAll('select').forEach(function (sel) {
                sel.selectedIndex = 0;
                sel.value = '';
            });
            tbody.appendChild(clone);
            renumberEmbalagemLinhas();
        });

        tbody.addEventListener('click', function (e) {
            const btn = e.target.closest('.embalagem-remover-linha');
            if (!btn) {
                return;
            }
            const tr = btn.closest('tr.embalagem-linha');
            if (!tr) {
                return;
            }
            const rows = tbody.querySelectorAll('tr.embalagem-linha');
            if (rows.length <= 1) {
                tr.querySelectorAll('select').forEach(function (sel) {
                    sel.selectedIndex = 0;
                    sel.value = '';
                });
                return;
            }
            tr.remove();
            renumberEmbalagemLinhas();
        });
    })();
</script>
