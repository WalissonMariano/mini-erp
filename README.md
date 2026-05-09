# Mini ERP
Este é um projeto de um Mini ERP (Enterprise Resource Planning) desenvolvido para fins educacionais. O objetivo deste projeto é fornecer uma solução simples e eficiente para a gestão de recursos empresariais, incluindo controle de estoque, vendas, compras e finanças.

## Funcionalidades
- **Controle de Estoque**: Permite gerenciar o estoque de produtos, incluindo entradas, saídas e níveis de estoque.
- **Gestão de Vendas**: Facilita o processo de vendas, desde a criação de pedidos até a emissão de notas fiscais.
- **Gestão de Compras**: Permite o controle de compras, incluindo fornecedores, pedidos de compra e recebimento de mercadorias.
- **Gestão Financeira**: Oferece ferramentas para controle financeiro, como fluxo de caixa, contas a pagar e contas a receber.
- **Relatórios**: Gera relatórios detalhados sobre vendas, estoque, finanças e outros aspectos do negócio.

## Tecnologias Utilizadas
- **Backend**: Laravel (PHP)
- **Frontend**: Blade (Laravel Templating Engine)
- **Banco de Dados**: PostgreSQL
- **Autenticação**: Laravel Sanctum
- **Hospedagem**: Heroku (opcional)

## Instalação
1. Clone o repositório:
```bash
git clone <URL_DO_REPOSITORIO>
```
2. Navegue até o diretório do projeto:
```bashcd mini-erp
```
3. Instale as dependências:
```bashnpm install
```
4. Configure as variáveis de ambiente (exemplo `.env`):
```envMONGO_URI=your_mongodb_uri
JWT_SECRET=your_jwt_secret
```
5. Inicie o servidor:
```bashnpm start
```
6. Acesse a aplicação em `http://localhost:3000`.       
## Contribuição
Contribuições são bem-vindas! Se você deseja contribuir para este projeto, por favor siga os passos abaixo:
1. Fork este repositório.
2. Crie uma branch para sua feature ou correção de bug:
```bashgit checkout -b minha-feature
```
3. Faça suas alterações e commit:
```bashgit commit -m "Descrição da minha feature ou correção de bug"
```
4. Envie suas alterações para o repositório remoto:
```bashgit push origin minha-feature
```
5. Abra um Pull Request para revisão.
## Licença
Este projeto está licenciado sob a Licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.   ## Contato
Se você tiver alguma dúvida ou sugestão, sinta-se à vontade para entrar em contato:
