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
            --corp-success: #0f766e;
            --corp-success-hover: #0d9488;
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

        .corp-header__text {
            min-width: 0;
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
            max-width: 56ch;
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
            transition: background 0.2s ease, box-shadow 0.2s ease;
            white-space: nowrap;
        }

        .corp-btn--primary {
            background: var(--corp-accent);
            color: #fff;
            box-shadow: 0 1px 2px rgba(12, 74, 110, 0.25);
        }

        .corp-btn--primary:hover {
            background: var(--corp-accent-hover);
        }

        .corp-btn .corp-icon {
            width: 1rem;
            height: 1rem;
        }

        .corp-card {
            background: var(--corp-surface);
            border: 1px solid var(--corp-border);
            border-radius: var(--corp-radius);
            box-shadow: var(--corp-shadow);
            overflow: hidden;
        }

        .corp-table-wrap {
            overflow-x: auto;
        }

        .corp-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .corp-table thead th {
            text-align: left;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 0.6875rem;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--corp-text-muted);
            background: #f8fafc;
            border-bottom: 1px solid var(--corp-border);
        }

        .corp-table tbody td {
            padding: 13px 20px;
            border-bottom: 1px solid var(--corp-border);
            color: var(--corp-text);
            vertical-align: middle;
        }

        .corp-table tbody tr:last-child td {
            border-bottom: none;
        }

        .corp-table tbody tr:hover td {
            background: #fafbfc;
        }

        .corp-table th.col-preco,
        .corp-table td.col-preco {
            text-align: right;
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }

        .corp-table th.col-acoes,
        .corp-table td.col-acoes {
            width: 72px;
            text-align: center;
        }

        .corp-table td.col-acoes {
            padding-left: 16px;
            padding-right: 16px;
        }

        .corp-icon-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            padding: 0;
            border: 1px solid var(--corp-border);
            border-radius: 8px;
            background: #fff;
            color: var(--corp-accent-soft);
            cursor: pointer;
            transition: background 0.15s ease, border-color 0.15s ease, color 0.15s ease;
        }

        .corp-icon-btn:hover {
            background: #f0f9ff;
            border-color: #bae6fd;
            color: var(--corp-accent);
        }

        .corp-icon-btn .corp-icon {
            width: 1.1rem;
            height: 1.1rem;
        }

        .corp-empty td {
            text-align: center;
            color: var(--corp-text-muted);
            font-size: 0.875rem;
            padding: 28px 20px !important;
        }

        @media (max-width: 640px) {
            .corp-shell {
                padding: 12px 16px 24px;
            }

            .corp-header {
                flex-direction: column;
                align-items: stretch;
            }

            .corp-btn {
                width: 100%;
            }
        }
    </style>

    <header class="corp-header">
        <div class="corp-header__text">
            <p class="corp-header__eyebrow">Estoque</p>
            <h1 class="corp-header__title">
                <x-icon name="heroicon-o-cube" class="corp-icon" />
                Itens
            </h1>
        </div>
        <button onclick="loadContent('{{ route('pagina.cadastro.itens') }}')" class="corp-btn corp-btn--primary" type="button" title="Novo item">
            <x-icon name="heroicon-o-plus" class="corp-icon" />
            Novo item
        </button>
    </header>

    <div class="corp-card">
        <div class="corp-table-wrap">
            <table class="corp-table">
                <thead>
                    <tr>
                        <th class="col-acoes">Editar</th>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th class="col-preco">Preço</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($itens as $item)
                        <tr>
                            <td class="col-acoes">
                                <button onclick="loadContent('{{ route('pagina.editar.itens', ['id' => $item->id]) }}')" class="corp-icon-btn" type="button" title="Editar item">
                                    <x-icon name="heroicon-o-pencil-square" class="corp-icon" />
                                </button>
                            </td>
                            <td>{{ $item->str_codigo }}</td>
                            <td>{{ $item->str_descricao }}</td>
                            <td>{{ $item->categoria?->str_descricao ?? '—' }}</td>
                            <td class="col-preco">R$ {{ number_format((float) $item->dbl_preco, 2, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr class="corp-empty">
                            <td colspan="5">Nenhum item cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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
