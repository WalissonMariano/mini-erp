@php
    $isEdit = isset($grupo);
    $hasStoreRoute = Route::has('pagina.salvar.grupos');
    $hasUpdateRoute = $isEdit && Route::has('pagina.atualizar.grupos');

    if ($isEdit && $hasUpdateRoute) {
        $formAction = route('pagina.atualizar.grupos', ['id' => $grupo->id]);
    } elseif (!$isEdit && $hasStoreRoute) {
        $formAction = route('pagina.salvar.grupos');
    } else {
        $formAction = '#';
    }
@endphp

@vite('resources/css/app.css')
<div class="app-shell">
    <div class="app-page">
        <header class="app-header">
            <div class="app-header__text">
                <p class="app-header__eyebrow">Cadastro</p>
                <h1 class="app-header__title">{{ $isEdit ? 'Editar grupo' : 'Novo grupo' }}</h1>
                <p class="app-header__subtitle">
                    {{ $isEdit ? 'Atualize os dados do grupo de usuários.' : 'Preencha os dados para cadastrar um novo grupo.' }}
                </p>
            </div>
            @if ($isEdit)
                <button type="button" class="app-btn app-btn--secondary" onclick="loadContent('{{ route('pagina.lista.grupos') }}')">
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
                            Rotas de salvar/atualizar grupo ainda não foram criadas. Configure as rotas para concluir o envio do formulário.
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
                        <button class="app-btn app-btn--secondary" type="button" onclick="loadContent('{{ route('pagina.lista.grupos') }}')">Cancelar</button>
                    @endunless
                    @if ($isEdit)
                        <button
                            type="submit"
                            class="app-btn app-btn--danger"
                            formaction="{{ route('pagina.deletar.grupos', ['id' => $grupo->id]) }}"
                            name="_method"
                            value="DELETE"
                            onclick="return confirm('Excluir este grupo permanentemente?')">
                            Excluir grupo
                        </button>
                    @endif
                    <button class="app-btn app-btn--primary" type="submit">
                        {{ $isEdit ? 'Salvar alterações' : 'Cadastrar' }}
                    </button>
                </div>

                <div class="app-form-hero">
                    <strong>{{ old('str_nome', $grupo->str_nome ?? 'Novo grupo') }}</strong>
                </div>

                <div class="app-form-body">
                    <div class="app-section-title">Identificação</div>
                    <div class="app-field-group app-field-group--full">
                        <div class="app-field">
                            <label for="str_nome">Nome do grupo</label>
                            <input type="text" id="str_nome" name="str_nome" maxlength="150" required
                                value="{{ old('str_nome', $grupo->str_nome ?? '') }}"
                                placeholder="Ex: Varejo, Atacado, VIP...">
                        </div>
                    </div>

                    <div class="app-section-title">Status</div>
                    <div class="app-field-group">
                        <div class="app-field">
                            <label for="is_active">Ativo</label>
                            <select id="is_active" name="is_active">
                                <option value="1" {{ old('is_active', $grupo->is_active ?? 1) == 1 ? 'selected' : '' }}>Sim</option>
                                <option value="0" {{ old('is_active', $grupo->is_active ?? 1) == 0 ? 'selected' : '' }}>Não</option>
                            </select>
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
