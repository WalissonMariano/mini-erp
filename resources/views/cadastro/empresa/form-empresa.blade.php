@php
    $isEdit = isset($empresa);
    $hasStoreRoute = Route::has('pagina.salvar.empresa');
    $hasUpdateRoute = $isEdit && Route::has('pagina.atualizar.empresa');

    if ($isEdit && $hasUpdateRoute) {
        $formAction = route('pagina.atualizar.empresa', ['id' => $empresa->id]);
    } elseif (!$isEdit && $hasStoreRoute) {
        $formAction = route('pagina.salvar.empresa');
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
                <h1 class="app-header__title">{{ $isEdit ? 'Editar empresa' : 'Nova empresa' }}</h1>
                <p class="app-header__subtitle">
                    {{ $isEdit ? 'Atualize os dados cadastrais da empresa.' : 'Preencha os dados para cadastrar uma nova empresa.' }}
                </p>
            </div>
            @if ($isEdit)
                <button type="button" class="app-btn app-btn--secondary" onclick="loadContent('{{ route('pagina.lista.empresa') }}')">
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
                            Rotas de salvar/atualizar empresa ainda não foram criadas. Configure as rotas para concluir o envio do formulário.
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
                        <button class="app-btn app-btn--secondary" type="button" onclick="loadContent('{{ route('pagina.lista.empresa') }}')">Cancelar</button>
                    @endunless
                    @if ($isEdit)
                        <button
                            type="submit"
                            class="app-btn app-btn--danger"
                            formaction="{{ route('pagina.deletar.empresa', ['id' => $empresa->id]) }}"
                            name="_method"
                            value="DELETE"
                            onclick="return confirm('Excluir esta empresa permanentemente?')">
                            Excluir empresa
                        </button>
                    @endif
                    <button class="app-btn app-btn--primary" type="submit">
                        {{ $isEdit ? 'Salvar alterações' : 'Cadastrar' }}
                    </button>
                </div>

                <div class="app-form-hero">
                    <strong>{{ old('str_razao_social', $empresa->str_razao_social ?? 'Nova empresa') }}</strong>
                </div>

                <div class="app-form-body">
                    <div class="app-section-title">Identificação</div>
                    <div class="app-field-group">
                        <div class="app-field">
                            <label for="str_razao_social">Razão social</label>
                            <input type="text" id="str_razao_social" name="str_razao_social" maxlength="150" required value="{{ old('str_razao_social', $empresa->str_razao_social ?? '') }}">
                        </div>
                        <div class="app-field">
                            <label for="str_nome_fantasia">Nome fantasia</label>
                            <input type="text" id="str_nome_fantasia" name="str_nome_fantasia" maxlength="150" value="{{ old('str_nome_fantasia', $empresa->str_nome_fantasia ?? '') }}">
                        </div>
                    </div>

                    <div class="app-field-group app-field-group--three">
                        <div class="app-field">
                            <label for="str_cnpj">CNPJ</label>
                            <input type="text" id="str_cnpj" name="str_cnpj" maxlength="18" required value="{{ old('str_cnpj', $empresa->str_cnpj ?? '') }}">
                        </div>
                        <div class="app-field">
                            <label for="str_inscricao_estadual">Inscrição estadual</label>
                            <input type="text" id="str_inscricao_estadual" name="str_inscricao_estadual" maxlength="30" value="{{ old('str_inscricao_estadual', $empresa->str_inscricao_estadual ?? '') }}">
                        </div>
                        <div class="app-field">
                            <label for="str_inscricao_municipal">Inscrição municipal</label>
                            <input type="text" id="str_inscricao_municipal" name="str_inscricao_municipal" maxlength="30" value="{{ old('str_inscricao_municipal', $empresa->str_inscricao_municipal ?? '') }}">
                        </div>
                    </div>

                    <div class="app-section-title">Contato</div>
                    <div class="app-field-group app-field-group--three">
                        <div class="app-field">
                            <label for="str_email">E-mail</label>
                            <input type="email" id="str_email" name="str_email" maxlength="120" value="{{ old('str_email', $empresa->str_email ?? '') }}">
                        </div>
                        <div class="app-field">
                            <label for="str_telefone">Telefone</label>
                            <input type="text" id="str_telefone" name="str_telefone" maxlength="20" value="{{ old('str_telefone', $empresa->str_telefone ?? '') }}">
                        </div>
                        <div class="app-field">
                            <label for="str_celular">Celular</label>
                            <input type="text" id="str_celular" name="str_celular" maxlength="20" value="{{ old('str_celular', $empresa->str_celular ?? '') }}">
                        </div>
                    </div>

                    <div class="app-section-title">Endereço</div>
                    <div class="app-field-group">
                        <div class="app-field">
                            <label for="str_logradouro">Logradouro</label>
                            <input type="text" id="str_logradouro" name="str_logradouro" maxlength="200" value="{{ old('str_logradouro', $empresa->str_logradouro ?? '') }}">
                        </div>
                        <div class="app-field">
                            <label for="int_numero">Número</label>
                            <input type="text" id="int_numero" name="int_numero" maxlength="10" value="{{ old('int_numero', $empresa->int_numero ?? '') }}" placeholder="Número">
                        </div>
                    </div>

                    <div class="app-field-group app-field-group--three">
                        <div class="app-field">
                            <label for="str_bairro">Bairro</label>
                            <input type="text" id="str_bairro" name="str_bairro" maxlength="120" value="{{ old('str_bairro', $empresa->str_bairro ?? '') }}">
                        </div>
                        <div class="app-field">
                            <label for="str_cidade">Cidade</label>
                            <input type="text" id="str_cidade" name="str_cidade" maxlength="120" value="{{ old('str_cidade', $empresa->str_cidade ?? '') }}">
                        </div>
                        <div class="app-field">
                            <label for="str_estado">Estado</label>
                            <input type="text" id="str_estado" name="str_estado" maxlength="2" value="{{ old('str_estado', $empresa->str_estado ?? '') }}" placeholder="UF">
                        </div>
                    </div>

                    <div class="app-field-group app-field-group--full">
                        <div class="app-field">
                            <label for="str_complemento">Complemento</label>
                            <input type="text" id="str_complemento" name="str_complemento" maxlength="120" value="{{ old('str_complemento', $empresa->str_complemento ?? '') }}">
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
