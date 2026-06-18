@php
    $isEdit = isset($embalagem);
    $hasStoreRoute = Route::has('pagina.salvar.embalagens');
    $hasUpdateRoute = $isEdit && Route::has('pagina.atualizar.embalagens');

    if ($isEdit && $hasUpdateRoute) {
        $formAction = route('pagina.atualizar.embalagens', ['id' => $embalagem->id]);
    } elseif (!$isEdit && $hasStoreRoute) {
        $formAction = route('pagina.salvar.embalagens');
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
                <h1 class="app-header__title">{{ $isEdit ? 'Editar embalagem' : 'Nova embalagem' }}</h1>
                <p class="app-header__subtitle">
                    {{ $isEdit ? 'Atualize os dados da embalagem.' : 'Preencha os dados para cadastrar uma nova embalagem.' }}
                </p>
            </div>
        </header>

        <div class="app-form">
            @if ($formAction === '#' || $errors->any())
                <div class="app-form__alerts">
                    @if ($formAction === '#')
                        <div class="app-alert app-alert--warn">
                            Rotas de salvar/atualizar embalagem ainda não foram criadas. Configure as rotas para concluir o envio do formulário.
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
                    <button class="app-btn app-btn--secondary" type="button" onclick="loadContent('{{ route('pagina.lista.embalagens') }}')">Cancelar</button>
                    <button class="app-btn app-btn--primary" type="submit">
                        {{ $isEdit ? 'Salvar alterações' : 'Cadastrar embalagem' }}
                    </button>
                </div>

                <div class="app-form-hero">
                    <strong>{{ old('str_descricao', $embalagem->str_descricao ?? 'Nova embalagem') }}</strong>
                </div>

                <div class="app-form-body">
                    <div class="app-section-title">Dados da embalagem</div>
                    <div class="app-field-group">
                        <div class="app-field">
                            <label for="str_sigla">Sigla</label>
                            <input type="text" id="str_sigla" name="str_sigla" maxlength="10" required
                                value="{{ old('str_sigla', $embalagem->str_sigla ?? '') }}"
                                placeholder="Ex: UN, CX, KG...">
                        </div>
                        <div class="app-field">
                            <label for="dbl_quantidade_embalagem">Quantidade</label>
                            <input type="number" id="dbl_quantidade_embalagem" name="dbl_quantidade_embalagem" step="0.01" required
                                value="{{ old('dbl_quantidade_embalagem', $embalagem->dbl_quantidade_embalagem ?? '') }}"
                                placeholder="Ex: 1,5">
                        </div>
                    </div>
                    <div class="app-field-group app-field-group--full">
                        <div class="app-field">
                            <label for="str_descricao">Descrição</label>
                            <textarea id="str_descricao" name="str_descricao" maxlength="255" required
                                placeholder="Descreva a embalagem...">{{ old('str_descricao', $embalagem->str_descricao ?? '') }}</textarea>
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
