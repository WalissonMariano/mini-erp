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

<div style="padding: 0 20px 20px 20px; background-color: #ffffff; min-height: 100vh; font-family: Arial, sans-serif;">
    <style>
        * { font-family: Arial, sans-serif; }

        .card {
            background: white;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            padding: 24px;
            max-width: 800px;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 2px solid #ecf0f1;
        }

        .field-group {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .field-group.full {
            grid-template-columns: 1fr;
        }

        .field label {
            display: block;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            color: #7f8c8d;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }

        .field input,
        .field select,
        .field textarea {
            width: 100%;
            font-size: 15px;
            color: #2c3e50;
            padding: 8px 10px;
            background: #f8f9fa;
            border-radius: 4px;
            border: 1px solid #d9dee3;
            min-height: 36px;
            box-sizing: border-box;
        }

        .field input:focus,
        .field select:focus,
        .field textarea:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.15);
            background: #fff;
        }

        .field textarea {
            resize: vertical;
            min-height: 80px;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 20px 0 12px 0;
            padding-bottom: 6px;
            border-bottom: 1px solid #ecf0f1;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-primary { background-color: #3498db; color: white; }
        .btn-primary:hover { background-color: #2980b9; }

        .btn-secondary { background-color: #95a5a6; color: white; }
        .btn-secondary:hover { background-color: #7f8c8d; }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 24px;
            padding-top: 16px;
            border-top: 1px solid #ecf0f1;
        }

        .alert {
            margin-bottom: 16px;
            padding: 10px 12px;
            border-radius: 4px;
            font-size: 14px;
            border: 1px solid #f5c6cb;
            background: #fdecea;
            color: #a94442;
        }
    </style>

    <h2>{{ $isEdit ? '✏️ Editar Categoria' : '📁 Nova Categoria' }}</h2>

    <div class="card">
        @if ($formAction === '#')
            <div class="alert">
                Rotas de salvar/atualizar categoria ainda nao foram criadas. Configure as rotas para concluir o envio do formulario.
            </div>
        @endif

        <form action="{{ $formAction }}" method="POST">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <div class="card-header">
                <strong style="font-size: 18px; color: #2c3e50;">
                    {{ old('str_descricao', $categoria->str_descricao ?? 'Nova Categoria') }}
                </strong>
            </div>

            <div class="section-title">Descricao da Categoria</div>
            <div class="field-group full">
                <div class="field">
                    <label>Descricao</label>
                    <textarea name="str_descricao" maxlength="255" required
                        placeholder="Descreva a categoria de itens...">{{ old('str_descricao', $categoria->str_descricao ?? '') }}</textarea>
                </div>
            </div>

            <div class="actions">
                <button class="btn btn-secondary" type="button" onclick="history.back()">Cancelar</button>
                <button class="btn btn-primary" type="submit">
                    {{ $isEdit ? 'Salvar Alteracoes' : 'Cadastrar Categoria' }}
                </button>
            </div>
        </form>
    </div>
</div>
