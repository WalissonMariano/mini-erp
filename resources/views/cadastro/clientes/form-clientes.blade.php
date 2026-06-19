@php
    $isEdit = isset($cliente);
    $hasStoreRoute = Route::has('pagina.armazenar.cliente');
    $hasUpdateRoute = $isEdit && Route::has('pagina.atualizar.cliente');

    if ($isEdit && $hasUpdateRoute) {
        $formAction = route('pagina.atualizar.cliente', ['id' => $cliente->id]);
    } elseif (!$isEdit && $hasStoreRoute) {
        $formAction = route('pagina.armazenar.cliente');
    } else {
        $formAction = '#';
    }

    $empresasLista = collect($empresas ?? []);
    if ($empresasLista->isEmpty() && isset($empresa)) {
        $empresasLista = collect([$empresa]);
    }
@endphp

@vite('resources/css/app.css')
<div class="app-shell">
    <div class="app-page">
        <header class="app-header">
            <div class="app-header__text">
                <p class="app-header__eyebrow">Cadastro</p>
                <h1 class="app-header__title">{{ $isEdit ? 'Editar cliente' : 'Novo cliente' }}</h1>
                <p class="app-header__subtitle">
                    {{ $isEdit ? 'Atualize os dados cadastrais do cliente.' : 'Preencha os dados para cadastrar um novo cliente.' }}
                </p>
            </div>
            @if ($isEdit)
                <button type="button" class="app-btn app-btn--secondary" onclick="loadContent('{{ route('pagina.lista.clientes') }}')">
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
                            Rotas de armazenar/atualizar cliente não foram localizadas. Configure as rotas para concluir o envio do formulário.
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
                        <button class="app-btn app-btn--secondary" type="button" onclick="loadContent('{{ route('pagina.lista.clientes') }}')">Cancelar</button>
                    @endunless
                    @if ($isEdit)
                        <button
                            type="submit"
                            class="app-btn app-btn--danger"
                            formaction="{{ route('pagina.deletar.cliente', ['id' => $cliente->id]) }}"
                            name="_method"
                            value="DELETE"
                            onclick="return confirm('Excluir este cliente permanentemente?')">
                            Excluir cliente
                        </button>
                    @endif
                    <button class="app-btn app-btn--primary" type="submit">
                        {{ $isEdit ? 'Salvar alterações' : 'Cadastrar' }}
                    </button>
                </div>

                <div class="app-form-hero">
                    <strong>{{ old('str_nome', $cliente->str_nome ?? 'Novo cliente') }}</strong>
                </div>

                <div class="app-form-body">
                    <div class="app-section-title">Identificação</div>
                    <div class="app-field-group">
                        <div class="app-field">
                            <label for="str_nome">Nome</label>
                            <input type="text" id="str_nome" name="str_nome" maxlength="150" required value="{{ old('str_nome', $cliente->str_nome ?? '') }}">
                        </div>
                        <div class="app-field">
                            <label for="str_cpf">CPF</label>
                            <input type="text" id="str_cpf" name="str_cpf" maxlength="14" required value="{{ old('str_cpf', $cliente->str_cpf ?? '') }}" placeholder="000.000.000-00">
                        </div>
                    </div>

                    <div class="app-section-title">Contato</div>
                    <div class="app-field-group">
                        <div class="app-field">
                            <label for="str_email">E-mail</label>
                            <input type="email" id="str_email" name="str_email" maxlength="120" required value="{{ old('str_email', $cliente->str_email ?? '') }}">
                        </div>
                        <div class="app-field">
                            <label for="str_telefone">Telefone</label>
                            <input type="text" id="str_telefone" name="str_telefone" maxlength="20" value="{{ old('str_telefone', $cliente->str_telefone ?? '') }}">
                        </div>
                    </div>

                    <div class="app-section-title">Endereço</div>
                    <div class="app-field-group app-field-group--three">
                        <div class="app-field">
                            <label for="str_logradouro">Logradouro</label>
                            <input type="text" id="str_logradouro" name="str_logradouro" maxlength="255" value="{{ old('str_logradouro', $cliente->str_logradouro ?? '') }}">
                        </div>
                        <div class="app-field">
                            <label for="str_numero">Número</label>
                            <input type="text" id="str_numero" name="str_numero" maxlength="20" value="{{ old('str_numero', $cliente->str_numero ?? '') }}">
                        </div>
                        <div class="app-field">
                            <label for="str_bairro">Bairro</label>
                            <input type="text" id="str_bairro" name="str_bairro" maxlength="100" value="{{ old('str_bairro', $cliente->str_bairro ?? '') }}">
                        </div>
                    </div>

                    <div class="app-field-group">
                        <div class="app-field">
                            <label for="str_cidade">Cidade</label>
                            <input type="text" id="str_cidade" name="str_cidade" maxlength="100" value="{{ old('str_cidade', $cliente->str_cidade ?? '') }}">
                        </div>
                        <div class="app-field">
                            <label for="str_estado">Estado</label>
                            <input type="text" id="str_estado" name="str_estado" maxlength="2" value="{{ old('str_estado', $cliente->str_estado ?? '') }}" placeholder="UF">
                        </div>
                    </div>

                    <div class="app-section-title">Vínculo</div>
                    <div class="app-field-group app-field-group--full">
                        <div class="app-field">
                            <label for="empresa_id">Empresa</label>
                            <select id="empresa_id" name="empresa_id" required>
                                <option value="">Selecione uma empresa</option>
                                @foreach ($empresasLista as $itemEmpresa)
                                    <option value="{{ $itemEmpresa->id }}" {{ old('empresa_id', $cliente->empresa_id ?? '') == $itemEmpresa->id ? 'selected' : '' }}>
                                        {{ $itemEmpresa->str_razao_social }}
                                    </option>
                                @endforeach
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
