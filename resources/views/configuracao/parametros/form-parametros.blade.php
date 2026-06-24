@php
    $parametro = $parametro ?? null;
    $isEdit = $parametro !== null;
    $hasStoreRoute = Route::has('pagina.salvar.parametros');
    $hasUpdateRoute = $isEdit && Route::has('pagina.atualizar.parametros');

    if ($isEdit && $hasUpdateRoute) {
        $formAction = route('pagina.atualizar.parametros', ['id' => $parametro->id]);
    } elseif (! $isEdit && $hasStoreRoute) {
        $formAction = route('pagina.salvar.parametros');
    } else {
        $formAction = '#';
    }

    $geraFinanceiro = old('is_gera_financeiro', $isEdit ? ($parametro->is_gera_financeiro ? '1' : '0') : '0');
@endphp

@vite('resources/css/app.css')
<div class="app-shell">
    <div class="app-page">
        <header class="app-header">
            <div class="app-header__text">
                <p class="app-header__eyebrow">Configuração</p>
                <h1 class="app-header__title">Parâmetros</h1>
                <p class="app-header__subtitle">Configurações gerais do sistema</p>
            </div>
        </header>

        <div class="app-form">
            @if ($formAction === '#' || $errors->any())
                <div class="app-form__alerts">
                    @if ($formAction === '#')
                        <div class="app-alert app-alert--warn">
                            Rotas de salvar/atualizar parâmetros não foram localizadas.
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
                    <button class="app-btn app-btn--primary" type="submit">
                        Salvar parâmetros
                    </button>
                </div>

                <div class="app-form-hero">
                    <strong>Parâmetros do sistema</strong>
                </div>

                <div class="app-form-body">
                    <div class="app-section-title">Financeiro</div>
                    <div class="app-field-group app-field-group--full">
                        <div class="app-field">
                            <label for="is_gera_financeiro">Gerar financeiro ao baixar pedido de venda ou compra</label>
                            <select id="is_gera_financeiro" name="is_gera_financeiro" required>
                                <option value="1" {{ (string) $geraFinanceiro === '1' ? 'selected' : '' }}>Sim</option>
                                <option value="0" {{ (string) $geraFinanceiro === '0' ? 'selected' : '' }}>Não</option>
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
