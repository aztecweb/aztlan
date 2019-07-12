## Instalação

Instala todas as dependências necessárias para gerenciar os assets do projeto. Esse comando deve ser rodado dentro do diretório `/enviroment` que contém os docker-compose.

```
docker-compose run --rm assets-node npm install
```

## Desenvolvimento

Compila os assets em modo de desenvolvimento:

```
docker-compose run --rm assets-node npm run watch
```

## Production

Compila os assets em modo de produção:

```
docker-compose run --rm assets-node npm run build
```

## Qualidade de código

### Stylint

Verifica erros na padronização do código do Stylus:

```
docker-compose run --rm assets-node npx stylint stylus/
```
