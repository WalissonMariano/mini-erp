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
<div class="app-shell">
    <div class="app-page">
        <header class="app-header">
            <div class="app-header__text">
                <p class="app-header__eyebrow">Estoque</p>
                <h1 class="app-header__title">{{ $isEdit ? 'Editar item' : 'Novo item' }}</h1>
                <p class="app-header__subtitle">
                    {{ $isEdit ? 'Atualize os dados do item e suas embalagens.' : 'Preencha os dados para cadastrar um novo item.' }}
                </p>
            </div>
            @if ($isEdit)
                <button type="button" class="app-btn app-btn--secondary" onclick="loadContent('{{ route('pagina.lista.itens') }}')">
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
                            Rotas de salvar ou atualizar item ainda não estão disponíveis. Configure as rotas para enviar o formulário.
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
                        <button class="app-btn app-btn--secondary" type="button" onclick="loadContent('{{ route('pagina.lista.itens') }}')">Cancelar</button>
                    @endunless
                    @if ($isEdit)
                        <button
                            type="submit"
                            class="app-btn app-btn--danger"
                            formaction="{{ route('pagina.deletar.itens', ['id' => $item->id]) }}"
                            name="_method"
                            value="DELETE"
                            onclick="return confirm('Excluir este item permanentemente?')">
                            Excluir item
                        </button>
                    @endif
                    <button class="app-btn app-btn--primary" type="submit">
                        {{ $isEdit ? 'Salvar alterações' : 'Cadastrar' }}
                    </button>
                </div>

                <div class="app-form-hero">
                    <strong>{{ old('str_descricao', optional($item)->str_descricao ?? 'Novo item') }}</strong>
                </div>

                <div class="app-form-body">
                    <div class="app-section-title">Dados do item</div>
                    <div class="app-field-group">
                        <div class="app-field">
                            <label for="str_codigo">Código</label>
                            <input id="str_codigo" type="text" name="str_codigo" maxlength="50" required
                                value="{{ old('str_codigo', optional($item)->str_codigo ?? '') }}"
                                placeholder="Ex.: SKU-001, PROD-12…">
                        </div>
                        <div class="app-field">
                            <label for="dbl_preco">Preço</label>
                            <input id="dbl_preco" type="number" name="dbl_preco" step="0.01" min="0" required
                                value="{{ old('dbl_preco', optional($item)->dbl_preco ?? '') }}"
                                placeholder="0,00">
                        </div>
                    </div>
                    <div class="app-field-group app-field-group--full">
                        <div class="app-field">
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
                    <div class="app-field-group app-field-group--full">
                        <div class="app-field">
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
