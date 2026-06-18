@php
    $isEdit = isset($categoria);
    $hasStoreRoute = Route::has('pagina.salvar.itens_categorias');
    $hasUpdateRoute = $isEdit && Route::has('pagina.atualizar.itens_categorias');

    if ($isEdit && $hasUpdateRoute) {
        $formAction = route('pagina.atualizar.itens_categorias', ['id' => $categoria->id]);
    } elseif (!$isEdit && $hasStoreRoute) {
        $formAction = route('pagina.salvar.itens_categorias');
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
                <h1 class="app-header__title">{{ $isEdit ? 'Editar categoria' : 'Nova categoria' }}</h1>
                <p class="app-header__subtitle">
                    {{ $isEdit ? 'Atualize a descrição da categoria de itens.' : 'Preencha os dados para cadastrar uma nova categoria.' }}
                </p>
            </div>
        </header>

        <div class="app-form">
            @if ($formAction === '#' || $errors->any())
                <div class="app-form__alerts">
                    @if ($formAction === '#')
                        <div class="app-alert app-alert--warn">
                            Rotas de salvar/atualizar categoria ainda não foram criadas. Configure as rotas para concluir o envio do formulário.
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
                    <button class="app-btn app-btn--secondary" type="button" onclick="loadContent('{{ route('pagina.lista.itens_categorias') }}')">Cancelar</button>
                    <button class="app-btn app-btn--primary" type="submit">
                        {{ $isEdit ? 'Salvar alterações' : 'Cadastrar categoria' }}
                    </button>
                </div>

                <div class="app-form-hero">
                    <strong>{{ old('str_descricao', $categoria->str_descricao ?? 'Nova categoria') }}</strong>
                </div>

                <div class="app-form-body">
                    <div class="app-section-title">Descrição da categoria</div>
                    <div class="app-field-group app-field-group--full">
                        <div class="app-field">
                            <label for="str_descricao">Descrição</label>
                            <textarea id="str_descricao" name="str_descricao" maxlength="255" required
                                placeholder="Descreva a categoria de itens...">{{ old('str_descricao', $categoria->str_descricao ?? '') }}</textarea>
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
