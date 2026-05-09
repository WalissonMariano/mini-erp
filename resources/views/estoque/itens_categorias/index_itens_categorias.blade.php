<div style="padding: 0 20px 20px 20px; background-color: #ffffff; min-height: 100vh; font-family: Arial, sans-serif;">
    <style>
        * { font-family: Arial, sans-serif; }

        .table-wrapper {
            background: white;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .subtitle {
            color: #7f8c8d;
            font-size: 14px;
        }

        .new-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 14px;
            border: none;
            border-radius: 4px;
            background-color: #27ae60;
            color: white;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .new-btn:hover {
            background-color: #1f8c4d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background-color: #34495e;
            color: white;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ecf0f1;
            vertical-align: middle;
        }

        tbody tr:hover {
            background-color: #f8f9fa;
        }

        .acoes {
            width: 70px;
        }

        .edit-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 4px;
            background-color: #3498db;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        .edit-btn:hover {
            background-color: #2980b9;
        }

        .status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: bold;
            background-color: #eaf7ee;
            color: #1e8449;
        }
    </style>

    <div class="header-bar">
        <div>
            <h2 style="margin: 0 0 4px 0;"> Cadastro de Categorias de Itens</h2>
            <div class="subtitle">Grade com todas as categorias cadastradas</div>
        </div>
        <button onclick="loadContent('{{ route('pagina.cadastro.itens_categorias') }}')" class="new-btn" type="button" title="Nova categoria">
            + Nova Categoria
        </button>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th class="acoes">Editar</th>
                    <th>Descrição</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($itensCategorias as $categoria)

                    <tr>
                        <td>
                            <button onclick="loadContent('{{ route('pagina.editar.itens_categorias', ['id' => $categoria->id]) }}')" class="edit-btn" type="button" title="Editar categoria">
                                ✏️
                            </button>
                        </td>
                        <td>{{ $categoria->str_descricao }}</td>
                @endforeach

            </tbody>
        </table>
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

        // Carrega o conteúdo no iframe
        window.parent.document.getElementById('content-frame').src = url;
    
        // Após trocar o conteúdo, garante recalculo de largura interna.
       setTimeout(refreshIframeLayout, 200);

    }

</script>