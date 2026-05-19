# SAFE - Prot�tipo de Autoriza��o Escolar

Este reposit�rio cont�m o prot�tipo SAFE, um sistema de pr�-autoriza��o escolar desenvolvido em Laravel.

## Funcionalidades

- Login e cadastro de usu�rio.
- Tr�s perfis de acesso: Respons�vel, Professor e Portaria.
- Fluxo de pr�-autoriza��o com valida��o em sala e confirma��o f�sica.
- Notifica��es simuladas:
  - E-mail enviado via Mailpit.
  - WhatsApp simulado via `Log::info()`.

## Estrutura de telas

1. **Home**: bot�o de login, t�tulo, proposta e tema.
2. **Painel Respons�vel**: resumo em gr�fico de entradas/sa�das, tabela de pr�-autoriza��o e bot�o �Nova Pr�-autoriza��o�.
3. **Painel Professor**: aprova��o de solicita��es de entrada/sa�da e hist�rico de confirma��es.
4. **Painel Portaria**: confirma��es de sa�da e hist�rico de sa�das.

## Usu�rios pr�-definidos

| Perfil | E-mail | Senha |
|---|---|---|
| Respons�vel | `responsavel@safe.local` | `password` |
| Professor | `professor@safe.local` | `password` |
| Portaria | `portaria@safe.local` | `password` |

## Como usar

1. Instale depend�ncias:

```bash
composer install
```

2. Crie o arquivo `.env` e gere a chave de aplica��o:

```bash
copy .env.example .env
php artisan key:generate
```

3. Execute as migrations e a seed de usu�rios:

```bash
php artisan migrate
php artisan db:seed
```

4. Inicie o servidor local:

```bash
php artisan serve
```

5. Acesse o sistema em `http://127.0.0.1:8000`.

## Notas

- O cadastro de novos usuários permite selecionar um cargo: Responsável, Professor ou Portaria.
- A entrada � confirmada automaticamente ap�s a aprova��o do professor.
- A sa�da precisa ser aprovada pelo professor e confirmada pela portaria.

## Licen�a

Este projeto � distribu�do sob a licen�a MIT.
