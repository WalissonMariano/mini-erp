@php
    $isEdit = isset($usuario);
    $hasStoreRoute = Route::has('pagina.salvar.usuarios');
    $hasUpdateRoute = $isEdit && Route::has('pagina.atualizar.usuarios');

    if ($isEdit && $hasUpdateRoute) {
        $formAction = route('pagina.atualizar.usuarios', ['id' => $usuario->id]);
    } elseif (!$isEdit && $hasStoreRoute) {
        $formAction = route('pagina.salvar.usuarios');
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
                <h1 class="app-header__title">{{ $isEdit ? 'Editar usuário' : 'Novo usuário' }}</h1>
                <p class="app-header__subtitle">
                    {{ $isEdit ? 'Atualize os dados e permissões do usuário.' : 'Preencha os dados para cadastrar um novo usuário.' }}
                </p>
            </div>
            @if ($isEdit)
                <button type="button" class="app-btn app-btn--secondary" onclick="loadContent('{{ route('pagina.lista.usuarios') }}')">
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
                            Rotas de salvar/atualizar usuário ainda não foram criadas. Configure as rotas para concluir o envio do formulário.
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
                        <button class="app-btn app-btn--secondary" type="button" onclick="loadContent('{{ route('pagina.lista.usuarios') }}')">Cancelar</button>
                    @endunless
                    @if ($isEdit)
                        <button
                            type="submit"
                            class="app-btn app-btn--danger"
                            formaction="{{ route('pagina.deletar.usuarios', ['id' => $usuario->id]) }}"
                            name="_method"
                            value="DELETE"
                            onclick="return confirm('Excluir este usuário permanentemente?')">
                            Excluir usuário
                        </button>
                    @endif
                    <button class="app-btn app-btn--primary" type="submit">
                        {{ $isEdit ? 'Salvar alterações' : 'Cadastrar' }}
                    </button>
                </div>

                <div class="app-form-hero">
                    <strong>{{ old('str_nome', $usuario->str_nome ?? 'Novo usuário') }}</strong>
                </div>

                <div class="app-form-body">
                    <div class="app-section-title">Identificação</div>
                    <div class="app-field-group app-field-group--full">
                        <div class="app-field">
                            <label for="str_nome">Nome</label>
                            <input type="text" id="str_nome" name="str_nome" maxlength="150" required value="{{ old('str_nome', $usuario->str_nome ?? '') }}">
                        </div>
                    </div>

                    <div class="app-section-title">Contato</div>
                    <div class="app-field-group app-field-group--full">
                        <div class="app-field">
                            <label for="str_email">E-mail</label>
                            <input type="email" id="str_email" name="str_email" maxlength="120" required value="{{ old('str_email', $usuario->str_email ?? '') }}">
                        </div>
                    </div>

                    <div class="app-section-title">Segurança</div>
                    <div class="app-field-group app-field-group--full">
                        <div class="app-field">
                            <label for="str_password">{{ $isEdit ? 'Senha (deixe em branco para manter)' : 'Senha' }}</label>
                            <input type="password" id="str_password" name="str_password" minlength="6" {{ $isEdit ? '' : 'required' }}>
                        </div>
                    </div>

                    <div class="app-section-title">Vínculos</div>
                    <div class="app-field-group app-field-group--three">
                        <div class="app-field">
                            <label for="empresa_id">Empresa</label>
                            <select id="empresa_id" name="empresa_id" required>
                                <option value="">Selecione uma empresa</option>
                                @foreach (($empresas ?? collect()) as $empresa)
                                    <option value="{{ $empresa->id }}" {{ old('empresa_id', $usuario->empresa_id ?? '') == $empresa->id ? 'selected' : '' }}>
                                        {{ $empresa->str_razao_social }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="app-field">
                            <label for="grupo_id">Grupo</label>
                            <select id="grupo_id" name="grupo_id" required>
                                <option value="">Selecione um grupo</option>
                                @foreach (($grupos ?? collect()) as $grupo)
                                    <option value="{{ $grupo->id }}" {{ old('grupo_id', $usuario->grupo_id ?? '') == $grupo->id ? 'selected' : '' }}>
                                        {{ $grupo->str_nome }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="app-field">
                            <label for="is_active">Ativo</label>
                            <select id="is_active" name="is_active" required>
                                <option value="1" {{ old('is_active', $usuario->is_active ?? 1) == 1 ? 'selected' : '' }}>Sim</option>
                                <option value="0" {{ old('is_active', $usuario->is_active ?? 1) == 0 ? 'selected' : '' }}>Não</option>
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
