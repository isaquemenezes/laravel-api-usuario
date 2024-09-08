<!DOCTYPE html>
<html>
<head>
    <title>Dados do Usuário</title>
</head>
<body>
    <h1>Dados do Usuário</h1>
    <p><strong>Nome:</strong> {{ $user->nome }}</p>
    <p><strong>E-mail:</strong> {{ $user->email }}</p>
    <p><strong>CPF:</strong> {{ $user->cpf }}</p>
    <p><strong>Data de Nascimento:</strong> {{ $user->data_nascimento }}</p>
    <p><strong>Telefone:</strong> {{ $user->telefone }}</p>
    <p><strong>CEP:</strong> {{ $user->cep }}</p>
    <p><strong>Estado:</strong> {{ $user->estado }}</p>
    <p><strong>Cidade:</strong> {{ $user->cidade }}</p>
    <p><strong>Bairro:</strong> {{ $user->bairro }}</p>
    <p><strong>Endereço:</strong> {{ $user->endereco }}</p>
</body>
</html>
